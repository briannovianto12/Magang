$( document ).ready(function() {
    
    var sellerId, buyerId;
    init();

    load_expedition_couriers();

    $(document).on('click', '.btn-add-seller', function(e) {
        var tr = $(this).closest('li').length ? $(this).closest('li') : $(this).closest('tr');
        sellerId = $('#table-seller').DataTable().row(tr).data()['id'];
        sellerName = $('#table-seller').DataTable().row(tr).data()['shop_name']
        $('#selected-seller').val(sellerName);
    });

    $(document).on('click', '.btn-add-buyer', function(e) {
        var tr = $(this).closest('li').length ? $(this).closest('li') : $(this).closest('tr');
        buyerId = $('#table-buyer').DataTable().row(tr).data()['id'];
        buyerName = $('#table-buyer').DataTable().row(tr).data()['buyer_name']
        $('#selected-buyer').val(buyerName);
    });

    $('#btn-search-seller').on('click', function (e) {
        search_seller();
    });

    $('#btn-search-buyer').on('click', function (e) {
        search_buyer();
    });

    $('#btn-submit-form').on('click', function (e) {
        e.preventDefault();
        if($('#selected-seller').val() == '' || $('#selected-buyer').val() == '' || $('#courier-selection').val() == ''){
            alert('Please fill all the form!');
        }
        else if(sellerId == buyerId){
            alert('Cannot map! Buyer and Seller are the same');
        }
        else{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: 'POST',
                url: '/tools/courier-business-mapping',
                data: {seller_id: sellerId,
                    buyer_id : buyerId,
                    courier_id : $('#courier-selection').val()
                },
                success: function success(data) {
                    clear();
                    alert("Data Added!");
                },
                error: function error(err) {
                    clear();
                    alert(JSON.parse(err.responseText).error);
                }
            });
        }
    });

    function load_expedition_couriers(){
        
        $.getJSON( "/tools/courier-business-mapping/get-expedition-couriers", function( data ) {
            data['expedition_couriers'].forEach(function(expedition_courier){
                $('#courier-selection').append(new Option(expedition_courier['name'], expedition_courier['id']));
            });
        });
    }

    function search_seller(){
        var keyword = $("#seller-searchbar").val();

        if(keyword == ''){
            alert('Search box is empty!');
        }
        else{
            $('#table-seller').DataTable().destroy();
            $('#table-seller').DataTable({searching: false, info: false, processing: true,
                serverSide: true,
                responsive: true,
                ajax:'/tools/courier-business-mapping/search-seller/'+keyword,
                columns: [
                    {data: 'shop_id', name: 'shop_id'},
                    {data: 'shop_name', name: 'shop_name'},
                    {data: 'shop_status', name: 'shop_status'},
                    {data: 'contact_person', name: 'contact_person'},
                    {data: 'action', name: 'action'},
                ],
                dom: '<"top"l>rt<"bottom"p><"clear">', ordering: false, pagingType: "simple_numbers"});        
            $('#table-seller').DataTable().draw();
            $("#list-seller").show();
        }
    }

    function search_buyer(){
        var keyword = $("#buyer-searchbar").val();

        if(keyword == ''){
            alert('Search box is empty!');
        }
        else{
            $('#table-buyer').DataTable().destroy();
            $('#table-buyer').DataTable({searching: false, info: false, processing: true,
                serverSide: true,
                responsive: true,
                ajax:'/tools/courier-business-mapping/search-buyer/'+keyword,
                columns: [
                    {data: 'buyer_name', name: 'buyer_name'},
                    {data: 'owner_name', name: 'owner_name'},
                    {data: 'owner_phone_number', name: 'owner_phone_number'},
                    {data: 'action', name: 'action'},
                ],
                dom: '<"top"l>rt<"bottom"p><"clear">', ordering: false, pagingType: "simple_numbers"});        
            $('#table-buyer').DataTable().draw();
            $("#list-buyer").show();
        }
    }

    function init(){
        
        clear();
        $("#list-seller").hide();
        $("#list-buyer").hide();
        $("#seller-search-form").submit(function(e) {
            e.preventDefault();
        });
        $("#seller-searchbar").keyup(function(e) {
            e.preventDefault();
            if (e.keyCode === 13) {
                $("#btn-search-seller").click();
            }
        });

        $("#buyer-searchbar").val("");
        $("#buyer-search-form").submit(function(e) {
            e.preventDefault();
        });
        $("#buyer-searchbar").keyup(function(e) {
            e.preventDefault();
            if (e.keyCode === 13) {
                $("#btn-search-buyer").click();
            }
        });
    }

    function clear(){
        $('#selected-seller').val("");
        $('#selected-buyer').val("");
        $("#seller-searchbar").val("");
        $("#buyer-searchbar").val("");
    }
 
});