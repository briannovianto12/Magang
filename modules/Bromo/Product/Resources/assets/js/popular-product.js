$( document ).ready(function() {

    $("#product-searchbar").val("");
    $("#product-search-form").submit(function(e) {
        e.preventDefault();
    });
    $("#btn-search-product").click(search_product);
    $("#product-searchbar").keyup(function(event) {
        event.preventDefault();
        if (event.keyCode === 13) {
            $("#btn-search-product").click();
        }
    });
    load_popular_product();

    $(document).on('click', '.btn-add-to-popular-list', function(e) {
        var product_id = $(this).attr("data-id");
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
          method: 'POST',
          url: '/popular-product/add',
          data: {product_id: product_id},
          success: function success(data) {
            if($("#product-searchbar").val() != ""){
                search_product();
            }
            load_popular_product();
          }
        });
        
    });
    

    $(document).on('click', '.btn-remove-from-popular-list', function(e) {
        var product_id = $(this).attr("data-id");
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
          url: '/popular-product/'+product_id,
          success: function success(data) {
            if($("#product-searchbar").val() != ""){
                search_product();
            }
            load_popular_product();
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
            url: '/popular-product/update-index',
            success: function success() {
                alert("Index Updated!");
            }
          });
    });

    function search_product(){
        $('#table-regular-product tbody').empty();
        var keyword = $("#product-searchbar").val();

        $('#table-regular-product').DataTable().destroy();
        $('#table-regular-product').DataTable({searching: false, info: false, processing: true,
            ajax: '/popular-product/search/'+keyword,
            columns: [
                {data: 'product_name', name: 'product_name'},
                {data: 'seller_name', name: 'seller_name'},
                {data: 'action', name: 'action'},
            ],
            dom: '<"top"l>rt<"bottom"p><"clear">', ordering: false, pagingType: "simple_numbers"});        
        $('#table-popular-product').DataTable().draw();
        $("#list-regular-product").show();
    }

    function load_popular_product(){
        $('#table-popular-product').DataTable().destroy();
        $('#table-popular-product').DataTable({searching: false, info: false, processing: true,
            ajax: '/popular-product/get-list/',
            columns: [
                {data: 'product_name', name: 'product_name'},
                {data: 'seller_name', name: 'seller_name'},
                {data: 'action', name: 'action'},
            ],
            dom: '<"top"l>rt<"bottom"p><"clear">', ordering: false, pagingType: "simple_numbers"});        
        $('#table-popular-product').DataTable().draw();
    } 

});