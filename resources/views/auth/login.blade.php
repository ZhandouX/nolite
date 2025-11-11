<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Elegant Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
  <link rel="stylesheet" href="/assets/css/auth/login.css">
</head>
<body>
  <div class="form-container w-full max-w-md">
    <!-- Header -->
    <div class="form-header">
      <h1 class="text-2xl font-bold mb-2">Login</h1>
    </div>

    <!-- Form Content -->
    <div class="form-content">
      <form id="loginForm" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
          <div class="input-container">
            <input
              id="email"
              type="email"
              name="email"
              required
              placeholder=" "
              class="form-input"
              value="{{ old('email') }}"
              autofocus
            />
            <label for="email" class="floating-label">Email*</label>
          </div>
          @error('email')
            <div class="input-error">{{ $message }}</div>
          @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
          <div class="input-container">
            <input
              id="password"
              type="password"
              name="password"
              required
              placeholder=" "
              class="form-input"
            />
            <label for="password" class="floating-label">Password*</label>
            <button type="button" class="password-toggle" id="passwordToggle">
              <i class="far fa-eye"></i>
            </button>
          </div>
          @error('password')
            <div class="input-error">{{ $message }}</div>
          @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="remember-forgot">
          <div class="remember-me">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember" class="text-sm text-gray-700">Ingat Saya</label>
          </div>
          <a href="{{ route('password.request') }}" class="forgot-password">Lupa Password?</a>
        </div>

        <!-- Login Button -->
        <button type="submit" class="submit-btn">
          Masuk
        </button>

        <!-- Register Link -->
        <div class="register-link">
          <p class="text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium">Daftar Disini</a>
          </p>
        </div>
      </form>
    </div>
  </div>

  <!-- Success Message -->
  <div class="success-message" id="successMessage">
    <i class="fas fa-check-circle"></i>
    <span>Login berhasil!</span>
  </div>

  <script>
    // Password visibility toggle
    const passwordToggle = document.getElementById('passwordToggle');
    const passwordInput = document.getElementById('password');
    const passwordIcon = passwordToggle.querySelector('i');
    
    passwordToggle.addEventListener('click', function() {
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
      }
    });
    
    // Form submission
    const loginForm = document.getElementById('loginForm');
    const successMessage = document.getElementById('successMessage');
    
    loginForm.addEventListener('submit', function(e) {
      // Form akan dikirim secara normal, tidak perlu simulasi
      // Hanya menampilkan loading state
      const submitBtn = loginForm.querySelector('.submit-btn');
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
      submitBtn.disabled = true;
    });
    
    // Add ripple effect to button
    const buttons = document.querySelectorAll('.submit-btn');
    buttons.forEach(button => {
      button.addEventListener('click', function(e) {
        const x = e.clientX - e.target.getBoundingClientRect().left;
        const y = e.clientY - e.target.getBoundingClientRect().top;
        
        const ripple = document.createElement('span');
        ripple.classList.add('ripple');
        ripple.style.left = `${x}px`;
        ripple.style.top = `${y}px`;
        
        this.appendChild(ripple);
        
        setTimeout(() => {
          ripple.remove();
        }, 600);
      });
    });

    // Tampilkan pesan error jika ada
    @if($errors->any())
      document.addEventListener('DOMContentLoaded', function() {
        // Scroll ke atas untuk menampilkan error
        window.scrollTo(0, 0);
      });
    @endif
  </script>
</body>
</html>