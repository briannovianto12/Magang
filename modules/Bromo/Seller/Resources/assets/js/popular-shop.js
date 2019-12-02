$( document ).ready(function() {

    $("#shop-searchbar").val("");
    $("#shop-search-form").submit(function(e) {
        e.preventDefault();
    });

    $("#btn-search-shop").click(function(){
        if ( $("#shop-searchbar").val() == "" ) {
            alert("Searchbar is empty!");
        }
        else{
            search_shop();
        }
    });

    $("#shop-searchbar").keyup(function(event) {
        event.preventDefault();
        if (event.keyCode === 13) {
            $("#btn-search-shop").click();
        }
    });
    load_popular_shop();

    $(document).on('click', '.btn-add-to-popular-list', function(e) {
        var shop_id = $(this).attr("data-id");
        console.log(shop_id);
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
          method: 'POST',
          url: '/popular-shop/add',
          data: {shop_id: shop_id},
          success: function success(data) {
            if($("#shop-searchbar").val() != ""){
                search_shop();
            }
            load_popular_shop();
          }
        });
        
    });

    $(document).on('click', '.btn-remove-from-popular-list', function(e) {
        var shop_id = $(this).attr("data-id");
        if(!confirm('Are you sure ?')) {
            return
        }
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
          method: 'DELETE',
          url: '/popular-shop/'+shop_id,
          success: function success(data) {
            if($("#shop-searchbar").val() != ""){
                search_shop();
            }
            load_popular_shop();
          }
        });
        
    });

    $(document).on('click', '#btn-update-index', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            method: 'POST',
            url: '/popular-shop/update-index',
            success: function success() {
                alert("Index Updated!");
            }
          });
    });

    function search_shop(){
        $('#table-regular-shop tbody').empty();
        var keyword = $("#shop-searchbar").val();

        $('#table-regular-shop').DataTable().destroy();
        $('#table-regular-shop').DataTable({searching: false, info: false, processing: true,
            ajax: '/popular-shop/search/'+keyword,
            columns: [
                {data: 'shop_name', name: 'shop_name'},
                {data: 'action', name: 'action'},
            ],
            dom: '<"top"l>rt<"bottom"p><"clear">', ordering: false, pagingType: "simple_numbers"});        
        $('#table-popular-shop').DataTable().draw();
        $("#list-regular-shop").show();
    }

    function load_popular_shop(){
        $('#table-popular-shop').DataTable().destroy();
        $('#table-popular-shop').DataTable({searching: false, info: false, processing: true,
            ajax: '/popular-shop/get-list/',
            columns: [
                {data: 'shop_name', name: 'shop_name'},
                {data: 'action', name: 'action'},
            ],
            dom: '<"top"l>rt<"bottom"p><"clear">', ordering: false, pagingType: "simple_numbers"});        
        $('#table-popular-shop').DataTable().draw();
    }

});