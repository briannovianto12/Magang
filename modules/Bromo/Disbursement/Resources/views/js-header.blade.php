<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function () {
        loadHeader();

        function loadHeader() {
            if (!$.fn.dataTable.isDataTable('#disb_header')) {
                $('#disb_header').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: "{{ route('disbursement.header') }}",
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
                        'data': 'header_no', 'name': 'header_no', 'searchable': true, 'orderable': true
                    }, {
                        'data': 'status', 'name': 'status', 'searchable': true, 'orderable': true
                    }, {
                        'data': 'amount_formatted', 'name': 'amount_formatted' 
                    }, {
                        'data': 'created_at', 'name': 'created_at'
                    }, {
                        'data': 'total_item', 'name': 'total_item'
                    }, {
                        'data': 'remark', 'name': 'remark'
                    }, {
                        'data': 'name', 'name': 'admin.name'
                    }]
                });
            }
        }
    });
</script>