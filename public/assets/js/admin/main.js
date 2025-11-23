// GEAR BUBBLE
// document.addEventListener('DOMContentLoaded', function () {
//     const gearBubble = document.getElementById('gearBubble');
//     const gearPopup = document.getElementById('gearPopup');
//     const closeBtn = document.getElementById('closeGearPopup');

//     gearBubble.addEventListener('click', () => {
//         gearPopup.style.display = gearPopup.style.display === 'flex' ? 'none' : 'flex';
//     });

//     closeBtn.addEventListener('click', () => {
//         gearPopup.style.display = 'none';
//     });

//     document.addEventListener('click', function (event) {
//         if (!gearPopup.contains(event.target) && !gearBubble.contains(event.target)) {
//             gearPopup.style.display = 'none';
//         }
//     });
// });

// MOBILE SEARCH TOGGLE
document.getElementById('mobile-search-toggle').addEventListener('click', function () {
    const mobileSearch = document.getElementById('mobile-search');
    mobileSearch.classList.toggle('hidden');
    mobileSearch.classList.toggle('animate-fadeIn');
});

// UPDATE NOTIFICATIONS
document.addEventListener('DOMContentLoaded', function () {
    const notifCount = document.getElementById('notif-count');
    const notifList = document.getElementById('notification-list');

    function updateNotifications() {
        axios.get(window.MainAdmin.routes.adminNotificationsCheck)
            .then(res => {
                const notifications = res.data.notifications;

                // Hitung total
                let total = 0;
                notifications.forEach(n => total += n.count);

                // Update badge
                if (total > 0) {
                    notifCount.textContent = total;
                    notifCount.classList.remove('hidden');
                } else {
                    notifCount.classList.add('hidden');
                }

                // Update dropdown
                notifList.innerHTML = '';
                notifications.forEach(n => {
                    if (n.count > 0) {
                        notifList.insertAdjacentHTML('beforeend', `
                            <a href="${n.url}" class="flex items-start p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 border-b border-gray-100 dark:border-gray-700">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-${n.color}-100 dark:bg-${n.color}-900 flex items-center justify-center">
                                    <i data-lucide="${n.icon}" class="h-5 w-5 text-${n.color}-600 dark:text-${n.color}-400"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-white dark:text-white">${n.title}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${n.message}</p>
                                </div>
                            </a>
                        `);
                    }
                });

                if (total === 0) {
                    notifList.innerHTML = `<div class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada notifikasi baru</div>`;
                }

                // Render Lucide icons
                window.createIcons({ icons: window.lucideIcons });
            })
            .catch(err => console.error(err));
    }

    // Polling setiap 10 detik
    updateNotifications();
    setInterval(updateNotifications, 60000);
});

function notifCenter() {
    return {
        open: false,
        order: [],
        chat: [],

        openModal() {
            this.open = true;
            this.loadData();
        },

        loadData() {
            axios.get(window.MainAdmin.routes.adminNotificationsAll)
                .then(res => {
                    let data = res.data;

                    this.order = data.order.map(o => {
                        let produkList = (Array.isArray(o.items) ? o.items : [])
                            .map(i => `${i.name} (x${i.qty})`)
                            .join(', ');

                        return {
                            id: o.id,
                            customer: o.customer,
                            products: produkList,
                            url: o.url
                        };
                    });

                    this.chat = data.chat;
                })
                .catch(err => console.error(err));
        }
    }
}

