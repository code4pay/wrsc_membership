<a href="javascript:void(0)" onclick="importTransaction(this)" data-route="{{ url($crud->route.'/email') }}" class="btn btn-xs btn-default"><i class="fa fa-ban"></i> Moderate</a>

@push('after_scripts')
<script>
    if (typeof importTransaction != 'function') {
      $("[data-button-type=import]").unbind('click');

      function importTransaction(button) {
          // ask for confirmation before deleting an item
          // e.preventDefault();
          var button = $(button);
          var route = button.attr('data-route');
          var bulk = $(".crud_bulk_actions_row_checkbox:checked");
          var emails = [];
          bulk.each(function(){ emails.push(this.dataset.primaryKeyValue)});
         // bulk.each(function(e){ console.log(this.dataset.primaryKeyValue) })
          $.ajax({
              url: route,
              type: 'POST',
              data: {'ids':emails},
              success: function(result) {
                  // Show an alert with the result
                  console.log(result,route);
                  new PNotify({
                      title: "Import done", // add extra info how many
                      text: "Some Tx had been imported",
                      type: "success"
                  });

                  // Hide the modal, if any
                  $('.modal').modal('hide');

                  crud.table.ajax.reload();
              },
              error: function(result) {
                  // Show an alert with the result
                  new PNotify({
                      title: "Import failed",
                      text: "The new entry could not be created. Please try again.",
                      type: "warning"
                  });
              }
          });
      }
    }
</script>
@endpush