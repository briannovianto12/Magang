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

function _refundOrder( data_id ) {
  console.log(data_id);
  $.get('/refund/info/' + data_id)
  .done(function(data){
    console.log(data);

    var template = $('#edit-refund-status').html();
    Mustache.parse(template);   // optional, speeds up future uses
    html = Mustache.render(template, data);

    Swal.fire({                              
      // grow: 'fullscreen',
      title: '<strong>Edit Refund Status</strong>',
      type: '',
      showCloseButton: false,
      showCancelButton: false,
      showConfirmButton: false,
      focusConfirm: false,
      customClass: 'swal2-overflow',
      html: html,
      width: 500,
      onOpen: function(){
        $('#btnRefundOrder').click(function(){
          if(!$('#refundDateInput').val()){
              alert('Warning: Date is empty');
              return
          }
          if(!confirm('Are you sure ?')) {
            return
          }
        
        var refundDate = $("#refundDateInput").val();
        var refundTime = $("#refundTimeInput").val();
        if(!$("#refundNotes").val()){
          var refundNotes = null;  
        }
        else{
          var refundNotes = $("#refundNotes").val();
        }
        var refund_id = $(this).attr('data-product-id')
        $("#btnRefundOrder").attr("disabled", true);
        $("#btnRefundOrder").html("Harap tunggu");

        $.ajax({
          method: 'PUT',
          url: '/refund/refund-order/' + refund_id,
          dataType : "json",
          data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            refundDate : refundDate,
            refundTime : refundTime,
            refundNotes : refundNotes
          },
          success: function(data){
            console.log(data);
            $('#btnUpdate').attr('disabled', false)
            swalSuccess(data, false, 2000)
            if ( data.status == 'OK') {
              Swal.fire({
                type: 'success',
                title: 'Edit Refund Status \n Order No: ' + data.order_no + '\nSuccess!',
              }).then(function(){ 
                $('#order_refund').DataTable().ajax.reload(function(){
                  $('#btnRefundOrder').removeAttr("disabled");
                  $("#btnRefundOrder").html("Update");
                  })
                }
              );  
            } if ( data.status == 'Failed') {
              Swal.fire({
                type: 'error',
                title: 'Edit Refund Status Failed!',
              }).then(function(){ 
                // Success
                $('#order_refund').DataTable().ajax.reload(function(){
                  $('#btnRefundOrder').removeAttr("disabled");
                  $("#btnRefundOrder").html("Update");
                  })
                }
              );
            } 
          },
          error: function(error){
            console.log(error)
            $('#btnRefundOrder').attr('disabled', false)
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