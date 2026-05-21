// Account Page JavaScript
(function () {
    "use strict";

    // Global variables
    let currentUlasanId = null;
    const config = window.Account || {};

    // DOM Content Loaded
    document.addEventListener("DOMContentLoaded", function () {
        initializeOrderFilter();
        initializeWishlist();
        initializeTabs();
        initializeModals();
        initializeReviewForm();
    });

    // Order Status Filter
    function initializeOrderFilter() {
        const statusFilter = document.getElementById("statusFilter");
        const orderCards = document.querySelectorAll(".order-card");

        if (!statusFilter) return;

        statusFilter.addEventListener("change", function () {
            const selected = this.value;
            orderCards.forEach((card) => {
                const status = card.getAttribute("data-status");
                card.style.display =
                    selected === "all" || status === selected
                        ? "block"
                        : "none";
            });
        });
    }

    // Wishlist Management
    function initializeWishlist() {
        const removeButtons = document.querySelectorAll(".remove-wishlist");
        if (!removeButtons.length || !config.CSRF) return;

        removeButtons.forEach((button) => {
            button.addEventListener("click", handleWishlistRemoval);
        });
    }

    async function handleWishlistRemoval() {
        const id = this.dataset.id;
        const itemElement = document.getElementById(`wishlist-item-${id}`);
        const wishlistRemove = config.wishlistRemove?.replace(":id", id);

        if (!wishlistRemove) return;

        const confirmation = await Swal.fire({
            title: "Hapus dari Wishlist?",
            text: "Produk ini akan dihapus dari daftar wishlist kamu.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus",
            cancelButtonText: "Batal",
        });

        if (confirmation.isConfirmed) {
            try {
                const response = await fetch(wishlistRemove, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": config.CSRF,
                        Accept: "application/json",
                    },
                });

                if (response.ok) {
                    if (itemElement) {
                        itemElement.classList.add(
                            "opacity-0",
                            "scale-90",
                            "transition",
                            "duration-300"
                        );
                        setTimeout(() => itemElement.remove(), 300);
                    }

                    await Swal.fire({
                        icon: "success",
                        title: "Dihapus!",
                        text: "Produk berhasil dihapus dari wishlist.",
                        timer: 1500,
                        showConfirmButton: false,
                    });
                } else {
                    throw new Error("Gagal menghapus wishlist");
                }
            } catch (error) {
                await Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: "Gagal menghapus wishlist.",
                });
            }
        }
    }

    // Tab Navigation
    function initializeTabs() {
        const tabs = document.querySelectorAll(".tab");
        const contents = document.querySelectorAll(".tab-content");

        if (!tabs.length) return;

        tabs.forEach((tab) => {
            tab.addEventListener("click", function () {
                const target = this.getAttribute("data-tab");

                tabs.forEach((t) =>
                    t.classList.remove(
                        "border-black",
                        "text-black",
                        "active-tab"
                    )
                );
                this.classList.add("border-black", "text-black", "active-tab");

                contents.forEach((c) => c.classList.add("hidden"));
                const targetContent = document.getElementById(target);
                if (targetContent) {
                    targetContent.classList.remove("hidden");
                }
            });
        });
    }

    // Image Validation
    function validateImages(input) {
        const maxSize = 5 * 1024 * 1024;
        for (const file of input.files) {
            if (file.size > maxSize) {
                alert(`File "${file.name}" melebihi 5MB!`);
                input.value = "";
                break;
            }
        }
    }

    // Modal Management
    function initializeModals() {
        const orderModal = document.getElementById("orderModal");
        const ulasanModal = document.getElementById("ulasanModal");

        if (orderModal) {
            orderModal.addEventListener("click", function (e) {
                if (e.target === this) closeOrderModal();
            });
        }

        if (ulasanModal) {
            ulasanModal.addEventListener("click", function (e) {
                if (e.target === this) closeUlasanModal();
            });
        }

        // Initialize edit ulasan form
        const editUlasanForm = document.getElementById("editUlasanForm");
        if (editUlasanForm) {
            editUlasanForm.addEventListener("submit", handleEditUlasanSubmit);
        }

        // Initialize create ulasan form
        const ulasanForm = document.getElementById("ulasanForm");
        if (ulasanForm) {
            ulasanForm.addEventListener("submit", handleCreateUlasanSubmit);
        }
    }

    // Review Modal Functions
    window.openUlasanModal = function (ulasanId, orderItemId = null) {
        currentUlasanId = ulasanId;
        const modal = document.getElementById("ulasanModal");
        if (modal) {
            modal.classList.remove("hidden");
            modal.classList.add("flex");
            loadUlasanDetail(ulasanId);
            closeOrderModal();
        }
    };

    window.closeUlasanModal = function () {
        const modal = document.getElementById("ulasanModal");
        if (modal) {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
            currentUlasanId = null;
        }
    };

    function loadUlasanDetail(ulasanId) {
        if (!config.routes?.ulasanShow) return;

        fetch(config.routes.ulasanShow(ulasanId))
            .then((response) => response.json())
            .then((ulasan) => {
                displayUlasanDetail(ulasan);
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire("Error", "Gagal memuat detail ulasan", "error");
            });
    }

    function displayUlasanDetail(ulasan) {
        const content = document.getElementById("ulasanDetailContent");
        const title = document.getElementById("ulasanModalTitle");

        if (!content || !title) return;

        title.textContent = "Detail Ulasan";

        // ⭐ Generate Rating Stars
        let stars = "";
        for (let i = 1; i <= 5; i++) {
            stars +=
                i <= ulasan.rating
                    ? '<i class="fas fa-star star-rating"></i>'
                    : '<i class="far fa-star star-rating"></i>';
        }

        // 🖼️ Foto Ulasan
        let photosHTML = "";
        if (ulasan.fotos && ulasan.fotos.length > 0) {
            photosHTML = `
            <div class="mt-4">
                <p class="font-medium text-gray-700 mb-2">Foto Ulasan:</p>
                <div class="grid grid-cols-3 gap-2">
        `;
            ulasan.fotos.forEach((foto) => {
                photosHTML += `
                <img src="${config.storageUrl}/${foto.foto}"
                     class="w-full h-24 object-cover rounded-lg border">
            `;
            });
            photosHTML += `</div></div>`;
        }

        // 💬 Balasan Admin
        let adminReplyHTML = "";
        if (ulasan.admin_reply) {
            adminReplyHTML = `
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="font-semibold text-blue-900 mb-1">Balasan Admin:</p>
                <p class="text-blue-800 leading-relaxed">${ulasan.admin_reply}</p>
            </div>
        `;
        }

        // ✨ Final Render
        content.innerHTML = `
        <div>
            <div class="flex items-center mb-4">
                <div class="flex mr-2">${stars}</div>
                <span class="text-lg font-semibold">${ulasan.rating}.0</span>
            </div>

            <p class="text-gray-700 mb-4">${ulasan.komentar || "-"}</p>

            ${photosHTML}

            ${adminReplyHTML}

            <div class="mt-6 flex justify-end">
                <button onclick="showEditUlasanForm(${ulasan.id})"
                        class="bg-red-900 text-white px-4 py-2 rounded-lg hover:bg-red-800 transition">
                    Edit Ulasan
                </button>
            </div>
        </div>
    `;

        document
            .getElementById("ulasanDetailContent")
            .classList.remove("hidden");
        document.getElementById("ulasanEditContent").classList.add("hidden");
    }

    window.showEditUlasanForm = function (ulasanId) {
        if (!config.routes?.ulasanEdit) return;

        fetch(config.routes.ulasanEdit(ulasanId))
            .then((response) => response.json())
            .then((ulasan) => {
                displayEditUlasanForm(ulasan);
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire("Error", "Gagal memuat form edit", "error");
            });
    };

    function displayEditUlasanForm(ulasan) {
        const title = document.getElementById("ulasanModalTitle");
        if (title) {
            title.textContent = "Edit Ulasan";
        }

        const ratingSelect = document.querySelector(
            '#editUlasanForm select[name="rating"]'
        );
        const komentarTextarea = document.querySelector(
            '#editUlasanForm textarea[name="komentar"]'
        );

        if (ratingSelect) ratingSelect.value = ulasan.rating;
        if (komentarTextarea) komentarTextarea.value = ulasan.komentar || "";

        const currentPhotos = document.getElementById("currentPhotos");
        if (currentPhotos) {
            currentPhotos.innerHTML = "";

            if (ulasan.fotos && ulasan.fotos.length > 0) {
                ulasan.fotos.forEach((foto) => {
                    currentPhotos.innerHTML += `
                        <div class="relative">
                            <img src="${config.storageUrl}/${foto.foto}" class="w-full h-24 object-cover rounded-lg border">
                            <button type="button" onclick="hapusFotoUlasan(${foto.id})" class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center transform translate-x-1/2 -translate-y-1/2">×</button>
                        </div>
                    `;
                });
            } else {
                currentPhotos.innerHTML =
                    '<p class="text-gray-500 text-sm">Belum ada foto</p>';
            }
        }

        document.getElementById("ulasanDetailContent").classList.add("hidden");
        document.getElementById("ulasanEditContent").classList.remove("hidden");
    }

    window.showUlasanDetail = function () {
        if (currentUlasanId) {
            loadUlasanDetail(currentUlasanId);
        }
    };

    function handleEditUlasanSubmit(e) {
        e.preventDefault();

        if (!currentUlasanId || !config.routes?.ulasanUpdate) return;

        const formData = new FormData(this);

        fetch(config.routes.ulasanUpdate(currentUlasanId), {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": config.CSRF,
                "X-HTTP-Method-Override": "PUT",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: data.success ?? "Ulasan berhasil di edit.",
                        toast: true,
                        position: "top-end",
                        customClass: {
                            popup: "modern-toast",
                        },
                        showConfirmButton: false,
                        timer: 1800,
                        background: "rgba(255, 255, 255, 0.25)",
                        color: "#0f172a",
                        iconColor: "#10b981",
                    });
                    loadUlasanDetail(currentUlasanId);
                } else {
                    Swal.fire(
                        "Error",
                        data.error || "Gagal memperbarui ulasan",
                        "error"
                    );
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire(
                    "Error",
                    "Terjadi kesalahan saat memperbarui ulasan",
                    "error"
                );
            });
    }

    function handleCreateUlasanSubmit(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": config.CSRF,
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire("Sukses", data.success, "success");
                    closeOrderModal();
                } else {
                    Swal.fire(
                        "Error",
                        data.error || "Gagal mengirim ulasan",
                        "error"
                    );
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire(
                    "Error",
                    "Terjadi kesalahan saat mengirim ulasan",
                    "error"
                );
            });
    }

    window.hapusFotoUlasan = function (fotoId) {
        if (!config.routes?.ulasanFotoDelete) return;

        Swal.fire({
            title: "Hapus Foto?",
            text: "Foto ini akan dihapus permanen",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(config.routes.ulasanFotoDelete(fotoId), {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": config.CSRF,
                        Accept: "application/json",
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            Swal.fire("Terhapus!", data.success, "success");
                            showEditUlasanForm(currentUlasanId);
                        } else {
                            Swal.fire(
                                "Error",
                                data.error || "Gagal menghapus foto",
                                "error"
                            );
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        Swal.fire(
                            "Error",
                            "Terjadi kesalahan saat menghapus foto",
                            "error"
                        );
                    });
            }
        });
    };

    // Order Modal Functions
    window.openOrderModal = function (orderId) {
        const orderDiv = document.querySelector(
            `.order-data[data-id='${orderId}']`
        );
        if (!orderDiv) return;

        const items = JSON.parse(orderDiv.getAttribute("data-items") || "[]");
        const status = orderDiv.getAttribute("data-status") || "-";
        const subtotal = orderDiv.getAttribute("data-subtotal") || 0;

        document.getElementById("ulasanContainer").classList.add("hidden");

        document.getElementById("modalOrderId").textContent = orderId;
        document.getElementById("modalOrderStatus").textContent = status;
        document.getElementById("modalOrderSubtotal").textContent =
            "Rp " + Number(subtotal).toLocaleString("id-ID");

        const detailOrderLink = document.getElementById("detailOrderLink");
        if (detailOrderLink && config.routes?.orderShow) {
            detailOrderLink.href = config.routes.orderShow(orderId);
        }

        const itemsContainer = document.getElementById("modalOrderItems");
        if (itemsContainer) {
            itemsContainer.innerHTML = "";

            items.forEach((item) => {
                const produk = item.produk || {};
                const ulasan =
                    item.ulasan_data && item.ulasan_data.id
                        ? item.ulasan_data
                        : null;

                const fotoUrl = produk.foto
                    ? `${config.storageUrl}/${produk.foto}`
                    : config.storageUrlNoImg;

                itemsContainer.innerHTML += `
                    <div class="flex items-center border border-gray-200 rounded-lg p-3 bg-white hover:shadow-md transition-all">
                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center mr-4">
                            <img src="${fotoUrl}" class="w-full h-full object-cover">
                        </div>

                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">${
                                produk.nama_produk || "Produk tidak diketahui"
                            }</p>
                            <p class="text-sm text-gray-500 mt-1">Warna: ${
                                item.warna || "-"
                            }</p>
                            <p class="text-sm text-gray-500">Ukuran: ${
                                item.ukuran || "-"
                            }</p>
                            <p class="text-sm text-gray-500">Jumlah: ${
                                item.jumlah || 0
                            }</p>

                            <div class="mt-2">
                                ${
                                    status.toLowerCase() !== "selesai"
                                        ? `<span class="text-gray-400 text-sm">Pesanan belum selesai</span>`
                                        : ulasan
                                        ? `
                                            <button onclick="openUlasanModal(${ulasan.id})"
                                                class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-lg text-xs">
                                                <i class="fa-solid fa-eye"></i> Lihat Ulasan
                                            </button>
                                        `
                                        : `
                                            <button onclick="openUlasanForm(${item.id}, ${item.produk_id}, ${orderId})"
                                                class="inline-flex items-center gap-2 bg-red-900 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs">
                                                <i class="fa-solid fa-pen"></i> Tulis Ulasan
                                            </button>
                                        `
                                }
                            </div>
                        </div>

                        <div class="text-right font-semibold text-gray-800">
                            Rp${Number(item.subtotal || 0).toLocaleString(
                                "id-ID"
                            )}
                        </div>
                    </div>
                `;
            });
        }

        const modal = document.getElementById("orderModal");
        if (modal) {
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        }
    };

    window.closeOrderModal = function () {
        const modal = document.getElementById("orderModal");
        if (modal) {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }
    };

    window.openUlasanForm = function (order_item_id, produk_id, order_id) {
        const ulasanContainer = document.getElementById("ulasanContainer");
        const ulasanForm = document.getElementById("ulasanForm");

        if (ulasanContainer) ulasanContainer.classList.remove("hidden");
        if (ulasanForm) ulasanForm.classList.remove("hidden");

        document.getElementById("ulasanOrderId").value = order_id;
        document.getElementById("ulasanProdukId").value = produk_id;
        document.getElementById("ulasanOrderItemId").value = order_item_id;

        ulasanContainer?.scrollIntoView({ behavior: "smooth" });
    };

    // Review Form Initialization
    function initializeReviewForm() {
        const starButtons = document.querySelectorAll(".star-btn");
        const selectedRating = document.getElementById("selectedRating");
        const ratingText = document.getElementById("ratingText");
        const submitBtn = document.getElementById("submitBtn");
        const textarea = document.querySelector('textarea[name="komentar"]');
        const charCount = document.getElementById("charCount");
        const uploadArea = document.getElementById("uploadArea");
        const fileInput = document.getElementById("fileInput");
        const imagePreviews = document.getElementById("imagePreviews");
        const uploadInfo = document.getElementById("uploadInfo");
        const cancelBtn = document.getElementById("cancelBtn");

        if (!starButtons.length) return;

        // ⭐ STAR RATING
        starButtons.forEach((star) => {
            star.addEventListener("click", function () {
                const rating = parseInt(this.dataset.rating);
                if (selectedRating) selectedRating.value = rating;

                starButtons.forEach((s, index) => {
                    const span = s.querySelector("span");
                    if (span)
                        span.className =
                            index < rating
                                ? "text-yellow-400"
                                : "text-gray-300";
                });

                if (ratingText) {
                    const texts = {
                        1: "Tidak Puas",
                        2: "Kurang Puas",
                        3: "Cukup",
                        4: "Puas",
                        5: "Sangat Puas",
                    };
                    ratingText.textContent = texts[rating];
                }

                validateForm();
            });
        });

        // ✍️ TEXTAREA
        if (textarea && charCount) {
            textarea.addEventListener("input", function () {
                charCount.textContent = this.value.length;
                validateForm();
            });
        }

        // 📂 UPLOAD
        if (uploadArea && fileInput) {
            uploadArea.addEventListener("click", () => fileInput.click());

            uploadArea.addEventListener("dragover", (e) => {
                e.preventDefault();
                uploadArea.classList.add("border-red-400");
            });

            uploadArea.addEventListener("dragleave", () => {
                uploadArea.classList.remove("border-red-400");
            });

            uploadArea.addEventListener("drop", (e) => {
                e.preventDefault();
                uploadArea.classList.remove("border-red-400");

                const dt = new DataTransfer();

                // gabung file lama + baru
                [...fileInput.files, ...e.dataTransfer.files].forEach(
                    (file) => {
                        if (!validateImage(file)) return;

                        // cegah duplikat
                        if (
                            [...dt.files].some(
                                (f) =>
                                    f.name === file.name &&
                                    f.size === file.size &&
                                    f.lastModified === file.lastModified
                            )
                        )
                            return;

                        dt.items.add(file);
                    }
                );

                fileInput.files = dt.files;
                previewImages(fileInput);
            });

            fileInput.addEventListener("change", function (e) {
                const dt = new DataTransfer();

                // ambil file lama
                const oldFiles = Array.from(this._files || []);

                // ambil file baru
                const newFiles = Array.from(e.target.files);

                [...oldFiles, ...newFiles].forEach((file) => {
                    if (!validateImage(file)) return;

                    // cegah duplikat
                    if (
                        [...dt.files].some(
                            (f) =>
                                f.name === file.name &&
                                f.size === file.size &&
                                f.lastModified === file.lastModified
                        )
                    )
                        return;

                    dt.items.add(file);
                });

                // simpan ke custom property
                this._files = Array.from(dt.files);

                // set ke input
                this.files = dt.files;

                previewImages(this);
            });
        }

        // ❌ CANCEL
        if (cancelBtn) {
            cancelBtn.addEventListener("click", function () {
                resetForm();
                document
                    .getElementById("ulasanContainer")
                    .classList.add("hidden");
            });
        }

        function validateForm() {
            if (!selectedRating || !textarea || !submitBtn) return;

            submitBtn.disabled = !(
                selectedRating.value &&
                textarea.value.trim().length >= 10 &&
                textarea.value.length <= 500
            );
        }

        function resetForm() {
            if (selectedRating) selectedRating.value = "";
            if (textarea) textarea.value = "";
            if (charCount) charCount.textContent = "0";

            if (imagePreviews) {
                imagePreviews.innerHTML = "";
                imagePreviews.classList.add("hidden");
            }

            if (uploadInfo) uploadInfo.classList.add("hidden");
            if (fileInput) fileInput.value = "";
        }

        const uploadAreaEdit = document.getElementById("uploadAreaEdit");
        const fileInputEdit = document.getElementById("fileInputEdit");

        if (uploadAreaEdit && fileInputEdit) {
            uploadAreaEdit.addEventListener("click", () =>
                fileInputEdit.click()
            );

            uploadAreaEdit.addEventListener("dragover", (e) => {
                e.preventDefault();
                uploadAreaEdit.classList.add("border-red-400");
            });

            uploadAreaEdit.addEventListener("dragleave", () => {
                uploadAreaEdit.classList.remove("border-red-400");
            });

            uploadAreaEdit.addEventListener("drop", (e) => {
                e.preventDefault();
                uploadAreaEdit.classList.remove("border-red-400");

                const dt = new DataTransfer();

                const oldFiles = Array.from(fileInputEdit._files || []);
                const newFiles = Array.from(e.dataTransfer.files);

                [...oldFiles, ...newFiles].forEach((file) => {
                    if (!validateImage(file)) return;

                    if (
                        [...dt.files].some(
                            (f) =>
                                f.name === file.name &&
                                f.size === file.size &&
                                f.lastModified === file.lastModified
                        )
                    )
                        return;

                    dt.items.add(file);
                });

                fileInputEdit._files = Array.from(dt.files);
                fileInputEdit.files = dt.files;

                previewImagesEdit(fileInputEdit);
            });

            fileInputEdit.addEventListener("change", function (e) {
                const dt = new DataTransfer();

                const oldFiles = Array.from(this._files || []);
                const newFiles = Array.from(e.target.files);

                [...oldFiles, ...newFiles].forEach((file) => {
                    if (!validateImage(file)) return;

                    if (
                        [...dt.files].some(
                            (f) =>
                                f.name === file.name &&
                                f.size === file.size &&
                                f.lastModified === file.lastModified
                        )
                    )
                        return;

                    dt.items.add(file);
                });

                this._files = Array.from(dt.files);
                this.files = dt.files;

                previewImagesEdit(this);
            });
        }

        function previewImagesEdit(input) {
            const previews = document.getElementById("imagePreviewsEdit");
            const uploadInfo = document.getElementById("uploadInfoEdit");

            if (!previews) return;

            previews.innerHTML = "";

            let files = Array.from(input.files);

            // dedup + validasi
            let unique = [];

            files.forEach((file) => {
                if (!validateImage(file)) return;

                if (
                    unique.some(
                        (f) =>
                            f.name === file.name &&
                            f.size === file.size &&
                            f.lastModified === file.lastModified
                    )
                )
                    return;

                unique.push(file);
            });

            // ⭐ BATASI 5
            unique = unique.slice(0, 5);

            const dt = new DataTransfer();
            unique.forEach((f) => dt.items.add(f));
            input.files = dt.files;

            if (unique.length > 0) {
                previews.classList.remove("hidden");
                uploadInfo?.classList.remove("hidden");
            } else {
                previews.classList.add("hidden");
                uploadInfo?.classList.add("hidden");
            }

            unique.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement("div");

                    div.innerHTML = `
                <div class="relative">
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg">
                    <button type="button"
                        class="absolute -top-2 -right-2 bg-red-500 text-white w-6 h-6 rounded-full"
                        onclick="removeImageEdit(${index})">×</button>
                </div>
            `;

                    previews.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        window.removeImageEdit = function (index) {
            const input = document.getElementById("fileInputEdit");
            if (!input) return;

            const files = Array.from(input.files);
            files.splice(index, 1);

            const dt = new DataTransfer();
            files.forEach((f) => dt.items.add(f));

            input.files = dt.files;
            input._files = files;

            previewImagesEdit(input);
        };
    }

    //////////////////////////////////////////////////////
    // 🖼️ PREVIEW IMAGES (FIX TOTAL)
    //////////////////////////////////////////////////////

    window.previewImages = function (input) {
        const previews = document.getElementById("imagePreviews");
        const uploadInfo = document.getElementById("uploadInfo");

        if (!previews) return;

        previews.innerHTML = "";

        let files = Array.from(input.files);

        // validasi + dedup
        let unique = [];

        files.forEach((file) => {
            if (!validateImage(file)) return;

            if (
                unique.some(
                    (f) =>
                        f.name === file.name &&
                        f.size === file.size &&
                        f.lastModified === file.lastModified
                )
            )
                return;

            unique.push(file);
        });

        // max 5
        unique = unique.slice(0, 5);

        // set ulang input
        const dt = new DataTransfer();
        unique.forEach((f) => dt.items.add(f));
        input.files = dt.files;

        if (unique.length > 0) {
            previews.classList.remove("hidden");
            uploadInfo?.classList.remove("hidden");
        } else {
            previews.classList.add("hidden");
            uploadInfo?.classList.add("hidden");
        }

        // render
        unique.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement("div");
                div.className = "relative group";

                div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg">
                <button type="button"
                    class="absolute -top-2 -right-2 bg-red-500 text-white w-6 h-6 rounded-full"
                    onclick="removeImage(${index})">×</button>
            `;

                previews.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    };

    //////////////////////////////////////////////////////
    // ❌ REMOVE IMAGE
    //////////////////////////////////////////////////////

    window.removeImage = function (index) {
        const input = document.getElementById("fileInput");
        if (!input) return;

        const files = Array.from(input.files);
        files.splice(index, 1);

        const dt = new DataTransfer();
        files.forEach((f) => dt.items.add(f));

        input.files = dt.files;

        previewImages(input);
    };

    //////////////////////////////////////////////////////
    // ✅ VALIDATION
    //////////////////////////////////////////////////////

    function validateImage(file) {
        const valid = ["image/jpeg", "image/png", "image/jpg"];
        if (!valid.includes(file.type)) {
            alert("Format harus JPG/PNG");
            return false;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert("Max 5MB");
            return false;
        }

        return true;
    }

    // FIX: Swal selalu di paling depan
    const style = document.createElement("style");
    style.innerHTML = `
    .swal2-container {
        z-index: 10000 !important;
    }
`;
    document.head.appendChild(style);
})();
