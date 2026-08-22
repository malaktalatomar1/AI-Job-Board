<x-guest-layout>

    <div class="w-full max-w-xl mx-auto">

        {{-- Title --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                Welcome Back 👋
            </h1>

            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Login to your AI Job Board account
            </p>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status
            class="mb-5"
            :status="session('status')"
        />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <x-input-label
                    for="email"
                    :value="__('Email Address')"
                    class="text-gray-700 dark:text-gray-200 font-medium"
                />

                <x-text-input
                    id="email"
                    class="block mt-2 w-full h-12 px-4 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Enter your email"
                />

                <x-input-error
                    :messages="$errors->get('email')"
                    class="mt-2"
                />
            </div>

            {{-- Password --}}
            <div>
                <x-input-label
                    for="password"
                    :value="__('Password')"
                    class="text-gray-700 dark:text-gray-200 font-medium"
                />

                <x-text-input
                    id="password"
                    class="block mt-2 w-full h-12 px-4 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                />

                <x-input-error
                    :messages="$errors->get('password')"
                    class="mt-2"
                />
            </div>

            {{-- Remember + Forgot --}}
            <div class="flex items-center justify-between">

                <label
                    for="remember_me"
                    class="inline-flex items-center cursor-pointer"
                >
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    >

                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                        Remember me
                    </span>
                </label>

                @if (Route::has('password.request'))

                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 font-medium hover:underline"
                    >
                        Forgot password?
                    </a>

                @endif

            </div>

            {{-- Login Button --}}
            <button
                type="submit"
                class="w-full h-12 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-base shadow-lg transition duration-200 hover:shadow-indigo-200"
            >
                Log In
            </button>

        </form>

        {{-- Register --}}
        <div class="text-center mt-7">

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Don't have an account?

                <a
                    href="{{ route('register') }}"
                    class="font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 hover:underline"
                >
                    Create Account
                </a>
            </p>

        </div>

    </div>

</x-guest-layout>