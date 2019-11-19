$( document ).ready(function() {
    //Origin Address
    $("#origin-province").change(function(){
        var province = $(this).children("option:selected").val();
        $('#origin-city').find('option').remove();
        $('#origin-district').find('option').remove();
        $('#origin-subdistrict').find('option').remove();
        $('#origin-postal-code').val("");  
        if(province != ""){
            $.getJSON( "/tools/postalCodeFinder/province/"+province, function( data ) {
                $('#origin-city').prepend("<option value='' selected='selected'></option>");
                $('#origin-district').prepend("<option value='' selected='selected'></option>");
                $('#origin-subdistrict').prepend("<option value='' selected='selected'></option>");
                data['cities'].forEach(function(city){
                    $('#origin-city').append(new Option(city['name'], city['id']));
                });
            }); 
        }
    }); 
    $("#origin-city").change(function(){
        var city = $(this).children("option:selected").val();
        if(city != ""){
            $('#origin-district').find('option').remove();
            $('#origin-subdistrict').find('option').remove();
            $('#origin-postal-code').val(""); 
            $.getJSON( "/tools/postalCodeFinder/city/"+city, function( data ) {
                $('#origin-district').prepend("<option value='' selected='selected'></option>");
                $('#origin-subdistrict').prepend("<option value='' selected='selected'></option>");
                data['districts'].forEach(function(district){
                    $('#origin-district').append(new Option(district['name'], district['id']));
                });
            }); 
        }
    });
    $("#origin-district").change(function(){
        var district = $(this).children("option:selected").val();
        $('#origin-subdistrict').find('option').remove();
        $('#origin-postal-code').val("");
        if(district != ""){
            $.getJSON( "/tools/postalCodeFinder/district/"+district, function( data ) {
                $('#origin-subdistrict').prepend("<option value='' selected='selected'></option>");
                data['subdistricts'].forEach(function(subdistrict){
                    $('#origin-subdistrict').append(new Option(subdistrict['name'], subdistrict['id']));
                });
            }); 
        }
    });
    $("#origin-subdistrict").change(function(){
        var subdistrict = $(this).children("option:selected").val();
        $('#origin-postal-code').val("");
        if(subdistrict != ""){
            $.getJSON( "/tools/postalCodeFinder/subdistrict/"+subdistrict, function( data ) {
                $("#origin-postal-code").val(data['postal_code']);
            });
        }
    });

    //Destination Address
    $("#destination-province").change(function(){
        var province = $(this).children("option:selected").val();
        $('#destination-city').find('option').remove();
        $('#destination-district').find('option').remove();
        $('#destination-subdistrict').find('option').remove();
        $('#destination-postal-code').val("");
        if(province != ""){
            $.getJSON( "/tools/postalCodeFinder/province/"+province, function( data ) {
                
                $('#destination-city').prepend("<option value='' selected='selected'></option>");
                $('#destination-district').prepend("<option value='' selected='selected'></option>");
                $('#destination-subdistrict').prepend("<option value='' selected='selected'></option>");
                data['cities'].forEach(function(city){
                    $('#destination-city').append(new Option(city['name'], city['id']));
                });
            }); 
        }
    }); 
    $("#destination-city").change(function(){
        var city = $(this).children("option:selected").val();
        $('#destination-district').find('option').remove();
        $('#destination-subdistrict').find('option').remove();
        $('#destination-postal-code').val("");
        if(city != ""){
            $.getJSON( "/tools/postalCodeFinder/city/"+city, function( data ) {
                $('#destination-district').prepend("<option value='' selected='selected'></option>");
                $('#destination-subdistrict').prepend("<option value='' selected='selected'></option>");
                data['districts'].forEach(function(district){
                    $('#destination-district').append(new Option(district['name'], district['id']));
                });
            }); 
        }
    });
    $("#destination-district").change(function(){
        var district = $(this).children("option:selected").val();
        $('#destination-subdistrict').find('option').remove();
        $('#destination-postal-code').val("");
        if(district != ""){
            $.getJSON( "/tools/postalCodeFinder/district/"+district, function( data ) {
                $('#destination-subdistrict').prepend("<option value='' selected='selected'></option>");
                data['subdistricts'].forEach(function(subdistrict){
                    $('#destination-subdistrict').append(new Option(subdistrict['name'], subdistrict['id']));
                });
            }); 
        }
    });
    $("#destination-subdistrict").change(function(){
        var subdistrict = $(this).children("option:selected").val();
        $('#destination-postal-code').val("");
        if(subdistrict != ""){
            $.getJSON( "/tools/postalCodeFinder/subdistrict/"+subdistrict, function( data ) {
                $("#destination-postal-code").val(data['postal_code']);
            });
        }
    });

    //Form
    $('#package-weight').change(function(){
        var value = $('#package-value').val();
        $('#package-value').attr('value', "IDR ".concat(value.toString()).concat(".00"));
    });
    $("#btn-simulate").click(function(e) {
        e.preventDefault();
        $.ajax({
          method: 'GET',
          url: '/tools/shipping-simulation/simulate',
          contentType: 'Appiclation/Json',
          dataType: 'json',
          data: $('#simulation-form').serialize(),
          processData: false,
          success: function success(data) {
            
            if(data['shippers'] != null){
                $("#shipper-list-error").hide();
                if(data['shippers']['regular_shippers'] !== 'undefined'){
                    if(data['shippers']['regular_shippers'][0]['options']['length'] != 0){
                        data['shippers']['regular_shippers'][0]['options'].forEach(function(option){
                            var rateAfterDiscount = option['finalRate'] - option['platform_discount'];
                            var html = '<div class="row"><div class="col-1"><img src="'+option['logo_url']+'"></div><div class="col-3 ml-5"><h5>'+option['name']+'</h5><h5> IDR '+rateAfterDiscount+' <strike> IDR ' +option['finalRate']+ '</strike></h5></div></div>'
                            $("#regular-shipper-list").append(html);
                        });
                        $("#regular-shipper-list").show();
                    }
                }
                if(data['shippers']['express_shippers'] !== 'undefined'){
                    if(data['shippers']['express_shippers'][0]['options']['length'] != 0){
                        data['shippers']['express_shippers'][0]['options'].forEach(function(option){
                            var rateAfterDiscount = option['finalRate'] - option['platform_discount'];
                            var html = '<div class="row"><div class="col-1"><img src="'+option['logo_url']+'"></div><div class="col-3 ml-5"><h5>'+option['name']+'</h5><h5> IDR '+rateAfterDiscount+' <strike> IDR ' +option['finalRate']+ '</strike></h5></div></div>'
                            $("#express-shipper-list").append(html);
                        });
                        $("#express-shipper-list").show();
                    }
                }
                if(data['shippers']['trucking_shippers'] !== 'undefined'){
                    if(data['shippers']['trucking_shippers'][0]['options']['length'] != 0){
                        data['shippers']['trucking_shippers'][0]['options'].forEach(function(option){
                            var rateAfterDiscount = option['finalRate'] - option['platform_discount'];
                            var html = '<div class="row"><div class="col-1"><img src="'+option['logo_url']+'"></div><div class="col-3 ml-5"><h5>'+option['name']+'</h5><h5> IDR '+rateAfterDiscount+' <strike> IDR ' +option['finalRate']+ '</strike></h5></div></div>'
                            $("#trucking-shipper-list").append(html);
                        });
                        $("#trucking-shipper-list").show();
                    }
                }
                $("#shipper-list").show();
            }
            else{
                $("#shipper-list").hide();
                $("#shipper-list-error").show();
            }
          }
        });
        
    });
    
});
