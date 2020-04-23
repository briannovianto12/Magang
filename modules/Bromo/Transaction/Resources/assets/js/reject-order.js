window._rejectOrder = function _rejectOrder( order_id ){

    $.get('/order-info/' + order_id)
    .done(function(data){
      
      var template = $('#rejectOrder').html();
      Mustache.parse(template);   // optional, speeds up future uses
      html = Mustache.render(template, data);
  
      Swal.fire({                              
        // grow: 'fullscreen',
        title: '<strong>Reject order</strong>',
        type: '',
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false,
        focusConfirm: false,
        customClass: 'swal2-overflow',
        html: html,
        width: 500,
        onOpen: function(){
          $('#btnRejectOrder').click(function(){
              var reject_notes = $("#rejectNotes").val();
              
              if( reject_notes == "") {
                alert("Masukan Reject Notes")
                $('#rejectNotes').focus()
                return;
              }

              if(!confirm('Are you sure ?')) {
                return
              }

              $("#btnRejectOrder").attr("disabled", true);
              $("#btnRejectOrder").html("Please wait");
              $.ajax({
                  method: 'PUT',
                  url: '/order/reject-order/' + order_id,
                  dataType : "json",
                  data: {
                      '_token': $('meta[name="csrf-token"]').attr('content'),
                      reject_notes : reject_notes
                  },
                  success: function(data){
                      $('#btnRejectOrder').attr('disabled', false)
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
                      $('#btnRejectOrder').attr('disabled', false)
                      swalError('Internal Error')
                  }
              });
          })
        }
      }).then((result) => {   
            return
      })
    }).fail(function(e) {
      alert( "Internal Error" );
    }); 
  }