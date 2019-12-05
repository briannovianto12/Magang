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
        
            load_data();
        
            function load_data(from_date = '', to_date = ''){
                var table = $('#total-count-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url:"{{ route('report.total_buy_count') }}",
                        data:{from_date:from_date, to_date:to_date}
                    },                 
                    columns: [
                    {
                        'data':'name',
                        'name':'name',
                    },
                    {
                        'data':'count',
                        'name':'count'
                    },
                    {
                        'data':'total_gross',
                        'name':'total_gross'
                    }
                    ],
                    "iDisplayLength": 25,

                });
        
                $( table.table().container() ).removeClass( 'form-inline' );
            }
        
            $('#filter').click(function(){
                var from_date = $('#from_date').attr("placeholder");
                var to_date = $('#to_date').attr("placeholder");
                
                if($('#to_date').val() != ''){
                    to_date = $('#to_date').val();
                }
                if($('#from_date').val() != ''){
                    from_date = $('#from_date').val();
                }
                
                if(from_date != '' &&  to_date != '' && (new Date(to_date) - new Date(from_date))/1000/60/60/24 <= 60){
                    $('#total-count-table').DataTable().destroy();
                    load_data(from_date, to_date);
                // }else if((new Date(to_date) - new Date(from_date))/1000/60/60/24 > 60){
                //     alert('Date Difference can not be more than 60 days');
                }else{
                    alert((new Date(to_date) - new Date(from_date))/1000/60/60/24);
                }
            });
        
            $('#refresh').click(function(){
                $('#from_date').val('');
                $('#to_date').val('');
                $('#total-count-table').DataTable().destroy();
                load_data();
            });

            $('#exportTotalBuy').click(function(){
                var from_date = $('#from_date').attr("placeholder");
                var to_date = $('#to_date').attr("placeholder");
                
                if($('#to_date').val() != ''){
                    to_date = $('#to_date').val();
                }
                if($('#from_date').val() != ''){
                    from_date = $('#from_date').val();
                }
                
                if(from_date != '' &&  to_date != '' && (new Date(to_date) - new Date(from_date))/1000/60/60/24 <= 60){
                    window.open( '/report/total-buy-count/export/xlsx?from_date=' + from_date + '&to_date=' + to_date , '_blank')
                }else{
                    alert((new Date(to_date) - new Date(from_date))/1000/60/60/24);
                }
            });
        });
</script>