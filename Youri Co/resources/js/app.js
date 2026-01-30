import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Pusher
    const pusher = new Pusher('96bd48cc7d5a8023e49b', {
        cluster: 'ap2',
        forceTLS: true
    });

    // Initialize Laravel Echo
    const echo = new Echo({
        broadcaster: 'pusher',
        key: '96bd48cc7d5a8023e49b',
        cluster: 'ap2',
        encrypted: true,
        wsHost: window.location.hostname,
        wsPort: 6001,
        wssPort: 6001,
        forceTLS: true,
        disableStats: true,
    });

    echo.channel('sales')
        .listen('NewSaleEvent', (e) => {
            showNotification(e.sale);
        });

    function showNotification(sale) {
        let notificationDiv = document.getElementById('notifications');
        let notification = document.createElement('div');
        notification.classList.add('alert', 'alert-info');
        notification.innerText = 'You have a new sale: ' + sale.id;
        notificationDiv.appendChild(notification);

        // Use the Web Speech API to announce the notification
        let message = new SpeechSynthesisUtterance('You have a new sale: ' + sale.id);
        window.speechSynthesis.speak(message);

        setTimeout(() => {
            notificationDiv.removeChild(notification);
        }, 5000); // Remove notification after 5 seconds
    }
});
