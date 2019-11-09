<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{ nbs_asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="{{ nbs_asset('js/lang.js') }}"></script>
<script src="{{ mix('js/logistic.js') }}"></script>
<script src="{{ nbs_asset('js/fs-modal.min.js') }}"></script>
<script src="{{ nbs_asset('js/mustache.min.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function () {

        $.fn.dataTable.ext.errMode = 'throw';

        if ("{{ route('logistic.index') }}" === "{{ url()->current() }}") {

            // Check current target
            var curr_url = document.location.href;
            var curr_target = curr_url.substring(curr_url.indexOf('#'))
            
            // Add handle to change status order
            $('#selectStatus').change(function(event){
                // console.log($(event.target).val())
                var current_tag = $(event.target).val(); 
                $('a[role="tab"][href="'+current_tag+'"]').click()
                document.location.href = current_tag;
            })

            $('#confirm_tab').on('click', function () {
                loadConfirmOrder();
            });

            $('#process_tab').on('click', function () {
                loadProcessedOrder();
            });

            $('#sent_tab').on('click', function () {
                loadSentOrder();
            });

            $('#transaction_tab').on('click', function () {
                loadTransactionOrder();
            });

            if ( curr_target != '') {
                $('#selectStatus').val(curr_target)
                $('a[role="tab"][href="'+curr_target+'"]').click()
                _screenResolver (curr_target)
            } else {
                _defaultScreen()
            }

            function _defaultScreen(){
                $('#selectStatus').val('#confirm')
                loadConfirmOrder();
            }

            function _screenResolver( curr_section ) {
                switch(curr_section) {
                    case "#confirm": 
                        loadConfirmOrder(); break;
                    case "#process": 
                        loadProcessedOrder(); break; 
                    case "#sent": 
                        loadSentOrder(); break;
                    case "#success":   
                    case "#transaction": 
                        loadTransactionOrder(); break;  
                    default:
                        $('#selectStatus').val('#confirm')    
                        $('a[role="tab"][href="#confirm"]').click()
                        loadConfirmOrder(); break;                        
                }
            }

            function loadConfirmOrder() {

                if (!$.fn.dataTable.isDataTable('#order_confirm')) {
                    def_dt_settings.ajax = "{{ route('logistic.waiting-confirmation') }}";
                    $('#order_confirm').DataTable(def_dt_settings);
                }

                // Support for mobile
                if (!$.fn.dataTable.isDataTable('#order_confirm_mobile')) {
                    def_dt_mobile_settings.ajax = "{{ route('logistic.waiting-confirmation') }}";
                    var mobileDataTable = $('#order_confirm_mobile').DataTable(def_dt_mobile_settings);
              
                    mobileDataTable.on('draw', function(){
                        $('div#confirm a.item-link').click(function(){
                            var order_id = $(this).attr('data-id')
                            _showInfoConfirmOrder ( this, order_id, function(){ mobileDataTable.ajax.reload() })
                        })
                    })
                }
            }


            function loadProcessedOrder() {

                if (!$.fn.dataTable.isDataTable('#order_process')) {
                    def_dt_settings.ajax = "{{ route('logistic.in-process') }}";
                    $('#order_process').DataTable(def_dt_settings);
                }

                // Support for mobile
                if (!$.fn.dataTable.isDataTable('#order_process_mobile')) {
                    def_dt_mobile_settings.ajax = "{{ route('logistic.in-process') }}";
                    var mobileDataTable = $('#order_process_mobile').DataTable(def_dt_mobile_settings);

                    mobileDataTable.on('draw', function(){
                        $('div#process a.item-link').click(function(){
                            var order_id = $(this).attr('data-id')
                            _showInfoOrderGeneral ( order_id )    
                        })
                    })
                }
            }

            function loadSentOrder() {

                if (!$.fn.dataTable.isDataTable('#order_sent')) {
                    def_dt_settings.ajax = "{{ route('logistic.picked-up') }}";
                    $('#order_sent').DataTable(def_dt_settings);
                }

                // Support for mobile
                if (!$.fn.dataTable.isDataTable('#order_sent_mobile')) {
                    def_dt_mobile_settings.ajax = "{{ route('logistic.picked-up') }}";
                    var mobileDataTable = $('#order_sent_mobile').DataTable(def_dt_mobile_settings);

                    mobileDataTable.on('draw', function(){
                        $('div#sent a.item-link').click(function(){
                            var order_id = $(this).attr('data-id')
                            _showInfoOrderGeneral ( order_id )
                        })
                    })
                }
            }
            function loadTransactionOrder() {

                if (!$.fn.dataTable.isDataTable('#order_transaction')) {
                    def_dt_settings.ajax = "{{ route('logistic.transaction') }}";
                    $('#order_transaction').DataTable(def_dt_settings);
                }

                // Support for mobile
                if (!$.fn.dataTable.isDataTable('#order_transaction_mobile')) {
                    def_dt_mobile_settings.ajax = "{{ route('logistic.transaction') }}";
                    var mobileDataTable = $('#order_transaction_mobile').DataTable(def_dt_mobile_settings);

                    mobileDataTable.on('draw', function(){
                        $('div#transaction a.item-link').click(function(){
                            var order_id = $(this).attr('data-id')
                            _showInfoOrderGeneral ( order_id )
                        })
                    })
                }

            }

        }
    });
</script>