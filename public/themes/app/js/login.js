var BASE_URL = '';
var login = function () {

    return {
        setBaseURL: function (link) {
            BASE_URL = link;
        },
        getTimezone: function (data) {
            $.ajax({
                url: BASE_URL + '/set-timezone?timezone=' + jstz.determine().name(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                },
                error: function (data) {
                }
            });
            if (data.title) {
                swal(data.title, data.text, data.type);
            }
        },
        // insert here

        init: function () {
            // insert function here
        }
    };
}();

$(function () {
    // insert function here
});