<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Background Gradient Elegant -->
    <div class="fixed inset-0 bg-gradient-animated"></div>

    <!-- Main Content -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-6xl">
            <!-- Card Login -->
            <div class="flex bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden mx-auto max-w-sm lg:max-w-4xl">
                <!-- Bagian Kiri: Foto (Desktop Only) dengan Zoom Effect -->
                <div class="hidden lg:block lg:w-1/2 bg-cover bg-center relative overflow-hidden group">
                    <div
                        class="absolute inset-0 w-full h-full object-cover transition-all duration-700 ease-out group-hover:scale-105" // absolute inset-0 bg-cover bg-center transition-all duration-700 ease-out group-hover:scale-105

                        style="background-image:url('{{ asset('images/dpd.png') }}')">
                    </div>
                    <!-- Overlay Gradient Elegant -->
                    <div class="absolute inset-0 bg-gradient-to-t from-[#032247]/70 via-transparent to-transparent"></div>

                    <!-- Logo NasDem di kiri -->
                    <div class="absolute top-6 left-6 z-10">
                        <div class="flex items-center space-x-2">
                            <div class="w-10 h-10 bg-gradient-to-r from-[#032247] to-[#e69d00] rounded-lg flex items-center justify-center shadow-lg">
                                <img src="{{ asset('logo/nsdm.png') }}"
                                    alt="Logo NasDem"
                                    class="w-10 h-10 object-contain">
                            </div>
                            <div class="text-white drop-shadow-lg">
                                <h3 class="font-bold text-lg leading-tight">DPD NasDem</h3>
                                <p class="text-xs opacity-95">Bojonegoro</p>
                            </div>
                        </div>
                    </div>

                    <!-- Teks di bawah -->
                    <div class="absolute bottom-6 left-6 right-6 z-10">
                        <h3 class="text-white text-xl font-bold mb-2 drop-shadow-lg">Dewan Pimpinan Daerah</h3>
                        <p class="text-white/95 text-sm drop-shadow">Sistem Informasi DPD NasDem Bojonegoro</p>
                    </div>
                </div>

                <!-- Bagian Kanan: Form Login -->
                <div class="w-full p-8 lg:w-1/2">
                    <!-- Header Mobile -->
                    <div class="lg:hidden text-center mb-8">
                        <div class="flex justify-center mb-4">
                            <div class="w-16 h-16 bg-gradient-to-r from-[#032247] to-[#e69d00] rounded-full flex items-center justify-center shadow-lg">
                                <img src="{{ asset('logo/nsdm.png') }}"
                                    alt="Logo NasDem"
                                    class="w-10 h-10 object-contain">
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">DPD NasDem</h2>
                        <p class="text-gray-600 mt-1">Bojonegoro</p>
                    </div>

                    <!-- Header Desktop -->
                    <div class="hidden lg:block text-center mb-10">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang</h2>
                        <p class="text-gray-600">Silakan masuk ke akun Anda</p>
                    </div>

                    <!-- Form Login Laravel -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">
                                Email Address
                            </label>
                            <div class="relative">
                                <input
                                    id="email"
                                    class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#032247]/30 focus:border-[#032247] transition-all duration-300 @error('email') border-red-500 ring-1 ring-red-500 @enderror"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="email"
                                    placeholder="email@example.com" />
                                <div class="absolute left-3 top-3.5 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-gray-700 text-sm font-semibold" for="password">
                                    Password
                                </label>
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-[#032247] hover:text-[#e69d00] hover:underline transition duration-300">
                                    Lupa Password?
                                </a>
                                @endif
                            </div>
                            <div class="relative">
                                <input
                                    id="password"
                                    class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#032247]/30 focus:border-[#032247] transition-all duration-300 @error('password') border-red-500 ring-1 ring-red-500 @enderror"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="••••••••" />
                                <div class="absolute left-3 top-3.5 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input
                                id="remember_me"
                                type="checkbox"
                                class="w-4 h-4 text-[#032247] bg-gray-100 border-gray-300 rounded focus:ring-[#032247]/30 focus:ring-2 transition duration-200"
                                name="remember" />
                            <label for="remember_me" class="ml-2 text-sm text-gray-700">
                                Ingat saya
                            </label>
                        </div>

                        <!-- Login Button -->
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-gradient-to-r from-[#032247] to-[#e69d00] hover:from-[#043a7a] hover:to-[#f5b301] text-white font-bold py-3 px-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-[#032247]/30 focus:ring-offset-2">
                                {{ __('Masuk') }}
                                <svg class="w-5 h-5 inline ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </div>

                        <!-- Link Kembali ke Home -->
                        <div class="pt-6 border-t border-gray-200">
                            <p class="text-center text-gray-600 text-sm">
                                <a href="{{ route('home') }}" class="font-semibold text-[#032247] hover:text-[#e69d00] hover:underline transition duration-300">
                                    Kembali Ke Halaman Utama
                                </a>
                            </p>
                        </div>
                    </form>

                    <!-- Copyright -->
                    <div class="mt-8 text-center">
                        <p class="text-gray-500 text-xs">
                            &copy; {{ date('Y') }} DPD NasDem Bojonegoro. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS Elegant -->
    <style>
        /* Elegant Gradient Animation */
        .bg-gradient-animated {
            background: linear-gradient(-45deg,
                    #032247,
                    #043a7a,
                    #032247,
                    #e69d00,
                    #f5b301,
                    #032247);
            background-size: 400% 400%;
            animation: gradient-wave 20s ease infinite;
        }

        @keyframes gradient-wave {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Smooth focus states */
        input:focus,
        button:focus {
            outline: none;
            transition: all 0.3s ease;
        }

        /* Elegant shadow for card */
        .shadow-2xl {
            box-shadow: 0 20px 60px rgba(3, 34, 71, 0.15);
        }

        /* Smooth hover effects */
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(3, 34, 71, 0.2);
        }

        /* Custom input focus glow */
        input:focus {
            box-shadow: 0 0 0 3px rgba(3, 34, 71, 0.1);
        }

        /* Smooth transitions for all elements */
        * {
            transition: background-color 0.3s ease,
                border-color 0.3s ease,
                transform 0.3s ease,
                box-shadow 0.3s ease;
        }

        /* Zoom effect for photo */
        .group:hover .group-hover\:scale-105 {
            transform: scale(1.05);
        }
    </style>
</x-guest-layout>