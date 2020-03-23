window._processDisbursement = function( header_id ){
    
    $.ajax({
        method: 'GET',
        url: '/disbursement/process/disb/' + header_id,
        dataType : "json",
        
        success: function(data){
            if ( data.status == 'OK' ) {
                Swal.fire({
                    type: 'success',
                    title: data.status,
                    text: "Reference No: " + data.reference,
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonAriaLabel: 'OK',
                })
                $('#disb_item').DataTable().ajax.reload();
            } else if ( data.status == 'FAILED' ) {
                Swal.fire({
                    type: 'error',
                    title: data.status,
                    text: data.error_code + "\nMessage: " + data.message,
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonAriaLabel: 'OK',
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
            }
        },
        error: function(error){
            Swal.fire({
                type: 'error',
                title: 'Something went wrong, Please try again or contact Administrator.',
                showCloseButton: true,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonAriaLabel: 'OK',
            })
            location.reload();
        }

    });
 
  }



window._createBatchDisbursement = function _createBatchDisbursement(){
      Swal.fire({                              
        // grow: 'fullscreen',
        title: '<strong>Create Batch Disbursement</strong>',
        type: '',
        html:
        '<form id="form-remark">' +
            '<div class="form-group">' +
                '<label>' +
                '</label>' +
                '<input id="input-remark" class="form-control" type="text" placeholder="Create batch disbursement remark" name="remark">' +
                '<br/>' +
              '<button type="button" class="btn btn-primary btn-lg btn-block" id="btnCreateBatchDisb">Submit</button>' +
            '</div>' +
        '</form>' ,
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        focusConfirm: false,
        customClass: 'swal2-overflow',
        onOpen: function(){
          
          $('#btnCreateBatchDisb').click(function(){
            var remark = $('#input-remark').val()  
              if( remark == "") {
                alert("Masukan Remark")
                $('#input-remark').focus()
                return
              }
  
              $("#btnCreateBatchDisb").attr("disabled", true);
              $("#btnCreateBatchDisb").html("Harap tunggu");
  
              swal({ 
                title: "Harap tunggu",
                showConfirmButton: false,
              });
              
              $.ajax({
                method: 'POST',
                url: '/disbursement/create',
                dataType : "json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'remark': remark,
                },
                success: function(data){
                  
                  if ( data.status == 'OK' ) {
                    Swal.fire({
                        type: 'success',
                        title: 'Disbursement Created, Reference No: ' + data.header_no,
                        text: 'Success! Created ' + data.saved + ' item(s).',
                        showCloseButton: true,
                        showCancelButton: false,
                        focusConfirm: false,
                        confirmButtonAriaLabel: 'OK',
                    })
                    $('#disb_header').DataTable().ajax.reload();
                  } else if ( data.status == 'FAILED' ) {
                      Swal.fire({
                          type: 'success',
                          title: 'No Disbursement Available',
                          text: 'Success!',
                          showCloseButton: true,
                          showCancelButton: false,
                          focusConfirm: false,
                          confirmButtonAriaLabel: 'OK',
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
                  }
                },
                error: function(error){
                }
              });
          })
        }
      }).then((result) => {
          return
      })
    }