<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')
<table class="table">
<thead>
<tr><th>Authority Name</th><th>Description</th><th>Date Authorised</th><tr>
@if (isset($field['value']))
@foreach ($field['value'] as  $attributes)
	<tr> <td>{{ $attributes->authority->name }} </td><td>{{ $attributes['comment'] }} </td><td>{{ $attributes['date_authorised'] }}</td>
	<td>
 
@can('Modify All') 
	<a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="/admin/authoritiesuser/{{ $attributes['id'] }}" class="btn btn-sm btn-link" data-button-type="delete"><i class="fa fa-trash"></i> {{ trans('backpack::crud.delete') }}</a>
@endcan
</td> </tr>


     @endforeach
@endif

@can('Modify All') 
	 <tr><td><a href="/admin/authoritiesuser/create?user_id={{ $entry->getKey() }}" class="btn btn-info" role="button">Add Authority</a></td><td></td><td></td></tr>
@endcan
</table>
@include('crud::fields.inc.wrapper_end')

@push('after_scripts') @if ($crud->getRequest()->ajax()) @endpush @endif
<script>

	if (typeof deleteEntry != 'function') {
	  $("[data-button-type=delete]").unbind('click');

	  function deleteEntry(button) {
		// ask for confirmation before deleting an item
		// e.preventDefault();
		var button = $(button);
		var route = button.attr('data-route');
		var row = $("#crudTable a[data-route='"+route+"']").closest('tr');

		swal({
		  title: "{!! trans('backpack::base.warning') !!}",
		  text: "{!! trans('backpack::crud.delete_confirm') !!}",
		  icon: "warning",
		  buttons: {
		  	cancel: {
			  text: "{!! trans('backpack::crud.cancel') !!}",
			  value: null,
			  visible: true,
			  className: "bg-secondary",
			  closeModal: true,
			},
		  	delete: {
			  text: "{!! trans('backpack::crud.delete') !!}",
			  value: true,
			  visible: true,
			  className: "bg-danger",
			}
		  },
		}).then((value) => {
			if (value) {
				$.ajax({
			      url: route,
			      type: 'DELETE',
			      success: function(result) {
			          if (result == 1) {
			          	  // Show a success notification bubble
			              new Noty({
		                    type: "success",
		                    text: "{!! '<strong>'.trans('backpack::crud.delete_confirmation_title').'</strong><br>'.trans('backpack::crud.delete_confirmation_message') !!}"
		                  }).show();

			              // Hide the modal, if any
			              $('.modal').modal('hide');
                          location.reload();

			              // Remove the row from the datatable
			              row.remove();
			          } else {
			              // if the result is an array, it means 
			              // we have notification bubbles to show
			          	  if (result instanceof Object) {
			          	  	// trigger one or more bubble notifications 
			          	  	Object.entries(result).forEach(function(entry, index) {
			          	  	  var type = entry[0];
			          	  	  entry[1].forEach(function(message, i) {
					          	  new Noty({
				                    type: type,
				                    text: message
				                  }).show();
			          	  	  });
			          	  	});
			          	  } else {// Show an error alert
				              swal({
				              	title: "{!! trans('backpack::crud.delete_confirmation_not_title') !!}",
	                            text: "{!! trans('backpack::crud.delete_confirmation_not_message') !!}",
				              	icon: "error",
				              	timer: 4000,
				              	buttons: false,
				              });
			          	  }			          	  
			          }
			      },
			      error: function(result) {
			          // Show an alert with the result
			          swal({
		              	title: "{!! trans('backpack::crud.delete_confirmation_not_title') !!}",
                        text: "{!! trans('backpack::crud.delete_confirmation_not_message') !!}",
		              	icon: "error",
		              	timer: 4000,
		              	buttons: false,
		              });
			      }
			  });
			}
		});

      }
	}

	// make it so that the function above is run after each DataTable draw event
	// crud.addFunctionToDataTablesDrawEventQueue('deleteEntry');
</script>
@if (!$crud->getRequest()->ajax()) @endpush @endif
