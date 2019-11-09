window._internalNotes = function _internalNotes( order_id ){

    $.get('/internal-notes/' + order_id)
    .done(function(data){
      var template = $('#internalNotes').html();
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
          $('#btnAddInternalNotes').click(function(){
              var notes = $("#newInternalNotes").val();
              if(!confirm('Are you sure ?')) {
                  return
                  }
              $("#btnAddInternalNotes").attr("disabled", true);
              $("#btnAddInternalNotes").html("Please wait");
              $.ajax({
                  method: 'POST',
                  url: '/internal-notes/' + order_id,
                  dataType : "json",
                  data: {
                      '_token': $('meta[name="csrf-token"]').attr('content'),
                      notes : notes
                  },
                  success: function(data){
                      $('#btnAddInternalNotes').attr('disabled', false)
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
                      $('#btnAddInternalNotes').attr('disabled', false)
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