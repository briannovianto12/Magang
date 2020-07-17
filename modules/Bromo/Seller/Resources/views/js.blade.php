<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>

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
                    if ("{{ $data->status }}" == "{{ \Bromo\Seller\Models\ShopStatus::SUSPENDED }}") {
                        switchEl.prop('checked', true);
                    } else {
                        switchEl.prop('checked', false);
                    }

                    $('#modal').modal('hide');
                });


                $(".self-drop-status").bootstrapSwitch({
                    size: 'mini',
                    onText: 'Active',
                    offText: 'Set to Active',
                    onColor: 'custom-success',
                    offColor: 'default',
                }).on("switchChange.bootstrapSwitch", function (event, state) {
                    $(".self-drop-status").html(state);
                    $(this).val(state ? 1 : 0)
                    var value = $(this).val();
                    var id = $(this).attr('data-id');
                    var change = $(this);

                    swal({
                        title: "Are you sure?",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'Cancel'
                    }).then(function(isConfirm) {
                        var cancel = isConfirm.dismiss;
                        if (isConfirm && !cancel) {
                            $.ajax({
                                url: id + "/set-self-drop",
                                type: "POST",
                                data: {
                                    status: value,
                                    _token: '{{csrf_token()}}',
                                    _method: 'PUT'
                                },
                                success: function (data) {
                                    location.reload();
                                },
                                error: function(error){
                                    location.reload();
                                }
                            });
                        } else {
                            if(state != false){ change.bootstrapSwitch('state', false, true); }
                            if(state != true){ change.bootstrapSwitch('state', true, true); }
                            return false;
                        }
                    })
                })

                $(".seller-custom-courier-flag").bootstrapSwitch({
                    size: 'mini',
                    onText: 'Active',
                    offText: 'Set to Active',
                    onColor: 'custom-success',
                    offColor: 'default',
                }).on("switchChange.bootstrapSwitch", function (event, state) {
                    $(".seller-custom-courier-flag").html(state);
                    $(this).val(state ? 1 : 0)
                    var value = $(this).val();
                    var id = $(this).attr('data-id');
                    var change = $(this);

                    swal({
                        title: "Are you sure?",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'Cancel'
                    }).then(function(isConfirm) {
                        var cancel = isConfirm.dismiss;
                        if (isConfirm && !cancel) {
                            $.ajax({
                                url: id + "/set-custom-courier",
                                type: "POST",
                                data: {
                                    status: value,
                                    _token: '{{csrf_token()}}',
                                    _method: 'PUT'
                                },
                                success: function (data) {
                                    location.reload();
                                },
                                error: function(error){
                                    location.reload();
                                }
                            });
                        } else {
                            if(state != false){ change.bootstrapSwitch('state', false, true); }
                            if(state != true){ change.bootstrapSwitch('state', true, true); }
                            return false;
                        }
                    })
                })

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

    var maxLength = 124;

    $('textarea').keyup(function() {
      var length = $(this).val().length;
      var length = maxLength-length;
      $('#chars').text(length);
    });
</script>
