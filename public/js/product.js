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

function _loadCategories( url, target ) {
    // Load first level category
    $.get(url)
    .done(function(data){
      console.log(data);

      var template_category = $('#category').html();
      product_category = Mustache.render(template_category, data);

      $(target).html('<option value="">Pilih salah satu</option>')
      $(target).append(product_category)

      _toggleCategoryVisibility()
    }).fail(function(e) {
      console.log(e)
      alert( "Oops terjadi kesalahan pada sistem" );
    }); 
}
function _toggleCategoryVisibility(){
  if($('#form-edit-product #category2').html()=='') {
    $('#form-edit-product #category2').hide()
  } else {
    var subcat = $('#form-edit-product #category2 option').length;
    if(subcat > 1) {
      $('#form-edit-product #category2').show()
    } else {
      $('#form-edit-product #category2').hide()
    }
  }

  if($('#form-edit-product #category3').html()=='') {
    $('#form-edit-product #category3').hide()
  } else {
    var subcat = $('#form-edit-product #category3 option').length;
    if(subcat > 1) {
      $('#form-edit-product #category3').show()
    } else {
      $('#form-edit-product #category3').hide()
    }
  }

  if($('#form-edit-product #category4').html()=='') {
    $('#form-edit-product #category4').hide()
  } else {
    var subcat = $('#form-edit-product #category4 option').length;
    if(subcat > 1) {
      $('#form-edit-product #category4').show()
    } else {
      $('#form-edit-product #category4').hide()
    }
  }
}

function _edit( product_id ){
      var html = '';
      
      console.log(product_id);
      $.get('/product-info/' + product_id)
      .done(function(data){
        console.log(data);
        console.log(data.items);

        var template = $('#edit').html();
        Mustache.parse(template);   // optional, speeds up future uses
        html = Mustache.render(template, data);

        Swal.fire({                              
          // grow: 'fullscreen',
          title: '<strong>Edit Produk</strong>',
          type: '',
          showCloseButton: false,
          showCancelButton: false,
          showConfirmButton: false,
          focusConfirm: false,
          customClass: 'swal2-overflow',
          html: html,
          width: 500,
          onOpen: function(){
            _toggleCategoryVisibility()
            _loadCategories('/get-categories','#form-edit-product #category1');
            
            $('#category1').change(function(){
              category_id = $(this).val()
              console.log(category_id)
              _loadCategories('/get-categories/' + category_id,'#form-edit-product #category2');
              $('#form-edit-product #category3').html('');
              $('#form-edit-product #category4').html('');
            });

            $('#category2').change(function(){
              category_id = $(this).val()
              _loadCategories('/get-categories/' + category_id,'#form-edit-product #category3');
              $('#form-edit-product #category4').html('');
            });

            $('#category3').change(function(){
              category_id = $(this).val()
              _loadCategories('/get-categories/' + category_id,'#form-edit-product #category4');
            });

            $('#btnUpdate').click(function(){
              if(!confirm('Are you sure ?')) {
                return
              }

              var category1 = $("#category1").val();
              var category2 = $("#category2").val();
              var category3 = $("#category3").val();
              var category4 = $("#category4").val();
              
              if( category1 == "") {
                alert("Pilih kategori!")
                $('#category1').focus()
                return
              }
        
              var product_id = $(this).attr('data-product-id')
              $("#btnUpdate").attr("disabled", true);
              $("#btnUpdate").html("Harap tunggu");
              $.ajax({
                method: 'PUT',
                url: '/product/update/' + product_id,
                dataType : "json",
                data: {
                  '_token': $('meta[name="csrf-token"]').attr('content'),
                  maincategory : category1,
                  secondcategory : category2,
                  thirdcategory : category3,
                  fourthcategory : category4
                },
                success: function(data){
                  $('#btnUpdate').attr('disabled', false)
                  swalSuccess(data, false, 2000)
                  if ( data.status == 'OK') {
                    Swal.fire({
                      type: 'success',
                      title: 'Edit produk \n' + data.nama_produk + '\nBerhasil!',
                    }).then(function(){ 
                      $('#product_approve').DataTable().ajax.reload(function(){
                        $('#btnUpdate').removeAttr("disabled");
                        $("#btnUpdate").html("Update");
                        })
                      }
                    );  
                  } if ( data.status == 'Failed') {
                    Swal.fire({
                      type: 'error',
                      title: 'Masukkan kategori yang lengkap untuk kategori: \n' + data.category,
                    }).then(function(){ 
                      // Success
                      $('#product_approve').DataTable().ajax.reload(function(){
                        $('#btnUpdate').removeAttr("disabled");
                        $("#btnUpdate").html("Update");
                        })
                      }
                    );
                  } 
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


function _editWeight( data_id ) {
  var html = '';
  // var product_id = toString(product_id);
  console.log(data_id);
  $.get('/product-info/' + data_id)
  .done(function(data){
    console.log(data.data.id);

    var template = $('#edit-product-weight').html();
    Mustache.parse(template);   // optional, speeds up future uses
    html = Mustache.render(template, data);

    Swal.fire({                              
      // grow: 'fullscreen',
      title: '<strong>Edit Produk Weight</strong>',
      type: '',
      showCloseButton: false,
      showCancelButton: false,
      showConfirmButton: false,
      focusConfirm: false,
      customClass: 'swal2-overflow',
      html: html,
      width: 500,
      onOpen: function(){
        $('#btnUpdate').click(function(){
          if(!confirm('Are you sure ?')) {
            return
        }
        
        var newWeight = $("#new-weight").val();
              
        if( newWeight == "") {
          alert("Input nilai berat!")
          $('#category1').focus()
          return
        }

        var product_id = $(this).attr('data-product-id')
        $("#btnUpdate").attr("disabled", true);
        $("#btnUpdate").html("Harap tunggu");

        $.ajax({
          method: 'PUT',
          url: '/product/update-weight/' + product_id,
          dataType : "json",
          data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            newWeight : newWeight,
          },
          success: function(data){
            $('#btnUpdate').attr('disabled', false)
            swalSuccess(data, false, 2000)
            if ( data.status == 'OK') {
              Swal.fire({
                type: 'success',
                title: 'Edit produk \n' + data.nama_produk + '\nBerhasil!',
              }).then(function(){ 
                $('#product_approve').DataTable().ajax.reload(function(){
                  $('#btnUpdate').removeAttr("disabled");
                  $("#btnUpdate").html("Update");
                  })
                }
              );  
            } if ( data.status == 'Failed') {
              Swal.fire({
                type: 'error',
                title: 'Gagal mengganti berat!',
              }).then(function(){ 
                // Success
                $('#product_approve').DataTable().ajax.reload(function(){
                  $('#btnUpdate').removeAttr("disabled");
                  $("#btnUpdate").html("Update");
                  })
                }
              );
            } 
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