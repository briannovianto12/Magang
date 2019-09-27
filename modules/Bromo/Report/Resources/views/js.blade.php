<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function () {
        loadReportPublishedProduct();

        $('#product_published_tab').on('click', function () {
            loadReportPublishedProduct();
        });

        function loadReportPublishedProduct() {

            if (!$.fn.dataTable.isDataTable('#product_report')) {
                $('#product_report').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: "{{ route('report.published') }}",
                    order: [],
                    scrollX: true,
                    dom: "<'row'<'col-sm-6 text-left'l><'col-sm-6 text-right'B>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    buttons: [
                        {'extend': 'reload', 'text': '<i class="la la-refresh"></i> <span>Reload</span>'}
                    ],
                    columns: [{
                        'data': 'DT_RowIndex',
                        'name': 'DT_RowIndex',
                        'orderable': false,
                        'searchable': true,
                        'width': '10%'
                    }, {
                        'data': 'shop_name', 'name': 'shop_name'
                    }, {
                        'data': 'full_name', 'name': 'full_name'
                    }, {
                        'data': 'msisdn', 'name': 'msisdn'
                    }, {
                        'data': 'address_line', 'name': 'address_line'
                    }, {
                        'data': 'count', 'name': 'count'
                    }, {
                        
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


        @isset($data)
        if ("{{ route('report.show', $data->id) }}" === "{{ url()->current() }}") {
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
        
    });
</script>