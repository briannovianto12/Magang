window.swalError = function ( message, showConfirmButton, timer ) {
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

window._editLogistic = function (courier_id) {
  var html = '';
  $.get('courier-info/' + courier_id).done(function (data) {
    
    data.id = courier_id; // Use mustache

    var existing_provider_key = data.provider_key;
    var existing_courier_name = data.name;

    var template = $('#rename-courier-shipping').html();
    Mustache.parse(template); // optional, speeds up future uses

    html = Mustache.render(template, data);
  
    Swal.fire({                              
      // grow: 'fullscreen',
      title: '<strong>Update Shipping Courier</strong>',
      type: '',
      html: html,
      showCloseButton: true,
      showCancelButton: false,
      showConfirmButton: false,
      focusConfirm: false,
      customClass: 'swal2-overflow',
      onOpen: function(){
          console.log('sudah swal')
  
          $('#btnUpdateCourier').click(function(){
              
            var data = {
              newProviderKey: $('#newProviderKey').val(),
              newName: $('#newName').val(),
            }
        
            if( data.newProviderKey == "" || data.newName == "") {
               alert("Provider Key dan Name harus diisi!")
              return
            }
        
            swal({ 
              title: "Harap tunggu",
              showConfirmButton: false,
            });
            
            $.ajax({
              method: 'POST',
              url: 'courier-info/' + courier_id + '/edit',
              dataType : "json",
              data: {
                  '_token': $('meta[name="csrf-token"]').attr('content'),
                  'newProviderKey': data.newProviderKey,
                  'newName': data.newName
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
                      $('#master_courier').DataTable().ajax.reload(function(){
                        $('#btnUpdateCourier').removeAttr("disabled");
                        $("#btnUpdateCourier").html("Update");
                        })
                      }
                    ); 
                  } else if(data.status == 'Failed' ) {
                    Swal.fire({
                      type: 'error',
                      title: data.message,
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
                  console.log(error)
                  $('#btnUpdateCourier').removeAttr("disabled");
                  
                  swalError('Oopps ada kesalahan sistem')
              }
        
            });
        
        })


      }
    }).then((result) => {
        
        return
    })
  
  })
  .fail(function (e) {
    console.log(e);
    alert("Oops terjadi kesalahan pada sistem");
  });
};

window._editStatusCourier = function (courier_id) {
  var html = '';
  $.get('courier-info/' + courier_id).done(function (data) {
    
    data.id = courier_id; // Use mustache

    var existing_status = data.enabled;

    var template = $('#enable-disable-courier').html();
    Mustache.parse(template); // optional, speeds up future uses

    html = Mustache.render(template, data);
  
    Swal.fire({                              
      // grow: 'fullscreen',
      title: '<strong>Edit Courier Status</strong>',
      type: '',
      html: html,
      showCloseButton: true,
      showCancelButton: true,
      showConfirmButton: true,
      focusConfirm: false,
      customClass: 'swal2-overflow',
    }).then((isConfirm) => {
          if(isConfirm.value){
              var data = {};

              $.ajax({
                  method: 'POST',
                  url: 'courier-info/' + courier_id + '/enable-disable',
                  dataType : "json",
                  data: {
                      '_token': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(data){
                      if ( data.status == 'OK' ) {
                          Swal.fire({
                              type: 'success',
                              title: 'Success!',
                              showCloseButton: true,
                              showCancelButton: false,
                              focusConfirm: false,
                              confirmButtonAriaLabel: 'OK',
                          }).then(function(){
                              $('#master_courier').DataTable().ajax.reload();
                          });
                      } else if(data.status == 'Failed' ) {
                          swalError('Internal Error');
                      } else {
                          swalError('Error!');
                      }
                  },
                  error: function(error){
                      console.log(error)
                      swalError('Oopps ada kesalahan sistem');
                  }
              });
          }
         return;
      });
  })
  .fail(function (e) {
      console.log(e);
      alert("Oops terjadi kesalahan pada sistem");
  });
};