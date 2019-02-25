<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function () {
        loadSubmitedProduct();

        function loadSubmitedProduct() {

            if (!$.fn.dataTable.isDataTable('#product_submit')) {
                $('#product_submit').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: "{{ route('product.submited') }}",
                    order: [],
                    scrollX: true,
                    dom: "<'row'<'col-sm-6 text-left'l><'col-sm-6 text-right'B>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    buttons: [
                        {'extend': 'reload', 'text': '<i class="la la-refresh"></i> <span>Reload</span>'}
                    ],
                    column: [{
                        'data': 'DT_Row_Index',
                        'name': 'DT_Row_Index',
                        'orderable': false,
                        'searchable': false,
                        'width': '10%'
                    }, {
                        'data': 'id', 'name': 'id'
                    }, {
                        'data': 'ext_id', 'name': 'ext_id'
                    }, {
                        'data': 'name', 'name': 'name'
                    }, {
                        'data': 'shop_name', 'name': 'shop_name'
                    }, {
                        'data': 'unit_type', 'name': 'unit_type'
                    }, {
                        'data': 'display_price', 'name': 'display_price'
                    }, {
                        'data': 'product_type_id', 'name': 'product_type_id'
                    }, {
                        'data': 'created_at', 'name': 'created_at'
                    }, {
                        'data': 'status', 'name': 'status'
                    }, {
                        'data': 'action',
                        'name': 'action',
                        'width': '100px',
                        'searchable': false,
                        'orderable': false,
                        'exportable': false,
                        'printable': false,
                        'footer': 'Action'
                    }]
                });
            }

        }
    });
</script>