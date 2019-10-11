<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script type="text/javascript">
    var initColumns = [
        {
            'data': 'DT_RowIndex', 'name': 'DT_RowIndex',
            'orderable': false, 'searchable': false, 'width': '50'
        },
        {'data': 'order_no', 'name': 'order_no', searchacble:true},
        {'data': 'buyer_name', 'name': 'buyer_name'},
        {'data': 'seller_name', 'name': 'seller_name'},
        {'data': 'payment_method', 'name': 'payment_method'},
        {'data': 'payment_amount_formatted', 'name': 'payment_amount'},
        {'data': 'notes_admin', 'name': 'notes_admin', orderable: false, searchable: false},
        {'data': 'status_name', 'name': 'status_name', searchable: false},
        {'data': 'created_at', 'name': 'created_at'},
        {'data': 'updated_at', 'name': 'updated_at'},
        {'data': 'action', 'name': 'action', orderable: false, searchable: false}
    ];

    let orderColumnsForUpdated = [
        [8, 'desc'],
        [9, 'desc']
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
            Order.loadDataTable('table_new_order', "{{ route("order.new-order") }}", initColumns, orderColumnsForUpdated);
        },
        loadProcessOrder: function () {
            Order.loadDataTable('table_process_order', "{{ route("order.process-order") }}", initColumns, orderColumnsForUpdated);
        },
        loadDeliveryOrder: function () {
            Order.loadDataTable('table_delivery_order', "{{ route("order.delivery-order") }}", initColumns, orderColumnsForUpdated);
        },
        loadDeliveredOrder: function () {
            Order.loadDataTable('table_delivered_order', "{{ route("order.delivered-order") }}", initColumns, orderColumnsForUpdated);
        },
        loadSuccessOrder: function () {
            Order.loadDataTable('table_success_order', "{{ route("order.success-order") }}", initColumns, orderColumnsForUpdated);
        },
        loadCancelOrder: function () {
            Order.loadDataTable('table_cancel_order', "{{ route("order.cancel-order") }}", initColumns, orderColumnsForUpdated);
        },
        loadListOrder: function () {
            Order.loadDataTable('table_list_order', "{{ route("order.list-order") }}", initColumns, orderColumnsForUpdated);
        },
        loadRejectedOrder: function () {
            Order.loadDataTable('table_rejected_order', "{{ route("order.rejected-order") }}", initColumns, orderColumnsForUpdated);
        },
        loadDataTable: function (elem, route, getColumns, order = []) {
            if (!$.fn.dataTable.isDataTable("#" + elem)) {
                $("#" + elem).DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: route,
                    order: order,
                    scrollX: true,
                    searchable: true,
                    dom: "<'row'<'col-sm-8 text-left'l>    <'col-sm-3 text-right'f>  <'col-sm-1 text-right'B> >" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    buttons: [
                        {'extend': 'reload', 'text': '<i class="la la-refresh"></i> <span>Reload</span>'}
                    ],
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

            $('#delivered_order_tab').on('click', function () {
                Order.loadDeliveredOrder();
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

            $('#rejected_order_tab').on('click', function () {
                Order.loadRejectedOrder();
            });
        }
    };

    $(document).ready(function () {
        Order.init();
    });

    document.getElementById("origin-cpy-btn").addEventListener("click", copy_origin_address);
    document.getElementById("dest-cpy-btn").addEventListener("click", copy_destination_address);

    function copy_origin_address() {
        var copyText = document.getElementById("origin-address");
        var textArea = document.createElement("textarea");
        textArea.value = copyText.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        alert('Text Copied!');
    }

    function copy_destination_address() {
        var copyText = document.getElementById("destination-address");
        var textArea = document.createElement("textarea");
        textArea.value = copyText.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        alert('Text Copied!');
    }
</script>