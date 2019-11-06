<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script type="text/javascript">
    var initColumns = [
        {'data': 'order_no', 'name': 'order_no', searchable:true},
        {'data': 'buyer_name', 'name': 'buyer_name'},
        {'data': 'seller_name', 'name': 'seller_name'},
        {'data': 'payment_amount_formatted', 'name': 'payment_amount'},
        {'data': 'payment_details_formatted', 'name': 'payment_details'},
        {'data': 'notes', 'name': 'notes', orderable: false, searchable: false},
        {'data': 'status_name', 'name': 'status_name', searchable: false},
        {'data': 'created_at', 'name': 'created_at'},
        {'data': 'updated_at', 'name': 'updated_at'},
        {'data': 'action', 'name': 'action'},
    ];

    var rejectedOrderColumns = [
        {'data': 'order_no', 'name': 'order_no', searchable:true},
        {'data': 'buyer_name', 'name': 'buyer_name'},
        {'data': 'seller_name', 'name': 'seller_name'},
        {'data': 'payment_amount_formatted', 'name': 'payment_amount'},
        {'data': 'payment_details_formatted', 'name': 'payment_details'},
        {'data': 'notes', 'name': 'notes', orderable: false, searchable: false},
        {'data': 'reject_notes', 'name': 'reject_notes', orderable: false, searchable: false},
        {'data': 'status_name', 'name': 'status_name', searchable: false},
        {'data': 'created_at', 'name': 'created_at'},
        {'data': 'updated_at', 'name': 'updated_at'},
        {'data': 'action', 'name': 'action'},
    ];

    let orderColumnsForUpdated = [
        [6, 'desc'],
        [7, 'desc']
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
            Order.loadDataTable('table_rejected_order', "{{ route("order.rejected-order") }}", rejectedOrderColumns, [[7, 'desc'],
        [8, 'desc']]);
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
                    dom:
                        "<'row'<'col-sm-8 text-left dataTables_pager'li> <'col-sm-3 text-right'f> <'col-sm-1 text-right'B>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-12 dataTables_pager'p>>",
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
        document.getElementById("po-table-status").addEventListener('change', function(){
            if(document.getElementById("po-table-status").value == "All"){
                $('#table_process_order').DataTable().destroy();
                Order.loadDataTable('table_process_order', "{{ route("order.process-order") }}", initColumns, orderColumnsForUpdated);
                $('#table_process_order').DataTable().draw();
            }
            else if(document.getElementById("po-table-status").value == "Payment OK"){
                $('#table_process_order').DataTable().destroy();
                Order.loadDataTable('table_process_order', "{{ route("order.paid-order") }}", initColumns, orderColumnsForUpdated);
                $('#table_process_order').DataTable().draw();
            }
            else if(document.getElementById("po-table-status").value == "Accepted"){
                $('#table_process_order').DataTable().destroy();
                Order.loadDataTable('table_process_order', "{{ route("order.accepted-order") }}", initColumns, orderColumnsForUpdated);
                $('#table_process_order').DataTable().draw();
            }
        });
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