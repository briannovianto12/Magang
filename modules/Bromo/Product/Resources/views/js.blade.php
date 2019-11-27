<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function () {
        loadApprovedProduct();

        $('#submited_tab').on('click', function () {
            loadSubmitedProduct();
        });

        $('#rejected_tab').on('click', function () {
            loadRejectedProduct();
        });

        $('#approved_tab').on('click', function () {
            loadApprovedProduct();
        });

        function loadSubmitedProduct() {

            if (!$.fn.dataTable.isDataTable('#product_submit')) {
                $('#product_submit').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: "{{ route('product.submited') }}",
                    order: [],
                    scrollX: true,
                    dom: "<'row' <'col-sm-2 text-left'f> <'col-sm-2 text-left'l> <'col-sm-8 text-right'B>    >" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    buttons: [
                        {'extend': 'reload', 'text': '<i class="la la-refresh"></i> <span>Reload</span>'}
                    ],
                    columns: [{
                        'data': 'action',
                        'name': 'action',
                        'width': '50px',
                        'searchable': true,
                        'orderable': false,
                        'exportable': false,
                        'printable': false,
                        'footer': 'Action'
                    },
                    {
                        'data': 'DT_RowIndex',
                        'name': 'DT_RowIndex',
                        'orderable': false,
                        'searchable': false,
                        'width': '50px'
                    }, {
                        'data': 'id', 'name': 'id'
                    }, {
                        'data': 'sku', 'name': 'sku', 'searchable': true
                    }, {
                        'data': 'name', 'name': 'name', 'searchable': true
                    }, {
                        'data': 'shop_name', 'name': 'shop.name', 'searchable': true
                    }, {
                        // //     'data': 'condition_type', 'name': 'condition_type'
                        // // }, {
                        // //     'data': 'display_price', 'name': 'display_price'
                        // // }, {
                        'data': 'category', 'name': 'category'
                    }, {
                        'data': 'updated_at', 'name': 'updated_at'
                    }, {
                        'data': 'weight', 'name': 'weight'
                    }, {
                        'data': 'status', 'name': 'status'
                    }],
                     responsive: {
                        details: {
                            type: 'column',
                            target: 'tr',
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function (row) {
                                    var data = row.data();
                                    return 'Details for ' + data.name;
                                }
                            }),
                            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                                tableClass: 'table'
                            })
                        }
                    }
                }); 
                    $("#myModal").on('show.bs.modal', function (e) {
                    var triggerLink = $(e.relatedTarget);
                    var id = triggerLink.data("id");
                    var title = triggerLink.data("title");

                    $("#modalTitle").text(title);
                    $(this).find(".modal-body").html("<h5>id: "+id+"</h5>");
                    }
                    );
            }

        }

        function loadRejectedProduct() {

            if (!$.fn.dataTable.isDataTable('#product_reject')) {
                $('#product_reject').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: "{{ route('product.rejected') }}",
                    order: [],
                    scrollX: true,
                    dom: "<'row' <'col-sm-2 text-left'f> <'col-sm-2 text-left'l> <'col-sm-8 text-right'B>    >" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    buttons: [
                        {'extend': 'reload', 'text': '<i class="la la-refresh"></i> <span>Reload</span>'}
                    ],
                    columns: [{
                        'data': 'action',
                        'name': 'action',
                        'width': '50px',
                        'searchable': true,
                        'orderable': false,
                        'exportable': false,
                        'printable': false,
                        'footer': 'Action'
                    },
                    {
                        'data': 'DT_RowIndex',
                        'name': 'DT_RowIndex',
                        'orderable': false,
                        'searchable': false,
                        'width': '50px'
                    }, {
                        'data': 'id', 'name': 'id'
                    }, {
                        'data': 'sku', 'name': 'sku', 'searchable': true
                    }, {
                        'data': 'name', 'name': 'name', 'searchable': true
                    }, {
                        'data': 'shop_name', 'name': 'shop.name', 'searchable': true
                    }, {
                        // //     'data': 'condition_type', 'name': 'condition_type'
                        // // }, {
                        // //     'data': 'display_price', 'name': 'display_price'
                        // // }, {
                        'data': 'category', 'name': 'category'
                    }, {
                        'data': 'updated_at', 'name': 'updated_at'
                    }, {
                        'data': 'weight', 'name': 'weight'
                    }, {
                        'data': 'status', 'name': 'status'
                    }]
                });
            }

        }

        function loadApprovedProduct() {

            if (!$.fn.dataTable.isDataTable('#product_approve')) {
                $('#product_approve').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: "{{ route('product.approved') }}",
                    order: [],
                    scrollX: true,
                    dom: "<'row' <'col-sm-2 text-left'f> <'col-sm-2 text-left'l> <'col-sm-8 text-right'B>    >" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    buttons: [
                        {'extend': 'reload', 'text': '<i class="la la-refresh"></i> <span>Reload</span>'}
                    ],
                    columns: [
                    {
                        'data': 'action',
                        'name': 'action',
                        'width': '50px',
                        'searchable': true,
                        'orderable': false,
                        'exportable': false,
                        'printable': false,
                        'footer': 'Action'
                    }, {
                        'data': 'id', 'name': 'id'
                    }, {
                        'data': 'sku', 'name': 'sku', 'searchable': true
                    }, {
                        'data': 'name', 'name': 'name', 'searchable': true
                    }, {
                        'data': 'shop_name', 'name': 'shop.name', 'searchable': true
                    }, {
                        // //     'data': 'condition_type', 'name': 'condition_type'
                        // // }, {
                        // //     'data': 'display_price', 'name': 'display_price'
                        // // }, {
                        'data': 'category', 'name': 'category'
                    }, {
                        'data': 'updated_at', 'name': 'updated_at'
                    }, {
                        'data': 'weight',
                        'name': 'weight',
                        'width': '50px',
                        'searchable': true,
                        'orderable': false,
                        'exportable': false,
                        'printable': false,
                        'footer': 'weigth'
                    }, {
                        'data': 'status', 'name': 'status'
                    }]
                });
            }

        }

        @isset($data)
        if ("{{ route('product.show', $data->id) }}" === "{{ url()->current() }}") {
            var switchEl = $('#status');

            switchEl.on('change', function () {
                $('#modal').modal('show');
            });

            $('#cancel').on('click', function () {
                if ("{{ $data->status }}" == "{{ \Bromo\Product\Models\ProductStatus::PUBLISH }}") {
                    switchEl.prop('checked', true);
                } else {
                    switchEl.prop('checked', false);
                }

                $('#modal').modal('hide');
            });
        }
        @endisset

        @isset($data)
        if ("{{ route('product.edit', $data->id) }}" === "{{ url()->current() }}") {
            // var switchEl = $('#status');

            switchEl.on('change', function () {
                $('#modal').modal('show');
            });

            $('#cancel').on('click', function () {
                $('#modal').modal('hide');
            });
        }
        @endisset
        
    });
</script>