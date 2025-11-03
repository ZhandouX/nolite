//Login Modal
function openLoginModal() {
    closeRegisterModal();
    const modal = document.getElementById('loginModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeLoginModal() {
    const modal = document.getElementById('loginModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
document.getElementById('loginModal').addEventListener('click', e => {
    if (e.target === e.currentTarget) closeLoginModal();
});

// Register Modal
function openRegisterModal() {
    closeLoginModal();
    const modal = document.getElementById('registerModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeRegisterModal() {
    const modal = document.getElementById('registerModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
document.getElementById('registerModal').addEventListener('click', e => {
    if (e.target === e.currentTarget) closeRegisterModal();
});

// Switch modal
function switchToRegisterModal() {
    closeLoginModal();
    setTimeout(() => openRegisterModal(), 200);
}
function switchToLoginModal() {
    closeRegisterModal();
    setTimeout(() => openLoginModal(), 200);
}

// Password Toggle (Login)
const loginToggle = document.getElementById('loginPasswordToggle');
const loginInput = document.getElementById('loginPassword');
const loginIcon = loginToggle.querySelector('i');
loginToggle.addEventListener('click', () => {
    const isHidden = loginInput.type === 'password';
    loginInput.type = isHidden ? 'text' : 'password';
    loginIcon.classList.toggle('fa-eye');
    loginIcon.classList.toggle('fa-eye-slash');
});

// Password Toggle (Register)
const regToggle = document.getElementById('registerPasswordToggle');
const regInput = document.getElementById('registerPassword');
const regIcon = regToggle.querySelector('i');
regToggle.addEventListener('click', () => {
    const isHidden = regInput.type === 'password';
    regInput.type = isHidden ? 'text' : 'password';
    regIcon.classList.toggle('fa-eye');
    regIcon.classList.toggle('fa-eye-slash');
});

// Password Strength Indicator
const bar = document.getElementById('passwordStrength');
const text = document.getElementById('passwordText');
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

// Loading Button
document.getElementById('loginForm').addEventListener('submit', e => {
    const btn = e.target.querySelector('.submit-btn');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    btn.disabled = true;
});
document.getElementById('registerForm').addEventListener('submit', e => {
    const btn = e.target.querySelector('.submit-btn');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    btn.disabled = true;
});