<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{ nbs_asset('vendor/datatables/buttons.server-side.js') }}"></script> 


<script type="text/javascript">

    $(document).ready(function () {

        if ("{{ route('master-courier.index') }}" === "{{ url()->current() }}") {

            $('#master_courier').on('click', function () {
                loadMasterCourier();
            });


            _defaultScreen()

            function _defaultScreen(){
            $('#selectStatus').val('#master_courier')
            loadMasterCourier();
            }

            let orderColumnsForUpdated = [
                [6, 'desc'],
                [7, 'desc']
            ];

            function _screenResolver( curr_section ) {
                switch(curr_section) {
                    case "#master_courier": 
                    loadMasterCourier(); break;
                    default:
                        $('#selectStatus').val('#master_courier')    
                        $('a[role="tab"][href="#master_courier"]').click()
                        loadMasterCourier(); break;                        
                }
            }

            function loadMasterCourier() {

                if (!$.fn.dataTable.isDataTable('#master_courier')) {
                    $('#master_courier').DataTable({
                        serverSide: true,
                        processing: true,
                        ajax: "{{ route('master-courier.data') }}",
                        columns: [
                            { "data": "provider_key"},
                            { "data": "name"},
                            { "data": "enabled"},
                            { "data": "updated_at"},
                            { "data": "action"}
                        ],
                        order: [2, 'desc'],
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
                    })
                }
            }
        }
    })

</script>