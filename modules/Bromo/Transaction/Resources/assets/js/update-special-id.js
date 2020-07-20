window._updatePickupNumber = function( order_id ){
    var html = '';

    $.get('/order-info/' + order_id)
    .done(function(data){

      data.id = order_id;
      // Use mustache
      var template = $('#update-special-id').html();
      Mustache.parse(template);   // optional, speeds up future uses
      html = Mustache.render(template, data);
      var order_no = data.order_no;

      Swal.fire({
        // grow: 'fullscreen',
        title: '<strong>Update Pickup Number</strong>',
        type: '',
        html: html,
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        focusConfirm: false,
        customClass: 'swal2-overflow',
        onOpen: function(){

          $('#btnUpdateSpecialId').click(function(){

              var data = {
                new_pickup_number: $('#newSpecialId').val(),
                order_no: order_no,
              }

              if( data.new_pickup_number == "") {
                alert("Masukan Nomor Pickup")
                $('#newSpecialId').focus()
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
                url: '/order/' + order_id + '/update-pickup-number',
                dataType : "json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'order_no': data.order_no,
                    'new_pickup_number': data.new_pickup_number,
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
