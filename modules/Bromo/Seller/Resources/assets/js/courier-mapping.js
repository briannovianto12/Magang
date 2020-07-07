  window._sellerCourierMapping = function (e, shop_id) {
    var html = '';

    $.get(shop_id + '/shipping-courier').done(function (data) {

      // Use mustache
      var template = $('#seller-courier-mapping').html();
      Mustache.parse(template); // optional, speeds up future uses

      html = Mustache.render(template, data);

      Swal.fire({
        grow: 'row',
        title: '<strong>Couriers for</strong>' + '&nbsp;' + '<stong>' + data.shop.name + '</strong>',
        type: '',
        html: html,
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        focusConfirm: false,
        customClass: 'swal2-overflow',
        onOpen: function onOpen() {
          $('#btnSellerCourierMapping').click(function () {
            var couriers = [];
            $("input[name='couriers']:checked").each(function () {
              couriers.push($(this).val())
            })

            if (!confirm('Are you sure ?')) {
              return;
            }
            $("#btnSellerCourierMapping").attr("disabled", true);
            $("#btnSellerCourierMapping").html("Please wait");
            $.ajax({
              method: 'POST',
              url: shop_id + '/shipping-courier',
              dataType: "json",
              data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'couriers': couriers
              },
              success: function success(data) {
                $('#btnSellerCourierMapping').attr('disabled', false);
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
                    title: 'Edit seller courier mapping Failed!'
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
        Swal.fire({
            type: 'error',
            title: 'Oops terjadi kesalahan pada sistem'
        });
    });
  };
