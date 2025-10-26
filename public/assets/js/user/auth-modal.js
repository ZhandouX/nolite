document.addEventListener('DOMContentLoaded', () => {
    // ========== LOGIN MODAL ==========
    const loginModal = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');

    function openLoginModal() {
        closeRegisterModal();
        if (loginModal) {
            loginModal.classList.remove('hidden');
            loginModal.classList.add('flex');
        }
    }
    function closeLoginModal() {
        if (loginModal) {
            loginModal.classList.add('hidden');
            loginModal.classList.remove('flex');
        }
    }

    if (loginModal) {
        loginModal.addEventListener('click', e => {
            if (e.target === e.currentTarget) closeLoginModal();
        });
    }

    // ========== REGISTER MODAL ==========
    function openRegisterModal() {
        closeLoginModal();
        if (registerModal) {
            registerModal.classList.remove('hidden');
            registerModal.classList.add('flex');
        }
    }
    function closeRegisterModal() {
        if (registerModal) {
            registerModal.classList.add('hidden');
            registerModal.classList.remove('flex');
        }
    }

    if (registerModal) {
        registerModal.addEventListener('click', e => {
            if (e.target === e.currentTarget) closeRegisterModal();
        });
    }

    // ========== SWITCH MODAL ==========
    window.switchToRegisterModal = function () {
        closeLoginModal();
        setTimeout(() => openRegisterModal(), 200);
    };
    window.switchToLoginModal = function () {
        closeRegisterModal();
        setTimeout(() => openLoginModal(), 200);
    };

    // ========== PASSWORD TOGGLE LOGIN ==========
    const loginToggle = document.getElementById('loginPasswordToggle');
    const loginInput = document.getElementById('loginPassword');
    if (loginToggle && loginInput) {
        const loginIcon = loginToggle.querySelector('i');
        loginToggle.addEventListener('click', () => {
            const isHidden = loginInput.type === 'password';
            loginInput.type = isHidden ? 'text' : 'password';
            loginIcon.classList.toggle('fa-eye');
            loginIcon.classList.toggle('fa-eye-slash');
        });
    }

    // ========== PASSWORD TOGGLE REGISTER ==========
    const regToggle = document.getElementById('registerPasswordToggle');
    const regInput = document.getElementById('registerPassword');
    if (regToggle && regInput) {
        const regIcon = regToggle.querySelector('i');
        regToggle.addEventListener('click', () => {
            const isHidden = regInput.type === 'password';
            regInput.type = isHidden ? 'text' : 'password';
            regIcon.classList.toggle('fa-eye');
            regIcon.classList.toggle('fa-eye-slash');
        });
    }

    // ========== PASSWORD STRENGTH METER ==========
    const bar = document.getElementById('passwordStrength');
    const text = document.getElementById('passwordText');
    if (regInput && bar && text) {
        regInput.addEventListener('input', () => {
            const val = regInput.value;
            let strength = 0;
            if (val.length >= 8) strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;
            const colors = ['#e53e3e', '#ed8936', '#38a169', '#1a1a1a'];
            const texts = ['Lemah', 'Cukup', 'Baik', 'Sangat Kuat'];
            bar.style.width = strength * 25 + '%';
            bar.style.backgroundColor = colors[strength - 1] || '#333';
            text.textContent = texts[strength - 1] || 'Status Password';
            text.style.color = colors[strength - 1] || '#333';
        });
    }

    // ========== FORM LOADING STATE ==========
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', e => {
            const btn = e.target.querySelector('.submit-btn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            btn.disabled = true;
        });
    }

    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', e => {
            const btn = e.target.querySelector('.submit-btn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            btn.disabled = true;
        });
    }
});
