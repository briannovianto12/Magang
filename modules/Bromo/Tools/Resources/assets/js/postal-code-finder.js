$( document ).ready(function() {
    //SEPARATOR
    $("#province").change(function(){
        var province = $(this).children("option:selected").val();
        $('#city').find('option').remove();
        $('#district').find('option').remove();
        $('#subdistrict').find('option').remove();
        $('#postal-code').val("");  
        if(province != ""){
            $.getJSON( "/tools/postalCodeFinder/province/"+province, function( data ) {
                $('#city').prepend("<option value='' selected='selected'></option>");
                $('#district').prepend("<option value='' selected='selected'></option>");
                $('#subdistrict').prepend("<option value='' selected='selected'></option>");
                data['cities'].forEach(function(city){
                    $('#city').append(new Option(city['name'], city['id']));
                });
            }); 
        }
    }); 
    $("#city").change(function(){
        var city = $(this).children("option:selected").val();
        $('#district').find('option').remove();
        $('#subdistrict').find('option').remove();
        $('#postal-code').val(""); 
        if(city != ""){
            $.getJSON( "/tools/postalCodeFinder/city/"+city, function( data ) {
                $('#district').prepend("<option value='' selected='selected'></option>");
                $('#subdistrict').prepend("<option value='' selected='selected'></option>");
                data['districts'].forEach(function(district){
                    $('#district').append(new Option(district['name'], district['id']));
                });
            }); 
        }
    });
    $("#district").change(function(){
        var district = $(this).children("option:selected").val();
        $('#subdistrict').find('option').remove();
        $('#postal-code').val("");
        if(district != ""){
            $.getJSON( "/tools/postalCodeFinder/district/"+district, function( data ) {
                $('#subdistrict').prepend("<option value='' selected='selected'></option>");
                data['subdistricts'].forEach(function(subdistrict){
                    $('#subdistrict').append(new Option(subdistrict['name'], subdistrict['id']));
                });
            }); 
        }
    });
    $("#subdistrict").change(function(){
        var subdistrict = $(this).children("option:selected").val();
        $('#postal-code').val("");
        if(subdistrict != ""){
            $.getJSON( "/tools/postalCodeFinder/subdistrict/"+subdistrict, function( data ) {
                $("#postal-code").val(data['postal_code']);
            });
        }
    });
});
