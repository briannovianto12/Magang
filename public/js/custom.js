var App = function () {
    return {
        // insert your custom js here
        ajax: function (httpMethod, url, data, type, successCallback) {
            return $.ajax({
                type: httpMethod.toUpperCase(),
                url: url,
                data: data,
                dataType: type,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: successCallback,
                error: function (err, type, httpStatus) {
                    App.ajaxFailureCallback(err, type, httpStatus);
                }
            });
        },
        ajaxFailureCallback: function (err, type, httpStatus) {
            var failureMessage = 'Error occurred in ajax call ' + err.status + ' - ' + err.responseText + " - " + httpStatus;
            console.log(failureMessage);
        },
        DisplaySuccess: function (message) {
            App.ShowAlertSuccess(message);
        },
        DisplayError: function (message) {
            App.ShowAlertError(message);
        },
        ShowAlertSuccess: function (messageText) {
            swal(
                'Successfully',
                messageText,
                'success'
            )
        },
        ShowAlertError: function (messageText) {
            swal(
                'Error',
                messageText,
                'error'
            )
        },

    }
}();