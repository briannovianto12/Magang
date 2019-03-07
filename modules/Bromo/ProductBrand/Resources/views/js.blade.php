<script type="text/javascript">
    $(document).ready(function () {

        $('#validate').on('click', function () {
            if ($('#form').valid()) {
                $('#confirm-submit').modal('show');
            }
        });

        $('#form').validate({
            ignore: ':hidden',
            errorPlacement: function (error, element) {
                let id, e;
                id = '#' + element[0].id + '_help';
                e = $(id);

                error.insertBefore(e);
            },
            rules: {
                name: {required: !0, maxlength: 64},
                sku_part: {required: 0, maxlength: 4}
            }
        });

    });
</script>