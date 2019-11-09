function swalError ( message, showConfirmButton, timer ) {
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

function _edit( order_id ){
      var html = '';

      console.log(order_id);
      $.get('/shipping-manifest-info/' + order_id)
      .done(function(data){
        var template = $('#edit').html();
        Mustache.parse(template);   // optional, speeds up future uses
        html = Mustache.render(template, data);

        Swal.fire({                              
          // grow: 'fullscreen',
          title: '<strong>Edit Weight</strong>',
          type: '',
          showCloseButton: false,
          showCancelButton: false,
          showConfirmButton: false,
          focusConfirm: false,
          customClass: 'swal2-overflow',
          html: html,
          width: 500,
          onOpen: function(){
            var currCost = parseInt($('#curr-cost').attr('placeholder').replace ( /[^\d.]/g, '' ));
            var currWeight = parseFloat($('#curr-weight').attr('placeholder'));
            var baseCost = currCost/(Math.ceil(currWeight)*1000);
            var newWeight = 0;
            var newCost = 0;
            $('#new-weight').change(function(){
                var newWeight = Math.ceil(parseInt($(this).val()))*1000;
                var newCost = Math.ceil((newWeight)*baseCost);
                $('#new-cost').attr('placeholder', "IDR ".concat(newCost.toString()).concat(".00"));
            });

            $('#btnUpdate').click(function(){
                if(!confirm('Are you sure ?')) {
                    return
                    }
                var newWeight = parseFloat($('#new-weight').val())*1000;
                var newCost = parseInt($('#new-cost').attr('placeholder').replace ( /[^\d.]/g, '' ));
                var shippingManifestId = data.ids.shipping_manifest_id;
                console.log(shippingManifestId);
                $("#btnUpdate").attr("disabled", true);
                $("#btnUpdate").html("Harap tunggu");
                $.ajax({
                    method: 'PUT',
                    url: '/order/update/' + order_id,
                    dataType : "json",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        shippingmanifest : shippingManifestId,
                        newweight : newWeight,
                        newcost : newCost
                    },
                    success: function(data){
                        $('#btnUpdate').attr('disabled', false)
                        swalSuccess(data, false, 2000)
                        Swal.fire({
                            type: 'success',
                            title: 'Success!',
                            }).then(function(){ 
                                location.reload();
                            }
                        );  
                    },
                    error: function(error){
                        console.log(error)
                        $('#btnUpdate').attr('disabled', false)
                        swalError('Oopps ada kesalahan sistem')
                    }
                });
            })
          }
        }).then((result) => {   
              return
        })
      }).fail(function(e) {
        console.log(e)
        alert( "Oops terjadi kesalahan pada sistem" );
      }); 
    }

function _changeStatus( order_id ){

      $.get('/order-info/' + order_id)
      .done(function(data){
        
        var template = $('#editStatus').html();
        Mustache.parse(template);   // optional, speeds up future uses
        html = Mustache.render(template, data);

        Swal.fire({                              
          // grow: 'fullscreen',
          title: '<strong>Internal Notes</strong>',
          type: '',
          showCloseButton: false,
          showCancelButton: false,
          showConfirmButton: false,
          focusConfirm: false,
          customClass: 'swal2-overflow',
          html: html,
          width: 500,
          onOpen: function(){
            $('#btnEditStatus').click(function(){
                var notes = $("#changeNotes").val();
                if(!confirm('Are you sure ?')) {
                    return
                    }
                $("#btnEditStatus").attr("disabled", true);
                $("#btnEditStatus").html("Please wait");
                $.ajax({
                    method: 'GET',
                    url: '/order/change-status/' + order_id,
                    dataType : "json",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        notes : notes
                    },
                    success: function(data){
                        $('#btnEditStatus').attr('disabled', false)
                        swalSuccess(data, false, 2000)
                        Swal.fire({
                            type: 'success',
                            title: 'Success!',
                            }).then(function(){ 
                                location.reload();
                            }
                        );  
                    },
                    error: function(error){
                        console.log(error)
                        $('#btnEditStatus').attr('disabled', false)
                        swalError('Internal Error')
                    }
                });
            })
          }
        }).then((result) => {   
              return
        })
      }).fail(function(e) {
        console.log(e)
        alert( "Internal Error" );
      }); 
    }