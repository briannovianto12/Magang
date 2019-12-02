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
            $('#internal-notes-table').DataTable({searching: false, info: false, processing: true,
                ajax: '/internal-notes/table/'+order_id,
                columns: [
                    {data: 'internal_notes', name: 'internal_notes'},
                    {data: 'admin_name', name: 'admin_name'},
                ],
                iDisplayLength: 5,
                dom: '<"top">rt<"bottom"p><"clear">', ordering: false, pagingType: "simple_numbers"});        
            $('#internal-notes-table').DataTable().draw();
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
                          });  
                  },
                  error: function(error){
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
      alert( "Internal Error" );
    }); 
}