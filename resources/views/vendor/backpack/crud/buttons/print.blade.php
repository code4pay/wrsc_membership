<a href="javascript:void(0)" onclick="downloadFiles(this)" data-route="{{ url('/print_renewals') }}" class="btn btn-xs btn-success"><i class="fa fa-envelope"></i> Print Renewals</a>


@push('after_scripts')
<script>
    if (typeof downloadFiles != 'function') {
        $("[data-button-type=import]").unbind('click');

        function downloadFiles(button) {
            var button = $(button);
            var route = button.attr('data-route');
            var bulk = $(".crud_bulk_actions_row_checkbox:checked");
            var users = [];
            var type = 'Renewals';
            if (route.includes('print_membership_card')){ type = 'Cards'}
            bulk.each(function() {
                users.push({
                    'name': 'users[]',
                    'value': this.dataset.primaryKeyValue
                })
            });
            if (!confirm("You are about to download " + users.length + " Membership "+ type +" ?")) {

                return false;
            }
            submit(route, 'POST', users);

            function submit(action, method, values) {
                var form = $('<form/>', {
                    action: action,
                    method: method
                });
                $.each(values, function() {
                    form.append($('<input/>', {
                        type: 'hidden',
                        name: this.name,
                        value: this.value
                    }));
                });

                form.append($('{{ csrf_field() }}'));
                form.appendTo('body').submit();
            }
        }
    }
</script>
@endpush