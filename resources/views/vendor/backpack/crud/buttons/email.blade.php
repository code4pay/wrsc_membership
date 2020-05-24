<a href="javascript:void(0)" onclick="importTransaction(this)" data-route="{{ url('/email_renewals') }}" class="btn btn-xs btn-success"><i class="fa fa-envelope"></i> Email Renewals</a>

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
          var users= [];
          bulk.each(function(){ users.push(this.dataset.primaryKeyValue)});
          if (!confirm("You are about to email " + users.length + " members ?")) {
                return false;
          } 
         
         // bulk.each(function(e){ console.log(this.dataset.primaryKeyValue) })
          $.ajax({
              url: route,
              type: 'POST',
              data: {'users':users},
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

                  //crud.table.ajax.reload();
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