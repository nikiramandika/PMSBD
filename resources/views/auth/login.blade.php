<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Quick Access Buttons for Demo/Praktikum -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4 mb-6">
        <div class="text-center mb-3">
            <h3 class="text-sm font-semibold text-blue-800">🔓 Akses Cepat Praktikum</h3>
            <p class="text-xs text-blue-600 mt-1">Klik tombol di bawah untuk login otomatis</p>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <!-- Admin Quick Login -->
            <button type="button"
                    onclick="quickLogin('admin@smartsalon.com', 'password')"
                    class="flex flex-col items-center justify-center p-3 bg-white border border-blue-300 rounded-lg hover:bg-blue-50 hover:border-blue-400 transition-all duration-200 group">
                <div class="flex items-center space-x-2 mb-1">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span class="text-xs font-medium text-blue-800">Admin</span>
                </div>
                <div class="text-xs text-gray-500 text-center">
                    <p>admin@smartsalon.com</p>
                    <p>password</p>
                </div>
            </button>

            <!-- Kasir Quick Login -->
            <button type="button"
                    onclick="quickLogin('kasir@smartsalon.com', 'password')"
                    class="flex flex-col items-center justify-center p-3 bg-white border border-green-300 rounded-lg hover:bg-green-50 hover:border-green-400 transition-all duration-200 group">
                <div class="flex items-center space-x-2 mb-1">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-xs font-medium text-green-800">Kasir</span>
                </div>
                <div class="text-xs text-gray-500 text-center">
                    <p>kasir@smartsalon.com</p>
                    <p>password</p>
                </div>
            </button>
        </div>

        <div class="mt-3 text-center">
            <p class="text-xs text-blue-600 font-medium">
                💡 <em>Tombol ini hanya untuk demonstrasi praktikum</em>
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
        @csrf

        <!-- Header -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Selamat Datang Kembali</h2>
            <p class="mt-2 text-sm text-gray-600">Masuk ke akun SmartSalon Anda</p>
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <input id="email"
                       class="appearance-none relative block w-full pl-10 pr-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                       type="email"
                       name="email"
                       placeholder="nama@email.com"
                       :value="old('email')"
                       required
                       autofocus
                       autocomplete="username">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <input id="password"
                       class="appearance-none relative block w-full pl-10 pr-10 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                       type="password"
                       name="password"
                       placeholder="Masukkan password"
                       required
                       autocomplete="current-password">
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
                    <svg id="password-toggle" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input type="checkbox"
                       class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                       name="remember">
                <span class="ml-2 block text-sm text-gray-700">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm text-purple-600 hover:text-purple-500 font-medium transition-colors duration-200">
                    Lupa password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-slate-700 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-slate-200 group-hover:text-slate-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                </span>
                Masuk
            </button>
        </div>

        <!-- Register Link -->
        @if (Route::has('register'))
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}"
                       class="font-medium text-purple-600 hover:text-purple-500 transition-colors duration-200">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        @endif
    </form>

    <script>
        // Quick Login Function for Demo/Praktikum
        function quickLogin(email, password) {
            // Fill in the form fields
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;

            // Add visual feedback
            const buttons = document.querySelectorAll('[onclick^="quickLogin"]');
            buttons.forEach(btn => {
                if (btn.getAttribute('onclick').includes(email)) {
                    btn.classList.add('ring-2', 'ring-offset-2', 'ring-blue-500', 'bg-blue-50');
                    btn.disabled = true;

                    // Show loading state
                    const originalContent = btn.innerHTML;
                    btn.innerHTML = `
                        <div class="flex items-center space-x-2">
                            <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm font-medium text-blue-800">Login...</span>
                        </div>
                    `;

                    // Reset after 2 seconds for demo
                    setTimeout(() => {
                        btn.innerHTML = originalContent;
                        btn.classList.remove('ring-2', 'ring-offset-2', 'ring-blue-500', 'bg-blue-50');
                        btn.disabled = false;
                    }, 2000);
                }
            });

            // Submit the form automatically
            document.getElementById('loginForm').submit();
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(inputId + '-toggle');

            if (input.type === 'password') {
                input.type = 'text';
                toggle.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>`;
            } else {
                input.type = 'password';
                toggle.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;
            }
        }

        // Auto-fill demo credentials on page load for easier testing
        document.addEventListener('DOMContentLoaded', function() {
            // Optional: Auto-fill admin credentials for demo purposes
            // Uncomment the line below if you want auto-fill on page load
            // setTimeout(() => quickLogin('admin@smartsalon.com', 'password'), 1000);
        });
    </script>
</x-guest-layout>
