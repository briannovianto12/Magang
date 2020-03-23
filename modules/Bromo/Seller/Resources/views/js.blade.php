<script type="text/javascript">
    $(document).ready(function () {

        $('#verify').on('click', 'button[name="submit"]', function () {

            var verifyUrl = $('#verify form').attr('action');

            $.post({
                url: verifyUrl,
                data: {
                    '_token': $('input[name="_token"]').val()
                },
                beforeSend: function () {
                    $('#verify button').addClass('disabled').attr('disabled', 'disabled')
                },
                success: function (response) {
                    var jwtUrl = $('input[name="jwt-route"]').val();
                    var userId = response.user_id;

                    $.post({
                        url: jwtUrl,
                        data: {
                            '_token': $('input[name="_token"]').val(),
                            'user_id': userId
                        },
                        success: function (response) {

                            var token = response.token;
                            var appId = response.app_id;

                            if (token != '') {
                                var qiscus = new QiscusSDKCore();
                                qiscus.init({
                                    AppId: appId,
                                    options: {
                                        loginSuccessCallback: function (authData) {
                                            console.info('success login');
                                        }
                                    }
                                });

                                qiscus.verifyIdentityToken(token).then(function (userData) {
                                    qiscus.setUserWithIdentityToken(userData);
                                }).catch(function (error) {
                                    alert(error);
                                });
                            }

                            $('span[name="shop_status"]').html(response.shop_status);
                            swal('Success!', 'Seller was approved', 'success');

                            $('.modal').modal('hide');
                            $('#approval').hide();
                        },
                        error: function (error) {
                            swal('Oh Snap!', 'Cannot create qiscus id', 'error');
                            $('#verify button').removeClass('disabled').removeAttr('disabled');
                        }
                    });


                },
                error: function (xhr) {
                    if(xhr.status === 400) {
                        swal('Cannot Approve!', xhr.responseJSON.message, 'warning');
                    } else {
                        swal('Oh Snap!', 'Look like something wen\'t wrong.', 'error');
                    }

                    $('#verify button').removeClass('disabled').removeAttr('disabled');
                }
            });
        });

        $('#reject').on('click', 'button[name="submit"]', function () {

            var rejectUrl = $('#reject form').attr('action');

            $.post({
                url: rejectUrl,
                data: {
                    '_token': $('input[name="_token"]').val(),
                    'notes': $('textarea[name="notes"]').val(),
                },
                beforeSend: function () {
                    $('#reject button').addClass('disabled').attr('disabled', 'disabled');
                },
                success: function (response) {
                    $('span[name="shop_status"]').html(response.shop_status);
                    $('#approval').hide();

                    $('.modal').modal('hide');
                    swal('Success!', 'Seller was rejected', 'success');
                },
                error: function (error) {
                    swal('Oh Snap!', 'Look like something wen\'t wrong.', 'error');
                    $('#reject button').removeClass('disabled').removeAttr('disabled');
                }
            });
        });

        @isset($data)
            if ("{{ route('store.show', $data->id) }}" === "{{ url()->current() }}") {
                var switchEl = $('#status');

                switchEl.on('change', function () {
                    $('#modal').modal('show');
                });

                $('#cancel').on('click', function () {
                    if ("{{ $data->status }}" == "{{ \Bromo\Seller\Models\ShopStatus::VERIFIED }}") {
                        switchEl.prop('checked', true);
                    } else {
                        switchEl.prop('checked', false);
                    }

                    $('#modal').modal('hide');
                });
            }
        @endisset

    })

    document.getElementById("cpy-btn").addEventListener("click", copy_address);

    function copy_address() {
        var copyText = document.getElementById("business-address");
        var textArea = document.createElement("textarea");
        textArea.value = copyText.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        alert('Text Copied!');
    }

    function swalSuccess( message, showConfirmButton, timer ) {
        Swal.fire({
          position: 'top',
          type: 'success',
          text: message,
          showConfirmButton: (showConfirmButton==undefined) ? true : false,
          timer: (timer) ? timer : null,
        })
    }

    function _verifyBank(route) {
        swal({
            title: "Are you sure?",
            type: "question",
            showCancelButton: true,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: route,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {_method: 'POST'},
                    success: function (response) {
                        location.reload();  
                    },
                    error: function () {
                        swal(
                            'Oh Snap!',
                            'Look like something wen\'t wrong.',
                            'error'
                        )
                    }
                });
            }
        });
    }
</script>