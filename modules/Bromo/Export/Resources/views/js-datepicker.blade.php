<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

<script type="text/javascript">
        $(document).ready(function(){
            $('.input-daterange').datepicker({
                todayBtn:'linked',
                format:'yyyy-mm-dd',
                autoclose:true,
                orientation: "bottom auto",
            });

            $('#exportOrderListBtn').click(function(e){
                var from_date = $('#from_date').attr("placeholder");
                var to_date = $('#to_date').attr("placeholder");

                if($('#to_date').val() != ''){
                    to_date = $('#to_date').val();
                }
                if($('#from_date').val() != ''){
                    from_date = $('#from_date').val();
                }

                if((new Date(to_date) - new Date(from_date))/1000/60/60/24 > 31){
                    alert('Maximum date difference is 31 days');
                    e.preventDefault();
                }

                if($('input[name="order_status[]"]:checked').length <= 0){
                    alert("At least one (1) [Order Status] must be checked");
                    e.preventDefault();
                }
                if($('input[name="payment_status[]"]:checked').length <= 0){
                    alert("At least one (1) [Payment Status] must be checked");
                    e.preventDefault();
                }
            });

            $("#order_status_checkAll").click(function () {
                if($("#order_status_checkAll").is(':checked')){
                    $('.order_status_checkbox').not(this).prop('checked', true);
                }else{
                    $('.order_status_checkbox').not(this).prop('checked', false);
                }
            });
            $("#payment_status_checkAll").click(function () {
                if($("#payment_status_checkAll").is(':checked')){
                    $('.payment_status_checkbox').not(this).prop('checked', true);
                }else{
                    $('.payment_status_checkbox').not(this).prop('checked', false);
                }
            });
        });
</script>