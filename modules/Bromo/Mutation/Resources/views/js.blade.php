<script>
$(document).ready(function(){
 $('.input-daterange').datepicker({
  todayBtn:'linked',
  format:'yyyy-mm-dd',
  autoclose:true
 });

 load_data();

 function load_data(from_date = '', to_date = '')
 {
  $('#shop_log_mutation_table').DataTable({
   processing: true,
   serverSide: true,
   ajax: {
                url:"{{ route('mutation.index') }}",
                data:{from_date:from_date, to_date:to_date}
            },
            columns: [
            {
                'data':'shop_id',
                'name':'shop_id'
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
            ]

  });
 }

 $('#filter').click(function(){
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
  if(from_date != '' &&  to_date != '')
  {
   $('#shop_log_mutation_table').DataTable().destroy();
   load_data(from_date, to_date);
  }
  else
  {
   alert('Both Date is required');
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