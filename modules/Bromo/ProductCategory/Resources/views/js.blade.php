<script type="text/javascript">
    function attachAttribute(url) {
        if (confirm('Are you sure add this attribute ?')) {
            App.ajax('post', url, {}, 'json', successAttachAttributeHandler);

            function successAttachAttributeHandler(response) {
                if (response.status === 'success') {
                    App.DisplaySuccess("{{ __('Attribute added to this Category') }}");

                    setTimeout(function () {
                        window.location.reload();
                    }, 2000)
                }
            }
        }
    }

    function detachAttribute(url) {
        if (confirm('Are you sure remove this attribute ?')) {
            App.ajax('delete', url, {}, 'json', successDetachAttributeHandler);


            function successDetachAttributeHandler(response) {
                if (response.status === 'success') {
                    App.DisplaySuccess("{{ __('Attribute removed from this Category') }}");

                    setTimeout(function () {
                        window.location.reload();
                    }, 2000)
                }
            }

        }
    }

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
                ext_id: {required: !0, maxlength: 64},
                sku_code: {maxlength: 4},
                level: {required: !0, maxlength: 4}
            }
        });

        var Select2 = {
            init: function () {

                $('#parent_id').select2({
                    placeholder: 'Choose a Parent Category',
                    width: '100%'
                });

                $('#level').select2({
                    placeholder: 'Choose a Category Level',
                    width: '100%'
                });
            }
        };
        Select2.init();
    });
</script>