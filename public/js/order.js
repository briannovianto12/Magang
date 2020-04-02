$('[data-toggle="tooltip"]').tooltip();
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

      console.log(order_id);
      $.get('/order-info/' + order_id)
      .done(function(data){
        var template = $('#edit').html();
        Mustache.parse(template);   // optional, speeds up future uses
        var html = Mustache.render(template, data);

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
            var currWeight = Math.ceil(parseFloat($('#curr-weight').attr('placeholder')));
            var newWeight = 0;
            var newCost = 0;
            $('#new-weight').change(function(){
                newWeight = Math.ceil(parseInt($(this).val()));
                newCost = Math.ceil(((newWeight)/Math.ceil(currWeight))*currCost);
                $('#new-cost').attr('placeholder', "IDR ".concat(newCost.toString()).concat(".00"));
            });

            $('#btnUpdate').click(function(){
                if(!confirm('Are you sure ?')) {
                    return
                }
                var newWeight = Math.ceil(parseFloat($('#new-weight').val())*1000);
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
          title: '<strong>Edit Order Status</strong>',
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

function _changeOrderSuccess( order_id ){

      $.get('/order-info/' + order_id)
      .done(function(data){
        
        var template = $('#changeOrderSuccess').html();
        Mustache.parse(template);   // optional, speeds up future uses
        html = Mustache.render(template, data);

        Swal.fire({                              
          // grow: 'fullscreen',
          title: '<strong>Are you sure want to success this order ?</strong>',
          type: '',
          showCloseButton: false,
          showCancelButton: false,
          showConfirmButton: false,
          focusConfirm: false,
          customClass: 'swal2-overflow',
          html: html,
          width: 500,
          onOpen: function(){
            $('#btnChangeOrderSuccess').click(function(){
                var orderNo = $("#orderNo").val();
                var notes = $("#changeNotes").val();
                if(orderNo == ''){
                  alert('Please re-enter Order No.');
                }
                else if(orderNo != data.order_no){
                  alert('Order No. is not valid!');
                }
                else if(!confirm('This action cannot be undone. Proceed ?')) {
                    return;
                }
                else{
                  $("#btnChangeOrderSuccess").attr("disabled", true);
                  $("#btnChangeOrderSuccess").html("Please wait");
                  $.ajax({
                      method: 'GET',
                      url: '/order/change-order-success/' + order_id,
                      dataType : "json",
                      data: {
                          '_token': $('meta[name="csrf-token"]').attr('content'),
                          orderNo : orderNo,
                          notes : notes
                      },
                      success: function(data){
                          $('#btnChangeOrderSuccess').attr('disabled', false)
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
                          $('#btnChangeOrderSuccess').attr('disabled', false);
                          swalError('Internal Error');
                      }
                  });
                }
            })
          }
        }).then((result) => {   
              return;
        })
      }).fail(function(e) {
        console.log(e);
        alert( "Internal Error" );
      }); 
    }

function _changePickedUp( order_id ){

      $.get('/order-info/' + order_id)
      .done(function(data){
        
        var template = $('#changePickedUp').html();
        Mustache.parse(template);   // optional, speeds up future uses
        html = Mustache.render(template, data);

        Swal.fire({
          // grow: 'fullscreen',
          title: '<strong>Change To Pickup</strong>',
          type: '',
          showCloseButton: false,
          showCancelButton: false,
          showConfirmButton: false,
          focusConfirm: false,
          customClass: 'swal2-overflow',
          html: html,
          width: 500,
          onOpen: function(){
            $('#btnChangePickedUp').click(function(){
                var notes = $("#changeNotes").val();
                if(!confirm('Are you sure ?')) {
                    return
                    }
                $("#btnChangePickedUp").attr("disabled", true);
                $("#btnChangePickedUp").html("Please wait");
                $.ajax({
                    method: 'GET',
                    url: '/order/change-picked-up/' + order_id,
                    dataType : "json",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        notes : notes
                    },
                    success: function(data){
                        $('#btnChangePickedUp').attr('disabled', false);
                        swalSuccess(data, false, 2000);
                        Swal.fire({
                            type: 'success',
                            title: 'Success!',
                            }).then(function(){ 
                                location.reload();
                            }
                        );  
                    },
                    error: function(error){
                        console.log(error);
                        $('#btnChangePickedUp').attr('disabled', false);
                        swalError('Internal Error');
                    }
                });
            })
          }
        }).then((result) => {   
              return;
        })
      }).fail(function(e) {
        console.log(e);
        alert( "Internal Error" );
      }); 
    }

function _copyToClipboard( value ){
      event.preventDefault();
      const tempField = document.createElement('textarea');
      tempField.value = value;
      document.body.appendChild(tempField);
      tempField.focus();
      tempField.select();
      document.execCommand('copy');
      document.body.removeChild(tempField);
      
      originalTitle = $(event.target).attr('data-original-title');
      $(event.target).attr('data-original-title', 'Copied!')
        .tooltip('show')
        .attr('data-original-title', originalTitle);
    }