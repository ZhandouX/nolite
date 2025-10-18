<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - Elegant Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/auth/register.css') }}">
</head>
<body>
  <div class="form-container w-full max-w-md">
    <!-- Header -->
    <div class="form-header">
      <h1 class="text-2xl font-bold mb-2">Register</h1>
    </div>

    <!-- Form Content -->
    <div class="form-content">
      <form id="registerForm" method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
          <div class="input-container">
            <input
              id="name"
              type="text"
              name="name"
              required
              placeholder=" "
              class="form-input"
              value="{{ old('name') }}"
              autofocus
            />
            <label for="name" class="floating-label">Nama Lengkap*</label>
          </div>
          @error('name')
            <div class="input-error">{{ $message }}</div>
          @enderror
        </div>

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
          <div class="progress-bar">
            <div class="progress-fill" id="passwordStrength"></div>
          </div>
          <div class="password-strength" id="passwordText">Status Password</div>
          @error('password')
            <div class="input-error">{{ $message }}</div>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
          <div class="input-container">
            <input
              id="password_confirmation"
              type="password"
              name="password_confirmation"
              required
              placeholder=" "
              class="form-input"
            />
            <label for="password_confirmation" class="floating-label">Konfirmasi Password*</label>
          </div>
          @error('password_confirmation')
            <div class="input-error">{{ $message }}</div>
          @enderror
        </div>

        <!-- Create Account Button -->
        <button type="submit" class="submit-btn">
          Buat Akun Baru
        </button>

        <!-- Login Link -->
        <div class="login-link">
          <p class="text-sm text-gray-600">
           Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium">Login Disini</a>
          </p>
        </div>
      </form>
    </div>
  </div>

  <!-- Success Message -->
  <div class="success-message" id="successMessage">
    <i class="fas fa-check-circle"></i>
    <span>Account created successfully!</span>
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
    
    // Password strength indicator
    const passwordStrength = document.getElementById('passwordStrength');
    const passwordText = document.getElementById('passwordText');
    
    passwordInput.addEventListener('input', function() {
      const password = passwordInput.value;
      let strength = 0;
      let text = 'Status Password';
      let width = 0;
      let color = '#333';
      
      if (password.length > 0) {
        if (password.length >= 8) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        
        switch(strength) {
          case 1:
            width = 25;
            text = 'Lemah';
            color = '#e53e3e';
            break;
          case 2:
            width = 50;
            text = 'Cukup';
            color = '#ed8936';
            break;
          case 3:
            width = 75;
            text = 'Baik';
            color = '#38a169';
            break;
          case 4:
            width = 100;
            text = 'Sangat Kuat';
            color = '#1a1a1a';
            break;
          default:
            width = 0;
            text = 'Status Password';
        }
      }
      
      passwordStrength.style.width = `${width}%`;
      passwordStrength.style.backgroundColor = color;
      passwordText.textContent = text;
      passwordText.style.color = color;
    });
    
    // Form submission
    const registerForm = document.getElementById('registerForm');
    const successMessage = document.getElementById('successMessage');
    
    registerForm.addEventListener('submit', function(e) {
      // Form akan dikirim secara normal, tidak perlu simulasi
      // Hanya menampilkan loading state
      const submitBtn = registerForm.querySelector('.submit-btn');
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
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
  </script>
</body>
</html>