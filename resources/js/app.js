import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'aa4422',
    cluster: 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});

window.Echo.channel('orders')
    .listen('.App\\Events\\NewOrderEvent', (e) => {
        console.log('New order received:', e);
    });








    document.addEventListener('DOMContentLoaded', function () {
        let notificationCount = 0;

        const token = localStorage.getItem('token');

        if (!token) {
            window.location.href = '/login';
        }




        document.getElementById('app').style.display = 'block';
        if (typeof window.Echo !== 'undefined') {
            const notificationsDropdown = document.getElementById('notificationDropdownMenu');
            const orderDetailsTable = document.getElementById('order-details');
            const apiOrdersTable = document.getElementById('api-orders');


            window.Echo.channel('orders')
                .listen('NewOrderEvent', (e) => {
                    console.log('New order received from socket:', e);
                    notificationCount++;
                    document.getElementById('notificationBadge').textContent = notificationCount;
                    const notificationElement = document.createElement('a');
                    notificationElement.classList.add('dropdown-item');
                    notificationElement.innerHTML = `New order received from ${e.order.user_name}`;
                    notificationsDropdown.appendChild(notificationElement);
                    const orderRow = document.createElement('tr');
                    orderRow.innerHTML = `
                        <td>${e.order.id}</td>
                        <td>${e.order.user_name}</td>
                        <td>${e.order.user_email}</td>
                        <td>${e.order.user_phone}</td>
                        <td>${e.order.address}</td>
                        <td>${e.order.total_price}</td>
                        <td>${e.order.status}</td>
                    `;

                    orderDetailsTable.appendChild(orderRow);
                });


                fetch('/api/orders', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);

                if (Array.isArray(data.data)) {
                    data.data.forEach(order => {
                        const orderRow = document.createElement('tr');
                        orderRow.innerHTML = `
                            <td>${order.id}</td>
                            <td>${order.user_name}</td>
                            <td>${order.user_email}</td>
                            <td>${order.user_phone}</td>
                            <td>${order.address}</td>
                            <td>${order.total_price}</td>
                            <td>${order.status}</td>
                        `;
                        apiOrdersTable.appendChild(orderRow);
                    });
                } else {
                    console.error('API response data is not an array or does not contain iterable data:', data);
                }
            })
            .catch(error => console.error('Error fetching orders from API:', error));
        } else {
            console.error('Laravel Echo is not defined. Check your Echo configuration.');
        }
    });








