window._updateAwbShippingManifest = function( order_id ){
    var html = '';
  
    $.get('/order-info/' + order_id)
    .done(function(data){
  
      data.id = order_id;
      // Use mustache
      var template = $('#update-awb').html();
      Mustache.parse(template);   // optional, speeds up future uses
      html = Mustache.render(template, data);
      var order_no = data.order_no;
      var shipping_manifest_id = data.ids.shipping_manifest_id;

      Swal.fire({                              
        // grow: 'fullscreen',
        title: '<strong>Update Airwaybill Order Shipping Manifest</strong>',
        type: '',
        html: html,
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        focusConfirm: false,
        customClass: 'swal2-overflow',
        onOpen: function(){
          
          $('#btnUpdateAwb').click(function(){
              
              var data = {
                new_airwaybill: $('#newAwb').val(),
                order_no: order_no,
                shipping_manifest_id: shipping_manifest_id
              }
  
              if( data.new_airwaybill == "") {
                alert("Masukan Nomor Airwaybill")
                $('#newAwb').focus()
                return
              }
  
              $("#btnKirim").attr("disabled", true);
              $("#btnKirim").html("Harap tunggu");
  
              swal({ 
                title: "Harap tunggu",
                showConfirmButton: false,
              });
              
              $.ajax({
                method: 'POST',
                url: '/order/' + order_id + '/update-awb',
                dataType : "json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'order_no': data.order_no,
                    'new_airwaybill': data.new_airwaybill,
                    'shipping_manifest_id': data.shipping_manifest_id
                },
                success: function(data){
                    if ( data.status == 'OK' ) {
                      Swal.fire({
                        type: 'success',
                        title: data.message,
                        showCloseButton: true,
                        showCancelButton: false,
                        focusConfirm: false,
                        confirmButtonAriaLabel: 'OK',
                      }).then(function(){ 
                        $('#btnKirim').removeAttr("disabled");
                        $("#btnKirim").html("Kirim");
 
                        location.reload();
                        })
                    } else if(data.status == 'Failed' ) {
                      Swal.fire({
                        type: 'error',
                        title: data.message,
                        showCloseButton: true,
                        showCancelButton: false,
                        focusConfirm: false,
                        confirmButtonAriaLabel: 'OK',
                      })
                        $('#btnKirim').removeAttr("disabled");
                        $("#btnKirim").html("Kirim");
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Error!',
                            showCloseButton: true,
                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonAriaLabel: 'OK',
                          })
                            $('#btnKirim').removeAttr("disabled");
                            $("#btnKirim").html("Kirim");
                    }
                },
                error: function(error){
                    console.log(error)
                    $('#btnKirim').removeAttr("disabled");
                    
                    swalError('Oopps ada kesalahan sistem')
                }
  
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