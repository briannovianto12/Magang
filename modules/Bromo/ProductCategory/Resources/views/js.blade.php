<script type="text/javascript">
    function successDetachAttributeHandler(response) {
        if (response.status === 'success') {
            App.DisplaySuccess("{{ __('Attribute removed from this Category') }}");
        }
    }

    function successAttachAttributeHandler(response) {
        if (response.status === 'success') {
            App.DisplaySuccess("{{ __('Attribute added to this Category') }}");
        }
    }

    function successAttachBrandHandler(response) {
        if (response.status === 'success') {
            App.DisplaySuccess("{{ __('Brand added to this Category') }}");
        }
    }

    function successDetachBrandHandler(response) {
        if (response.status === 'success') {
            App.DisplaySuccess("{{ __('Brand removed from this Category') }}");
        }
    }

    function attachAttribute(url) {
        Swal.fire({
            title: 'Are you sure ?',
            text: 'Add attribute to this Product Category',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                App.ajax('post', url, {}, 'json', successAttachAttributeHandler);
            }
        });
    }

    function detachAttribute(url) {
        Swal.fire({
            title: 'Are you sure ?',
            text: 'Remove attribute from this Product Category',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                App.ajax('delete', url, {}, 'json', successDetachAttributeHandler);
            }
        });
    }

    function attachBrand(url) {
        Swal.fire({
            title: 'Are you sure ?',
            text: 'Add brand to this Product Category',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                App.ajax('post', url, {}, 'json', successAttachBrandHandler);
            }
        });
    }

    function detachBrand(url) {
        Swal.fire({
            title: 'Are you sure ?',
            text: 'Remove brand from this Product Category',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                App.ajax('delete', url, {}, 'json', successDetachBrandHandler);
            }
        });
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