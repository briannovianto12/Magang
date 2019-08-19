<script type="text/javascript">
    $(document).ready(function () {

        $('#form').validate({
            ignore: ':hidden',
            errorPlacement: function (error, element) {
                id = '#' + element[0].id + '_help';
                e = $(id);

                error.insertBefore(e);
            },
            rules: {
                email: {required: true, email: 'email'},
                password: {required: true},
                new_password: {required: true},
                new_password_confirmation: {required: true},
            }
        });
    });
</script>