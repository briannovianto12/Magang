<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script type="text/javascript">
    var initColumns = [
        {
            'data': 'DT_RowIndex', 'name': 'DT_RowIndex',
            'orderable': false, 'searchable': false, 'width': '50'
        },
        {'data': 'order_no', 'name': 'order_no'},
        {'data': 'buyer_name', 'name': 'buyer_name'},
        {'data': 'seller_name', 'name': 'seller_name'},
        {'data': 'payment_method', 'name': 'payment_method'},
        {'data': 'payment_amount_formatted', 'name': 'payment_amount'},
        {'data': 'notes_admin', 'name': 'notes_admin', orderable: false, searchable: false},
        {'data': 'status_name', 'name': 'status_name', searchable: false},
        {'data': 'created_at', 'name': 'created_at'},
        {'data': 'action', 'name': 'action', orderable: false, searchable: false}
    ];
    var updatedColumns = initColumns;
    updatedColumns[8] = {'data': 'updated_at', 'name': 'updated_at'};

    let orderColumnsForUpdated = [
        [7, 'desc'],
        [8, 'desc']
    ];

    var Columns = function (data) {
        if (data) {
            return data;
        } else {
            return initColumns;
        }

    };
    var Order = {
        loadNewOrder: function () {
            Order.loadDataTable('table_new_order', "{{ route('order.new-order') }}", initColumns, [
                [8, 'desc']
            ]);
        },
        loadProcessOrder: function () {
            Order.loadDataTable('table_process_order', "{{ route('order.process-order') }}", updatedColumns, orderColumnsForUpdated);
        },
        loadDeliveryOrder: function () {
            Order.loadDataTable('table_delivery_order', "{{ route('order.delivery-order') }}", updatedColumns, orderColumnsForUpdated);
        },
        loadSuccessOrder: function () {
            Order.loadDataTable('table_success_order', "{{ route('order.success-order') }}", updatedColumns, orderColumnsForUpdated);
        },
        loadCancelOrder: function () {
            Order.loadDataTable('table_cancel_order', "{{ route('order.cancel-order') }}", updatedColumns, orderColumnsForUpdated);
        },
        loadListOrder: function () {
            Order.loadDataTable('table_list_order', "{{ route('order.list-order') }}", initColumns, [
                [8, 'desc']
            ]);
        },
        loadDataTable: function (elem, route, getColumns, order = []) {
            if (!$.fn.dataTable.isDataTable("#" + elem)) {
                $("#" + elem).DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: route,
                    order: order,
                    scrollX: true,
                    dom: "<'row'<'col-sm-6 text-left'l><'col-sm-6 text-right'B>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    buttons: [
                        {'extend': 'reload', 'text': '<i class="la la-refresh"></i> <span>Reload</span>'}
                    ],
                    columns: new Columns(getColumns)
                });
            }
        },

        init: function () {
            Order.loadNewOrder();

            $('#process_order_tab').on('click', function () {
                Order.loadProcessOrder();
            });

            $('#delivery_order_tab').on('click', function () {
                Order.loadDeliveryOrder();
            });

            $('#success_order_tab').on('click', function () {
                Order.loadSuccessOrder();
            });

            $('#cancel_order_tab').on('click', function () {
                Order.loadCancelOrder();
            });

            $('#list_order_tab').on('click', function () {
                Order.loadListOrder();
            });
        }
    };

    $(document).ready(function () {
        Order.init();
    });
</script>