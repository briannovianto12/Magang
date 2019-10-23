<script>
$(document).ready(function(){
    $('.input-daterange').datepicker({
        todayBtn:'linked',
        format:'yyyy-mm-dd',
        autoclose:true
    });

    load_data();

    function load_data(from_date = '', to_date = ''){
        var table = $('#shop_log_mutation_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:"{{ route('mutation.index') }}",
                data:{from_date:from_date, to_date:to_date}
            },
            columns: [
            {
                'data':'shop_name',
                'name':'shop_name'
            },
            {
                'data':'owner_name',
                'name':'owner_name'
            },
            {
                'data':'mutation',
                'name':'mutation'
            },
            {
                'data':'remark',
                'name':'remark'
            },
            {
                'data':'trx_type',
                'name':'trx_type'
            },
            {
                'data':'created_at',
                'name':'created_at'
            }
            ],
            "aaSorting": [[5,'asc']],
            "iDisplayLength": 25,
        });

        $( table.table().container() ).removeClass( 'form-inline' );
    }

    $('#filter').click(function(){
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if(from_date != '' &&  to_date != '' && (new Date(to_date) - new Date(from_date))/1000/60/60/24 <= 60){
            $('#shop_log_mutation_table').DataTable().destroy();
            load_data(from_date, to_date);
        }else if((new Date(to_date) - new Date(from_date))/1000/60/60/24 > 60){
            alert('Date Difference can not be more than 60 days');
        }else{
            alert((new Date(to_date) - new Date(from_date))/1000/60/60/24);
        }
    });

    $('#refresh').click(function(){
        $('#from_date').val('');
        $('#to_date').val('');
        $('#shop_log_mutation_table').DataTable().destroy();
        load_data();
    });
});
</script>