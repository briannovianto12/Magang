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
                    $('#verify button').addClass('disabled');
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
                    swal('Oh Snap!', 'Look like something wen\'t wrong.', 'error');
                    $('#verify button').removeClass('disabled');
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
                    $('#reject button').addClass('disabled');
                },
                success: function (response) {
                    $('span[name="shop_status"]').html(response.shop_status);
                    $('#approval').hide();

                    $('.modal').modal('hide');
                    swal('Success!', 'Seller was rejected', 'success');
                },
                error: function (error) {
                    swal('Oh Snap!', 'Look like something wen\'t wrong.', 'error');
                    $('#reject button').removeClass('disabled');
                }
            });
        });

    })
</script>