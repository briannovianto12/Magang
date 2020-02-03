window._callCourier = function(e, order_id, shipping_weight ){
    var html = '';
  
    $.get('/order-info/' + order_id)
    .done(function(data){
  
      //Backend return gram, convert into kgs
      data.shipping_weight = shipping_weight;
      data.id = order_id;
  
      // Use mustache
      var template = $('#pickup').html();
      Mustache.parse(template);   // optional, speeds up future uses
      
      html = Mustache.render(template, data);
  
      var today = new Date();
      var tomorrow = new Date();
      var hour = today.getHours();
      var validatePickupDate = new Date();
      if( hour < 12 ) {
        validatePickupDate = today;
      } else {
        tomorrow.setDate(today.getDate() + 1);
        validatePickupDate = tomorrow;
      }
    
      Swal.fire({                              
        // grow: 'fullscreen',
        title: '<strong>Panggil Kurir</strong>',
        type: '',
        html: html,
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        focusConfirm: false,
        customClass: 'swal2-overflow',
        onOpen: function(){
          $("[data-toggle='datepicker']").datepicker({
            todayHighlight: 1,
            daysOfWeekDisabled: [0],
            format: 'dd-mm-yyyy',
            orientation: "bottom left",
            startDate: validatePickupDate,
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
          }).on('show', function () {
              $(document).on('scroll', function () {
                  $("[data-toggle='datepicker']").datepicker('place')
              });
          })
          $('#btnKirim').click(function(){
              
              var data = {
                pickup_date: $('#pickup_date').val(),
                weight: $('#weight').val(),
                pickup_instruction: $('#pickup_instruction').val()
              }
  
              if( data.pickup_date == "") {
                alert("Pilih tanggal Pickup")
                $('#pickup_date').focus()
                return
              }
  
              var local_order_id = $(this).attr('data-order-id')
  
              $("#btnKirim").attr("disabled", true);
              $("#btnKirim").html("Harap tunggu");
  
              swal({ 
                title: "Harap tunggu",
                showConfirmButton: false,
              });
              
              $.ajax({
                method: 'POST',
                url: 'pickup/' + local_order_id,
                dataType : "json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'pickup_date': data.pickup_date,
                    'pickup_instruction': data.pickup_instruction,
                    'dimension_weight': data.weight
                },
                success: function(data){
                    if(data.status == 'OK' &&  data.special_id != '') {
                      Swal.fire({
                        type: 'success',
                        html:
                        '<h4 style="text-transform: uppercase; color:red;">' + 'Wajib tuliskan nomor pickup ini di paket anda' + '</h4> \n' +
                          '<h3 style="color:green">' + data.special_id + '</h3>' +
                          '<h5>' + 'Data berhasil dikirim ke kurir. Mohon tunggu kurir untuk Pickup' + '</h5>' ,
                        showCloseButton: true,
                        showCancelButton: false,
                        focusConfirm: false,
                        confirmButtonAriaLabel: 'OK',
                      })
                      location.reload(true);
  
                    } else {
                      $('#btnKirim').removeAttr("disabled");
                      $("#btnKirim").html("Kirim");
                      Swal.fire({
                        type: 'error',
                        title: 'Error.',
                        text: 'Oopps ada kesalahan sistem'
                      })
                    }
                },
                error: function(error){
                    console.log(error)
                    $('#btnKirim').removeAttr("disabled");
                    
                    Swal.fire({
                      type: 'error',
                      title: 'Error.',
                      text: 'Oopps ada kesalahan sistem'
                    })
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