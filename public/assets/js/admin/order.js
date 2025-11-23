document.addEventListener('DOMContentLoaded', () => {
    const rows = document.querySelectorAll('tbody tr[data-id]');
    const modal = document.getElementById('pesananModal');
    const modalContent = document.getElementById('modalContent');
    const closeModal = document.getElementById('closeModal');
    const closeModalBtn = document.getElementById('closeModalBtn');

    const getStatusBadge = (status) => {
        const statusMap = {
            'selesai': 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
            'pending': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
            'diproses': 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
            'dibatalkan': 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'
        };
        return statusMap[status.toLowerCase()] || 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
    };

    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(Number(amount));
    };

    rows.forEach(row => {
        row.addEventListener('click', () => {
            const id = row.dataset.id;
            const user = row.dataset.user;
            const tanggal = row.dataset.tanggal;
            const subtotal = row.dataset.subtotal;
            const status = row.dataset.status;

            modalContent.innerHTML = `
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">ID Pesanan</label>
                            <p class="text-gray-900 dark:text-white font-semibold">#NA-ORD-${id}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${getStatusBadge(status)}">
                                ${status}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Pelanggan</label>
                        <div class="flex items-center space-x-2 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-user text-white text-sm"></i>
                            </div>
                            <p class="text-gray-900 dark:text-white font-medium">${user}</p>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Pesanan</label>
                        <div class="flex items-center space-x-2 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <i class="fa-regular fa-calendar text-gray-400"></i>
                            <p class="text-gray-900 dark:text-white">${tanggal}</p>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pembayaran</label>
                        <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg border border-blue-100 dark:border-blue-800">
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">${formatCurrency(subtotal)}</p>
                        </div>
                    </div>
                `;

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
    });

    const closeModalHandler = () => {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

    closeModal.addEventListener('click', closeModalHandler);
    closeModalBtn.addEventListener('click', closeModalHandler);

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModalHandler();
        }
    });

    // Close modal dengan ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModalHandler();
        }
    });
});
