window.swalError = function ( message, showConfirmButton, timer ) {
    Swal.fire({
      position: 'top',
      type: 'error',
      text: message,
      showConfirmButton: (showConfirmButton==undefined) ? true : false,
      timer: (timer) ? timer : null,
    })
}
  
window.swalSuccess = function ( message, showConfirmButton, timer ) {
      Swal.fire({
        position: 'top',
        type: 'success',
        text: message,
        showConfirmButton: (showConfirmButton==undefined) ? true : false,
        timer: (timer) ? timer : null,
      })
}

window.swalQuestion = function ( title, text, type, input, inputOptions) {
  if (input == undefined) {
    return Swal.fire({
      position: 'top',
      title: title,
      text: text,
      type: (type==null) ? 'question': type,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak'
    })
  }
  return Swal.fire({
    position: 'top',
    title: title,
    text: text,
    type: (type==null) ? 'question': type,
    input: input,
    inputOptions: inputOptions,
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya',
    cancelButtonText: 'Tidak'
  })
}
$( document ).ready(function() {
    
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
            $("#btnEditPostalCode").attr("disabled", false);
        }
        else{
            $("#btnEditPostalCode").attr("disabled", true);
        }
    });
    $("#subdistrict").change(function(){
        var subdistrict = $(this).children("option:selected").val();
        $('#postal-code').val("");
        if(subdistrict != ""){
            $.getJSON( "/tools/postalCodeFinder/subdistrict/"+subdistrict, function( data ) {
                $("#postal-code").val(data['postal_code']);
            });
            $("#btnEditPostalCode").attr("disabled", false);
        }
        else{
            $("#btnEditPostalCode").attr("disabled", true);
        }
    });
    
    $("#btnEditPostalCode").click(function(){
        var data = {
            province_name : $('#province').children('option:selected').text(),
            city_name : $('#city').children('option:selected').text(),
            district_id : $('#district').val(),
            district_name : $('#district').children('option:selected').text(),
            subdistrict_id : $('#subdistrict').val(),
            subdistrict_name : $('#subdistrict').children('option:selected').text(),
            postal_code : $('#postal-code').val()
        };
        var template = $('#changePostalCode').html();
        Mustache.parse(template);   // optional, speeds up future uses
        html = Mustache.render(template, data);
        
        Swal.fire({
        title: '<strong>Edit Postal Code</strong>',
        type: '',
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false,
        focusConfirm: false,
        customClass: 'swal2-overflow',
        html: html,
        width: 500,
        onOpen: function(){
            $('#btnChangePostalCode').click(function(){
                var postalCode = $("#inputPostalCode").val();
                console.log(postalCode);
                if(data.subdistrict_name == ''){
                    if(!confirm('Change postal code for all subdistricts of the following district?')) return;
                }
                else{
                    if(!confirm('Change postal code of the following subdistrict?')) return;
                }
                $("#btnChangePostalCode").attr("disabled", true);
                $("#btnChangePostalCode").html("Please wait");
                $.ajax({
                    method: 'POST',
                    url: '/tools/postalCodeFinder/postal-code/edit/',
                    dataType : "json",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        district_id : data.district_id,
                        subdistrict_id : data.subdistrict_id,
                        postal_code : postalCode
                    },
                    success: function(data){
                        $('#btnChangePostalCode').attr('disabled', false);
                        if(data.status == "Success"){
                            swalSuccess(data, false, 2000);
                            Swal.fire({
                                type: 'success',
                                title: 'Success!',
                                }).then(function(){ 
                                    location.reload();
                                }
                            );
                        } else {
                            swalError('Internal Error');
                        }
                    },
                    error: function(error){
                        $('#btnChangePostalCode').attr('disabled', false);
                        swalError('Internal Error');
                    }
                });
            });
        }
        }).then((result) => {   
            return;
        });
    });
});
