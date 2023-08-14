import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Echo.private('App.Models.User.' + userId)
    .notification(function (notification) {
        //alert(notification.body)
        var notificationToast = document.getElementById('notification-toast')
        var toast = new bootstrap.Toast(notificationToast)
        document.getElementById('notification-body').innerHTML = notification.body
        document.getElementById('notification-title').innerHTML = notification.title
        document.getElementById('notification-time').innerHTML = new Date()
        toast.show()

        const countElement = document.getElementById('nm-count')
        let count = Number(countElement.innerText)
        countElement.innerText = count + 1

        const notificationElement = document.getElementById('nm-list')
        notificationElement.innerHTML = `<li><a class="dropdown-item" href="${notification.url}?notify_id=${notification.id}">
                    <h6>${notification.title}</h6>
                    <p>${notification.body}</p>
                    <p class="text-muted">${(new Date).toLocaleTimeString()}</p>
                </a></li>` + notificationElement.innerHTML


    });
