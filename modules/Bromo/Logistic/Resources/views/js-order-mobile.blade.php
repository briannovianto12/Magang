<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{ nbs_asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="{{ nbs_asset('js/lang.js?v=201908190001') }}"></script>
<script src="{{ nbs_asset('js/logistic.js') }}"></script>
<script src="{{ nbs_asset('js/fs-modal.min.js') }}"></script>
<script src="{{ nbs_asset('js/mustache.min.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function () {

        $.fn.dataTable.ext.errMode = 'throw';

        if ("{{ route('logistic.mobile-index') }}" === "{{ url()->current() }}") {

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
                    case "#transaction": 
                        loadTransactionOrder(); break;  
                    default:
                        $('#selectStatus').val('#confirm')    
                        $('a[role="tab"][href="#confirm"]').click()
                        loadConfirmOrder(); break;                        
                }
            }

            function loadConfirmOrder() {

                // Support for mobile
                if (!$.fn.dataTable.isDataTable('#order_confirm_mobile')) {
                    def_dt_mobile_settings.ajax = "{{ route('logistic.waiting-confirmation') }}";
                    var mobileDataTable = $('#order_confirm_mobile').DataTable(def_dt_mobile_settings);
                }
            }


            function loadProcessedOrder() {

                // Support for mobile
                if (!$.fn.dataTable.isDataTable('#order_process_mobile')) {
                    def_dt_mobile_settings.ajax = "{{ route('logistic.in-process') }}";
                    var mobileDataTable = $('#order_process_mobile').DataTable(def_dt_mobile_settings);
                }
            }

            function loadSentOrder() {

                // Support for mobile
                if (!$.fn.dataTable.isDataTable('#order_sent_mobile')) {
                    def_dt_mobile_settings.ajax = "{{ route('logistic.picked-up') }}";
                    var mobileDataTable = $('#order_sent_mobile').DataTable(def_dt_mobile_settings);
                }
            }

            function loadTransactionOrder() {

                // Support for mobile
                if (!$.fn.dataTable.isDataTable('#order_transaction_mobile')) {
                    def_dt_mobile_settings.ajax = "{{ route('logistic.transaction') }}";
                    var mobileDataTable = $('#order_transaction_mobile').DataTable(def_dt_mobile_settings);
                }
            }
        }


        $('.review').click(function () {
            var formValues = [];
                // get values from inputs in first fieldset
                $('.field1 :input').each(function () {
                    formValues.push($(this).val());
                });
                
                formValues.pop();
                formValues.pop(); //remove the button from input values
                console.log(formValues);
                
                // set values in second fieldset
                $('.field2 :input').each(function (index) {
                    if (formValues[index]) {
                        $(this).val(formValues[index]);  
                    }
                });

            $('.current').removeClass('current').hide().next().show().addClass('current');
        });

        $('.previous').click(function () {
            $('.current').removeClass('current').hide().prev().show().addClass('current');
        });
    });
</script>