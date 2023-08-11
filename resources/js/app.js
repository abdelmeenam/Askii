import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Echo.private('App.Models.User.' + userId)
    .notification(function (notification) {
        alert(notification.body)
    });
