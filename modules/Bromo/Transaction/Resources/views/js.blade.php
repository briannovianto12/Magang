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

    var deliveryOrderColumns = [
        {'data': 'order_no', 'name': 'order_no', searchable:true},
        {'data': 'airwaybill', 'name': 'order_shipping_manifest.airwaybill'},
        {'data': 'special_id', 'name': 'special_id'},
        {'data': 'buyer_name', 'name': 'buyer_name'},
        {'data': 'seller_name', 'name': 'seller_name'},
        {'data': 'payment_amount_formatted', 'name': 'payment_amount'},
        {'data': 'payment_details_formatted', 'name': 'payment_details'},
        {'data': 'notes', 'name': 'notes', orderable: false, searchable: false},
        {'data': 'status_name', 'name': 'status_name', searchable: false},
        {'data': 'is_picked_up', 'name': 'status_name'},
        {'data': 'created_at', 'name': 'created_at'},
        {'data': 'updated_at', 'name': 'updated_at'},
        {'data': 'action', 'name': 'action'},
    ];

    var deliveredOrderColumns = [
        {'data': 'order_no', 'name': 'order_no', searchable:true},
        {'data': 'airwaybill', 'name': 'order_shipping_manifest.airwaybill'},
        {'data': 'special_id', 'name': 'special_id'},
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

    var successOrderColumns = [
        {'data': 'order_no', 'name': 'order_no', searchable:true},
        {'data': 'airwaybill', 'name': 'order_shipping_manifest.airwaybill'},
        {'data': 'special_id', 'name': 'special_id'},
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

    const orderColumnsForUpdated = [
        [8, 'desc'],
        [7, 'desc']
    ];

    const orderColumnsForOnDelivery = [
        [11, 'desc'],
        [10, 'desc']
    ];

    const orderColumnsForDelivered = [
        [10, 'desc'],
        [9, 'desc']
    ];

    const orderColumnsForSuccess = [
        [10, 'desc'],
        [9, 'desc']
    ];

    const orderColumnsForRejected = [
        [9, 'desc'],
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
            Order.loadDataTable('table_new_order', "{{ route("order.new-order") }}", initColumns, orderColumnsForUpdated);
        },
        loadProcessOrder: function () {
            Order.loadDataTable('table_process_order', "{{ route("order.process-order") }}", initColumns, orderColumnsForUpdated);
        },
        loadDeliveryOrder: function () {
            Order.loadDataTable('table_delivery_order', "{{ route("order.delivery-order") }}", deliveryOrderColumns, orderColumnsForOnDelivery);
        },
        loadDeliveredOrder: function () {
            Order.loadDataTable('table_delivered_order', "{{ route("order.delivered-order") }}", deliveredOrderColumns, orderColumnsForDelivered);
        },
        loadSuccessOrder: function () {
            Order.loadDataTable('table_success_order', "{{ route("order.success-order") }}", successOrderColumns, orderColumnsForSuccess);
        },
        loadCancelOrder: function () {
            Order.loadDataTable('table_cancel_order', "{{ route("order.cancel-order") }}", initColumns, orderColumnsForUpdated);
        },
        loadListOrder: function () {
            Order.loadDataTable('table_list_order', "{{ route("order.list-order") }}", initColumns, orderColumnsForUpdated);
        },
        loadRejectedOrder: function () {
            Order.loadDataTable('table_rejected_order', "{{ route("order.rejected-order") }}", rejectedOrderColumns, orderColumnsForRejected);
        },
        loadDataTable: function (elem, route, getColumns, order = []) {
            if (!$.fn.dataTable.isDataTable("#" + elem)) {
                const sessionDuration = {{config('transaction.datatable_session_duration')}};
                $("#" + elem).DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: route,
                    order: order,
                    scrollX: true,
                    searchable: true,
                    stateSave: true,
                    stateDuration: sessionDuration,
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
            $('#new_order_tab').on('click', function () {
                Order.loadNewOrder();
            });

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

            $('a[data-toggle="tab"]').on("click", function() {
                let newUrl;
                const hash = $(this).attr("href");
                location.hash = hash;
                window.sessionStorage["orderPrevTab"] = hash;
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

        document.getElementById("deliveryo-table-status").addEventListener('change', function(){
            if(document.getElementById("deliveryo-table-status").value == "All"){
                $('#table_delivery_order').DataTable().destroy();
                Order.loadDataTable('table_delivery_order', "{{ route("order.delivery-order") }}", deliveryOrderColumns, orderColumnsForOnDelivery);
                $('#table_delivery_order').DataTable().draw();
            }
            else if(document.getElementById("deliveryo-table-status").value == "true"){
                $('#table_delivery_order').DataTable().destroy();
                Order.loadDataTable('table_delivery_order', "{{ route("order.shipped-delivery-order") }}", deliveryOrderColumns, orderColumnsForOnDelivery);
                $('#table_delivery_order').DataTable().draw();
            }
            else if(document.getElementById("deliveryo-table-status").value == "false"){
                $('#table_delivery_order').DataTable().destroy();
                Order.loadDataTable('table_delivery_order', "{{ route("order.not-shipped-delivery-order") }}", deliveryOrderColumns, orderColumnsForOnDelivery);
                $('#table_delivery_order').DataTable().draw();
            }
        });

        if(window.sessionStorage["orderPrevTab"]){
            const prevTab = window.sessionStorage["orderPrevTab"];
            $('#tablist a[href="'+prevTab+'"]').click();
        }
        else{
            $('#tablist a[href="#new_order"]').click();
        }

        $('.tab-pane').on('click','button[name="awb-cpy-btn"]',function () {
            var copyText = this.parentNode.getElementsByTagName("SPAN")[0];
            var textArea = document.createElement("textarea");
            textArea.value = copyText.textContent;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("Copy");
            textArea.remove();
            alert('Text Copied!');
        });

        $('.tab-pane').on('click','button[name="pickup-cpy-btn"]',function () {
            var copyText = this.parentNode.getElementsByTagName("SPAN")[0];
            var textArea = document.createElement("textarea");
            textArea.value = copyText.textContent;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("Copy");
            textArea.remove();
            alert('Text Copied!');
        });
    });

    document.getElementById("origin-cpy-btn").addEventListener("click", copy_origin_address);
    document.getElementById("dest-cpy-btn").addEventListener("click", copy_destination_address);
    document.getElementsByName("va-cpy-btn").forEach(e => e.addEventListener("click", copy_va_number));
    document.getElementsByName("invoice-url-cpy-btn").forEach(e => e.addEventListener("click", copy_invoice_url));

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

    function copy_va_number() {
        var copyText = event.currentTarget.parentNode.getElementsByTagName("SPAN")[0];
        var textArea = document.createElement("textarea");
        textArea.value = copyText.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        alert('Text Copied!');
    }

    function copy_invoice_url() {
        var copyText = event.currentTarget.parentNode.getElementsByTagName("A")[0];
        var textArea = document.createElement("textarea");
        textArea.value = copyText.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        alert('Text Copied!');
    }

    function previewImage() {
        document.getElementById("image-preview").style.display = "block";
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("image-source").files[0]);

        oFReader.onload = function(oFREvent) {
        document.getElementById("image-preview").src = oFREvent.target.result;
        };
    };
</script>
