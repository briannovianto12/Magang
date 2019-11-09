$( document ).ready(function() {
    $("#province").change(function(){
        console.log('province');
        var province = $(this).children("option:selected").val();
        $.getJSON( "/tools/postalCodeFinder/province/"+province, function( data ) {
            $('#city').find('option').remove()
            data['cities'].forEach(function(city){
                $('#city').append(new Option(city['name'], city['id']))
            });
        }); 
        
    }); 
    $("#city").change(function(){
        console.log('city');
        var city = $(this).children("option:selected").val();
        $.getJSON( "/tools/postalCodeFinder/city/"+city, function( data ) {
            $('#district').find('option').remove()
            data['districts'].forEach(function(district){
                $('#district').append(new Option(district['name'], district['id']))
            });
        }); 
        
    });
    $("#district").change(function(){
        console.log('district');
        var district = $(this).children("option:selected").val();
        $.getJSON( "/tools/postalCodeFinder/district/"+district, function( data ) {
            $('#subdistrict').find('option').remove()
            data['subdistricts'].forEach(function(subdistrict){
                $('#subdistrict').append(new Option(subdistrict['name'], subdistrict['id']))
            });
        }); 
        
    });
    $("#subdistrict").change(function(){
        var subdistrict = $(this).children("option:selected").val();
        console.log(subdistrict);
        $.getJSON( "/tools/postalCodeFinder/subdistrict/"+subdistrict, function( data ) {
            $("#postal-code").val(data['postal_code']);
        });
    }); 
});
