$( document ).ready(function() {

    load_table();
    load_expedition_couriers();

    $('#courier-filter').change(function(){
        if($('#courier-filter').val() == "All"){
            load_table();
        }
        else{
            load_filtered_table($('#courier-filter').val());
        }
    });

    function load_table(){
        $('#table-courier-business-mapping').DataTable().destroy();
        $('#table-courier-business-mapping').DataTable({processing: true,
            serverSide: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            ajax: '/tools/courier-business-mapping/get-table',
            columns: [
                {data: 'seller_name', name: 'seller_name'},
                {data: 'buyer_name', name: 'buyer_name'},
                {data: 'buyer_phone_number', name: 'buyer_phone_number'},
                {data: 'courier_name', name: 'courier_name', searchable: false},
                {data: 'remark', name: 'remark', searchable: false},
            ],
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
             ordering: false, pagingType: "simple_numbers"});        
        $('#table-courier-business-mapping').DataTable().draw();
    }

    function load_filtered_table(courier_id){
        $('#table-courier-business-mapping').DataTable().destroy();
        $('#table-courier-business-mapping').DataTable({processing: true,
            serverSide: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            ajax: '/tools/courier-business-mapping/get-filtered-table/'+courier_id,
            columns: [
                {data: 'seller_name', name: 'seller_name'},
                {data: 'buyer_name', name: 'buyer_name'},
                {data: 'buyer_phone_number', name: 'buyer_phone_number'},
                {data: 'courier_name', name: 'courier_name', searchable: false},
                {data: 'remark', name: 'remark', searchable: false},
            ],
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
             ordering: false, pagingType: "simple_numbers"});        
        $('#table-courier-business-mapping').DataTable().draw();
    }

    function load_expedition_couriers(){
        $.getJSON( "/tools/courier-business-mapping/get-expedition-couriers", function( data ) {
            data['expedition_couriers'].forEach(function(expedition_courier){
                $('#courier-filter').append(new Option(expedition_courier['name'], expedition_courier['id']));
            });
        });
    }
});