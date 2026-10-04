<x-guest-layout>
    <div class="glass-card">
        <!-- Brand & Header -->
        <div class="header-section">
            <div class="emblem-wrapper">
                <div class="emblem-box">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
            
            <div class="portal-badge">
                <span class="pulse-dot"></span>
                <span>Admin Secure Portal</span>
            </div>

            <h2 class="title">Welcome Back</h2>
            <p class="subtitle">Enter your institutional credentials to access your administrative dashboard.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert-status">
                <i class="fas fa-circle-check"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert-error">
                <div class="alert-error-header">
                    <i class="fas fa-circle-exclamation"></i>
                    <span>Authentication Failed</span>
                </div>
                <ul class="alert-error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ isset($guard) ? url($guard.'/login') : route('login') }}" class="login-form">
            @csrf
                
            <!-- Email Field -->
            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input 
                        id="email" 
                        class="form-input" 
                        type="email" 
                        name="email" 
                        value="{{ old('email', 'admin@gmail.com') }}" 
                        required 
                        autofocus 
                        autocomplete="email"
                        placeholder="admin@school.com" 
                    />
                </div>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <div class="form-label-row">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                </div>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input 
                        id="password" 
                        class="form-input" 
                        type="password" 
                        name="password" 
                        value="password"
                        required 
                        autocomplete="current-password" 
                        placeholder="••••••••••••" 
                    />
                    <button type="button" class="password-toggle" id="togglePasswordBtn" title="Show/Hide Password">
                        <i class="far fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="options-row">
                <label for="remember_me" class="remember-label">
                    <input id="remember_me" type="checkbox" name="remember" class="custom-checkbox" checked />
                    <span>{{ __('Remember this device') }}</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="submit-wrapper">
                <button type="submit" class="submit-btn" id="submitBtn">
                    <span>{{ __('Sign In to Portal') }}</span>
                    <i class="fas fa-arrow-right-long arrow-icon"></i>
                </button>
            </div>
        </form>

        <!-- Quick Credentials Helper -->
        <div class="quick-credentials">
            <div class="quick-creds-box" onclick="fillAdminCredentials()">
                <div class="quick-creds-icon">
                    <i class="fas fa-key"></i>
                </div>
                <div class="quick-creds-text">
                    <span class="quick-creds-title">Default Admin Credentials</span>
                    <span class="quick-creds-values">admin@gmail.com &bull; password</span>
                </div>
                <span class="quick-creds-action">Click to fill</span>
            </div>
        </div>
    </div>

    <style>
        .header-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 28px;
        }

        .emblem-wrapper {
            margin-bottom: 14px;
            position: relative;
        }

        .emblem-box {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 26px;
            box-shadow: 
                0 12px 24px -6px rgba(79, 70, 229, 0.45),
                inset 0 1px 1px rgba(255, 255, 255, 0.4);
            transform: rotate(-3deg);
            transition: transform 0.3s ease;
        }

        .emblem-wrapper:hover .emblem-box {
            transform: rotate(0deg) scale(1.05);
        }

        .portal-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 4px 12px;
            background: rgba(79, 70, 229, 0.08);
            border: 1px solid rgba(79, 70, 229, 0.15);
            border-radius: 999px;
            color: #4338ca;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 12px;
        }

        .pulse-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #10b981;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.6);
            animation: pulseEmerald 2s infinite;
        }

        @keyframes pulseEmerald {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .title {
            font-family: 'Outfit', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.5px;
            line-height: 1.2;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 13.5px;
            color: #64748b;
            line-height: 1.5;
            max-width: 340px;
        }

        /* Alerts */
        .alert-status {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .alert-error-header {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .alert-error-list {
            margin-left: 24px;
            list-style-type: disc;
        }

        /* Form */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-label {
            font-size: 12px;
            font-weight: 700;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 7px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: #94a3b8;
            font-size: 15px;
            pointer-events: none;
            transition: color 0.25s ease;
        }

        .form-input {
            width: 100%;
            height: 48px;
            padding: 10px 42px 10px 44px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            font-size: 14.5px;
            color: #0f172a;
            font-family: inherit;
            outline: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        .form-input:hover {
            border-color: #cbd5e1;
            background: #ffffff;
        }

        .form-input:focus {
            border-color: #4f46e5;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        }

        .form-input:focus ~ .input-icon {
            color: #4f46e5;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 6px;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: #475569;
        }

        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: -4px;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            cursor: pointer;
            user-select: none;
            font-size: 13.5px;
            color: #475569;
            font-weight: 500;
        }

        .custom-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border: 1.5px solid #cbd5e1;
            border-radius: 6px;
            background: #f8fafc;
            cursor: pointer;
            position: relative;
            outline: none;
            transition: all 0.2s ease;
        }

        .custom-checkbox:hover {
            border-color: #94a3b8;
        }

        .custom-checkbox:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .custom-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 2px;
            width: 5px;
            height: 9px;
            border: solid #ffffff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        /* Submit Button */
        .submit-wrapper {
            margin-top: 4px;
        }

        .submit-btn {
            width: 100%;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 50%, #2563eb 100%);
            color: #ffffff;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.3px;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            box-shadow: 
                0 10px 24px -5px rgba(79, 70, 229, 0.45),
                inset 0 1px 1px rgba(255, 255, 255, 0.3);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 16px 30px -6px rgba(79, 70, 229, 0.55),
                inset 0 1px 1px rgba(255, 255, 255, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
            box-shadow: 0 6px 16px -4px rgba(79, 70, 229, 0.4);
        }

        .arrow-icon {
            font-size: 14px;
            transition: transform 0.25s ease;
        }

        .submit-btn:hover .arrow-icon {
            transform: translateX(4px);
        }

        /* Quick Credentials Box */
        .quick-credentials {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px dashed #e2e8f0;
        }

        .quick-creds-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quick-creds-box:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }

        .quick-creds-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .quick-creds-text {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            text-align: left;
        }

        .quick-creds-title {
            font-size: 12px;
            font-weight: 700;
            color: #334155;
        }

        .quick-creds-values {
            font-size: 11.5px;
            color: #64748b;
            font-family: monospace;
        }

        .quick-creds-action {
            font-size: 11px;
            font-weight: 600;
            color: #4f46e5;
            background: #ffffff;
            border: 1px solid rgba(79, 70, 229, 0.2);
            padding: 3px 8px;
            border-radius: 6px;
            white-space: nowrap;
        }
    </style>

    <script>
        // Password visibility toggle
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passwordInput && toggleIcon) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                toggleIcon.className = isPassword ? 'far fa-eye-slash' : 'far fa-eye';
            });
        }

        // Quick fill admin credentials
        function fillAdminCredentials() {
            const emailInput = document.getElementById('email');
            const passInput = document.getElementById('password');
            if (emailInput && passInput) {
                emailInput.value = 'admin@gmail.com';
                passInput.value = 'password';

                // Subtle animation feedback
                emailInput.style.backgroundColor = '#eef2ff';
                passInput.style.backgroundColor = '#eef2ff';
                setTimeout(() => {
                    emailInput.style.backgroundColor = '';
                    passInput.style.backgroundColor = '';
                }, 500);
            }
        }
    </script>
</x-guest-layout>