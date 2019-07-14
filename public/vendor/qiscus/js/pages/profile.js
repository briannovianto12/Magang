define([
    'jquery', 'service/route', 'service/content'
], function ($, route, $content) {
    var avatarBlobURL = null;

    function Profile() {
        var avatarURL = qiscus.userData.avatar_url;
        var username = qiscus.userData.username;
        var userId = qiscus.userData.email;
        return `
      <div class="Profile">
        <div class="toolbar">
          <button id="back-btn" type="button">
            <i class="icon icon-arrow-left-green"></i>
          </button>
          <div class="toolbar-title">Profile</div>
        </div>
        <div class="avatar-container">
          <input id="input-avatar" type="file" accept="image/*" class="hidden">
          <img class="profile-avatar" src="${avatarURL}" alt="${userId}">
        </div>
        <div class="info-container">
          <div class="info-header">
            Information
          </div>
          <div class="field-group">
            <div class="icon-container">
              <i class="icon icon-user"></i>
            </div>
            <input id="input-user-name" type="text" value="${username}" disabled>
          </div>
          <div class="field-group">
            <div class="icon-container">
              <i class="icon icon-id-card"></i>
            </div>
            <input id="input-user-id" type="text" value="${userId}" disabled>
          </div>
        </div>
      </div>
    `
    }

    $content.on('click', '.Profile #back-btn', function (event) {
        event.preventDefault();
        route.push('/chat')
    });

    Profile.path = '/profile';
    return Profile
});
