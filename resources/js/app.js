import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// get time ago
function timeAgo() {
    let date = new Date();
    date.toLocaleString('en-US', { timeZone: 'Africa/Cairo' });
    let dayOfWeek = date.toLocaleString('en-US', { weekday: 'short' });
    let month = date.toLocaleString('en-US', { month: 'short' });
    let day = date.getDate();
    let year = date.getFullYear();
    let hours = date.getHours();
    let minutes = date.getMinutes();
    let seconds = date.getSeconds();
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12; // Map 0 to 12 for midnight
    let formattedDate = `${dayOfWeek} ${month} ${day} ${year} ${hours}:${minutes}:${seconds} ${ampm}`;
    return formattedDate;
}

window.Echo.private('App.Models.User.' + userId)
    .notification(function (notification) {
        //alert(notification.body)
        var notificationToast = document.getElementById('notification-toast')
        var toast = new bootstrap.Toast(notificationToast)
        document.getElementById('notification-body').innerHTML = notification.body
        document.getElementById('notification-title').innerHTML = notification.title
        document.getElementById("notification-image").src = notification.image
        document.getElementById('notification-time').innerHTML = timeAgo()
        toast.show()
        console.log(notification)

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
