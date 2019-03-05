<script type="text/javascript">

    var Repeater = {
        init: function (id) {
            if (id) {
                $("#" + id).repeater({
                    show: function () {
                        $(this).slideDown()
                    },
                    hide: function (e) {
                        confirm("Are you sure you want to delete this element?") && $(this).slideUp(e)
                    }
                });
            }
        },
        show: function (id) {
            $("#" + id).removeClass('m--hide');
        },
        hide: function (id) {
            $("#" + id).addClass('m--hide');
        },
        destroy: function () {

        }
    };

    var Select2 = {
        init: function () {
            $('#value_type').select2({
                placeholder: 'Choose a Value Type',
                width: '100%',
                minimumResultsForSearch: -1
            });
        }
    };

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

        Select2.init();
        Repeater.init("{{$repeater ?? ''}}");

        $('#value_type').on('select2:select', function (e) {
            if (e.params.data.id == 2) {
                Repeater.show("{{$repeater}}");
            } else {
                Repeater.hide("{{$repeater}}");
            }
        })
    });
</script>