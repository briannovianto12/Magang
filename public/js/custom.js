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
        DisplaySuccess: function (message, timer) {
            App.ShowAlertSuccess(message, timer);
        },
        DisplayError: function (message) {
            App.ShowAlertError(message);
        },
        ShowAlertSuccess: function (messageText, timer = 2000) {
            let timerInterval;
            Swal.fire({
                title: 'Successfully',
                html: messageText,
                timer: timer,
                onBeforeOpen: () => {
                    Swal.showLoading();
                },
                onClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.timer
                ) {
                    window.location.reload()
                }
            });
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