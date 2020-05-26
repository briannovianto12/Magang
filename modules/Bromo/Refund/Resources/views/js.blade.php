<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{ nbs_asset('vendor/datatables/buttons.server-side.js') }}"></script> 


<script type="text/javascript">

    $(document).ready(function () {


        if ("{{ route('refund.index') }}" === "{{ url()->current() }}") {

            // Check current target
            var curr_url = document.location.href;
            var curr_target = curr_url.substring(curr_url.indexOf('#'))

            $('#order_refund').on('click', function () {
                loadRefundOrder();
            });


            _defaultScreen()

            function _defaultScreen(){
            $('#selectStatus').val('#order_refund')
            loadRefundOrder();
            }

            let orderColumnsForUpdated = [
                [6, 'desc'],
                [7, 'desc']
            ];

            function _screenResolver( curr_section ) {
                switch(curr_section) {
                    case "#order_refund": 
                        loadRefundOrder(); break;
                    default:
                        $('#selectStatus').val('#order_refund')    
                        $('a[role="tab"][href="#order_refund"]').click()
                        loadRefundOrder(); break;                        
                }
            }

            function loadRefundOrder() {

                if (!$.fn.dataTable.isDataTable('#order_refund')) {
                    $('#order_refund').DataTable({
                        serverSide: true,
                        processing: true,
                        ajax: "{{ route('refund.list') }}",
                        columns: [
                            { "data": "order_no", "name": "order_trx.order_no"},
                            { "data": "seller_name", "name": "shop.name"},
                            { "data": "buyer_name", "name": "user_profile.full_name"},
                            { "data": "payment_amount", "name": "order_refund.amount"},
                            { "data": "notes", "name": "order_refund.notes"},
                            { "data": "refund_date", "name": "order_refund.refund_date"},
                            { "data": "updated_at", "name": "order_trx.updated_at"},
                            { "data": "order_refunded", "name": "order_refund.order_refunded"},
                            { "data": "action"}
                        ],
                        order: [6, 'desc'],
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