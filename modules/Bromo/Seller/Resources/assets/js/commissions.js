window._changeCommission = function (e, shop_id) {
  var html = '';

  $.get(shop_id + '/commission').done(function (data) {

    // Use mustache
    var template = $('#change-commission').html();
    Mustache.parse(template); // optional, speeds up future uses

    html = Mustache.render(template, data);

    Swal.fire({
      // grow: 'fullscreen',
      title: '<strong>Select Commission Type</strong>',
      type: '',
      html: html,
      showCloseButton: true,
      showCancelButton: false,
      showConfirmButton: false,
      focusConfirm: false,
      customClass: 'swal2-overflow',
      onOpen: function onOpen() {
        $('#btnChangeCommission').click(function () {
          var commissionId = $("input[name='commission-type']:checked").val();
          if (!confirm('Are you sure ?')) {
            return;
          }

          swal({ 
            title: "Harap tunggu",
            showConfirmButton: false,
          });

          $("#btnChangeCommission").attr("disabled", true);
          $("#btnChangeCommission").html("Please wait");
          $.ajax({
            method: 'PUT',
            url: shop_id + '/commission/post',
            dataType: "json",
            data: {
              '_token': $('meta[name="csrf-token"]').attr('content'),
              'commissionId': commissionId
            },
            success: function success(data) {
              $('#btnChangeCommission').attr('disabled', false);
              swalSuccess(data, false, 2000);
              if (data.status == 'OK') {
                Swal.fire({
                  type: 'success',
                  title: 'Success!'
                }).then(function () {
                  // Success
                  location.reload();
                });
              } else if (data.status == 'Failed') {
                Swal.fire({
                  type: 'error',
                  title: 'Change Commission Type Failed!'
                });
              }
            }
          });
        });
      }
    }).then(function (result) {
      return;
    });
  }).fail(function (e) {
    console.log(e);
    alert("Oops terjadi kesalahan pada sistem");
  });
};