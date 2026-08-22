<x-guest-layout>

    <div class="w-full max-w-4xl mx-auto px-4">

        {{-- Header --}}
        <div class="text-center mb-8">

            <div class="flex justify-center mb-4">
                <div
                    class="w-16 h-16 rounded-2xl
                           bg-gradient-to-br from-indigo-500 to-blue-600
                           flex items-center justify-center
                           shadow-lg shadow-indigo-500/30"
                >
                    <span class="text-3xl">💼</span>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                Create Your Account
            </h1>

            <p class="mt-2 text-gray-500 dark:text-gray-400">
                Join AI Job Board and find your next opportunity
            </p>

        </div>


        {{-- Register Card --}}
        <div
            class="w-full
                   bg-white dark:bg-gray-800
                   rounded-3xl
                   border border-gray-100 dark:border-gray-700
                   shadow-xl
                   p-8 sm:p-10"
        >

            <form
                method="POST"
                action="{{ route('register') }}"
                class="space-y-6"
            >

                @csrf


                {{-- Name + Email --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Name --}}
                    <div>

                        <x-input-label
                            for="name"
                            :value="__('Full Name')"
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        />

                        <x-text-input
                            id="name"
                            name="name"
                            type="text"
                            class="block mt-2 w-full h-12 rounded-xl
                                   border-gray-200
                                   dark:border-gray-600
                                   dark:bg-gray-700
                                   dark:text-white
                                   focus:border-indigo-500
                                   focus:ring-indigo-500"
                            :value="old('name')"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Enter your full name"
                        />

                        <x-input-error
                            :messages="$errors->get('name')"
                            class="mt-2"
                        />

                    </div>


                    {{-- Email --}}
                    <div>

                        <x-input-label
                            for="email"
                            :value="__('Email Address')"
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        />

                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            class="block mt-2 w-full h-12 rounded-xl
                                   border-gray-200
                                   dark:border-gray-600
                                   dark:bg-gray-700
                                   dark:text-white
                                   focus:border-indigo-500
                                   focus:ring-indigo-500"
                            :value="old('email')"
                            required
                            autocomplete="username"
                            placeholder="Enter your email address"
                        />

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2"
                        />

                    </div>

                </div>


                {{-- Password + Confirm Password --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Password --}}
                    <div>

                        <x-input-label
                            for="password"
                            :value="__('Password')"
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        />

                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            class="block mt-2 w-full h-12 rounded-xl
                                   border-gray-200
                                   dark:border-gray-600
                                   dark:bg-gray-700
                                   dark:text-white
                                   focus:border-indigo-500
                                   focus:ring-indigo-500"
                            required
                            autocomplete="new-password"
                            placeholder="Create a password"
                        />

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-2"
                        />

                    </div>


                    {{-- Confirm Password --}}
                    <div>

                        <x-input-label
                            for="password_confirmation"
                            :value="__('Confirm Password')"
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        />

                        <x-text-input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="block mt-2 w-full h-12 rounded-xl
                                   border-gray-200
                                   dark:border-gray-600
                                   dark:bg-gray-700
                                   dark:text-white
                                   focus:border-indigo-500
                                   focus:ring-indigo-500"
                            required
                            autocomplete="new-password"
                            placeholder="Confirm your password"
                        />

                        <x-input-error
                            :messages="$errors->get('password_confirmation')"
                            class="mt-2"
                        />

                    </div>

                </div>


                {{-- Button --}}
                <div class="pt-2">

                    <x-primary-button
                        class="w-full h-12
                               justify-center
                               rounded-xl
                               bg-gradient-to-r
                               from-indigo-600 to-blue-600
                               hover:from-indigo-700
                               hover:to-blue-700
                               text-white
                               font-bold
                               text-base
                               shadow-lg shadow-indigo-500/20
                               transition
                               duration-200
                               hover:-translate-y-0.5"
                    >
                        Create Account
                    </x-primary-button>

                </div>


                {{-- Login --}}
                <div class="text-center pt-1">

                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Already have an account?
                    </span>

                    <a
                        href="{{ route('login') }}"
                        class="ml-1 text-sm font-bold
                               text-indigo-600
                               hover:text-indigo-800
                               dark:text-indigo-400
                               dark:hover:text-indigo-300"
                    >
                        Sign In
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-guest-layout>