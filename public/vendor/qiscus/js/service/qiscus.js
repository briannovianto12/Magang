// This service is to bridge QiscusSDK with this sample app

define(['service/emitter'], function (emitter) {
    var qiscus = new QiscusSDKCore();
    var token = document.getElementById('token').value;

    const appId = document.getElementById('app-id').value;

    qiscus.init({
        AppId: appId,
        options: {
            loginSuccessCallback: function (authData) {
                emitter.emit('qiscus::login-success', authData)
            },
            newMessagesCallback: function (messages) {
                emitter.emit('qiscus::new-message', messages[0])
            },
            presenceCallback: function (data) {
                var isOnline = data.split(':')[0] === '1';
                var lastOnline = new Date(Number(data.split(':')[1]));
                emitter.emit('qiscus::online-presence', {
                    isOnline: isOnline,
                    lastOnline: lastOnline
                })
            },
            commentReadCallback: function (data) {
                emitter.emit('qiscus::comment-read', data)
            },
            commentDeliveredCallback: function (data) {
                emitter.emit('qiscus::comment-delivered', data)
            },
            typingCallback: function (data) {
                emitter.emit('qiscus::typing', data)
            }
        }
    });

    qiscus.verifyIdentityToken(token).then(function (userData) {
        qiscus.setUserWithIdentityToken(userData);
    }).catch(function (error) {
        console.info(error);
    });

    // qiscus.debugMode = true
    // qiscus.debugMQTTMode = true

    return qiscus
});
