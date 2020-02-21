<script>
$(document).ready(function(){
    load_data();

    function load_data(){
        var table = $('#shop_list_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:"{{ route('mutation.payment-detail') }}"
            },
            columns: [    
            {
                'data':'link', 
                'name':'link'
            },
            {
                'data':'name',
                'data':'name', searchable: true
            },
            {
                'data':'full_name',
                'name':'user_profile.full_name'
            },
            {
                'data':'msisdn',
                'name':'user_profile.msisdn'
            }
            ],
            "aaSorting": [[0,'asc']],
            "iDisplayLength": 25,
        });

        $( table.table().container() ).removeClass( 'form-inline' );
    }
});

$(function(){
    $(".fold-table tr.view").on("click", function(){
        $(this).toggleClass("open").next(".fold").toggleClass("open");
    });
});
</script>
