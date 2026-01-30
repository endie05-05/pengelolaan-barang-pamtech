<x-guest-layout>
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-slate-900 mb-2">Masuk</h2>
        <p class="text-slate-500 text-sm">Masukkan kredensial Anda untuk mengakses sistem inventaris.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1">
            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
            <input id="email" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow sm:text-sm" 
                type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@pamtechno.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
            <input id="password" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow sm:text-sm" 
                type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-green-600 shadow-sm focus:ring-green-500 group-hover:border-green-400 transition-colors" name="remember">
                <span class="ml-2 text-sm text-slate-600 group-hover:text-slate-800 transition-colors">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full flex items-center justify-center px-6 py-3.5 bg-green-800 text-white text-sm font-semibold rounded-xl hover:bg-green-900 focus:outline-none focus:ring-4 focus:ring-green-200 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
            Masuk ke Sistem
            <svg class="ml-2 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
    </form>


</x-guest-layout>
