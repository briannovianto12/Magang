<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var id = '{{ \Request::segment(3) }}';
        console.log(id);
        loadItem(id);

        function loadItem(id) {
            if (!$.fn.dataTable.isDataTable('#disb_item')) {
                $('#disb_item').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: "/disbursement/item/data/" + id,
                    order: [],
                    scrollX: true,
                    dom: "<'row' <'col-sm-11 text-right'f> <'col-sm-1 text-right'B>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    buttons: [
                        {'extend': 'reload', 'text': '<i class="la la-refresh"></i> <span>Reload</span>'}
                    ],
                    columns: [
                    {
                        'data': 'status', 'name': 'status', 'searchable': false, 'orderable': false
                    },
                    {
                        'data': 'amount_formatted', 'name': 'amount_formatted', 'searchable': false, 'orderable': false
                    }, {
                        'data': 'bank_code', 'name': 'bank_code', 'searchable': false, 'orderable': false
                    }, {
                        'data': 'bank_account_name', 'name': 'bank_account_name', 'searchable': false, 'orderable': false
                    }, {
                        'data': 'bank_account_number', 'name': 'bank_account_number', 'searchable': false, 'orderable': false
                    }, {
                        'data': 'description', 'name': 'description', 'searchable': false, 'orderable': false
                    }, {
                        'data': 'email', 'name': 'email', 'searchable': false, 'orderable': false
                    }, {
                        'data': 'email_cc', 'name': 'email_cc', 'searchable': false, 'orderable': false
                    }, {
                        'data': 'email_bcc', 'name': 'email_bcc', 'searchable': false, 'orderable': false
                    }, {
                        'data': 'external_id', 'name': 'external_id', 'searchable': false, 'orderable': false
                    }, {
                        'data': 'shop_name', 'name': 'shop_name', 'searchable': false, 'orderable': false
                    }]
                });
            }
        }
    });

    $('#processDisbursement').click(function(){
        if(!confirm('Are you sure ?')) {
          return
        }

        $("#processDisbursement").attr("disabled", true);
        $("#processDisbursement").html("Harap tunggu");

        swal({ 
        title: "Harap tunggu",
        showConfirmButton: false,
        });
        

    });
</script>