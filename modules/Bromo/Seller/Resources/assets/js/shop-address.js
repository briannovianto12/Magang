window._changeAddress = function(e, shop_id ){
    var html = '';
  
    $.get(shop_id + '/business-address')
    .done(function(data){
      
      // Use mustache
      var template = $('#change-address').html();
      Mustache.parse(template);   // optional, speeds up future uses
      
      html = Mustache.render(template, data);
    
      Swal.fire({                              
        // grow: 'fullscreen',
        title: '<strong>Select Address For</strong>' + '&nbsp;' + '<stong>' + data.shop.name + '</strong>',
        type: '',
        html: html,
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        focusConfirm: false,
        customClass: 'swal2-overflow',
        onOpen: function(){
          $('#btnChangePickupAddress').click(function(){
            var addressId = $("input[name='address-line']:checked").val();
            
            if(!confirm('Are you sure ?')) {
              return
              }
            $("#btnChangePickupAddress").attr("disabled", true);
            $("#btnChangePickupAddress").html("Please wait");
            $.ajax({
                method: 'PUT',
                url: 'change-address/' + shop_id,
                dataType : "json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'addressId' : addressId
                },
                success: function(data){
                    console.log(data);
                    $('#btnChangePickupAddress').attr('disabled', false)
                    swalSuccess(data, false, 2000)
                    if ( data.status == 'OK') {
                      Swal.fire({
                        type: 'success',
                        title: 'Success!',
                      }).then(function(){ 
                        // Success
                        location.reload();
                      });  
                    } else if ( data.status == 'Failed') {
                      Swal.fire({
                        type: 'error',
                        title: 'Change pickup address Failed!',
                      })
                    } 
                },
            });
          })
        }
      }).then((result) => {
          return
      })
    })
    .fail(function(e) {
      console.log(e)
      alert( "Oops terjadi kesalahan pada sistem" );
    }); 
  }