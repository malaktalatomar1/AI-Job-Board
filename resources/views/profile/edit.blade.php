<x-app-layout>

```
<div class="min-h-screen bg-slate-50">

    {{-- Background decoration --}}
    <div class="relative overflow-hidden">

        <div class="absolute -top-32 -right-32 w-96 h-96 bg-indigo-200/40 rounded-full blur-3xl"></div>

        <div class="absolute top-96 -left-32 w-96 h-96 bg-blue-200/30 rounded-full blur-3xl"></div>

        <div class="relative max-w-5xl mx-auto px-6 py-12">

            {{-- Page Header --}}
            <div class="mb-10">

                <div class="flex items-center gap-3 mb-3">

                    <div
                        class="w-11 h-11 rounded-xl
                               bg-indigo-600 text-white
                               flex items-center justify-center
                               shadow-lg"
                    >
                        👤
                    </div>

                    <span
                        class="text-sm font-semibold
                               text-indigo-600
                               uppercase tracking-wider"
                    >
                        Account Settings
                    </span>

                </div>

                <h1 class="text-4xl font-extrabold text-slate-900">
                    My Profile
                </h1>

                <p class="mt-2 text-slate-500">
                    Manage your account information, password and account settings.
                </p>

            </div>


            {{-- Profile Information --}}
            <div
                class="bg-white rounded-2xl
                       border border-slate-200
                       shadow-sm
                       p-6 md:p-8 mb-6"
            >

                <div class="flex items-center gap-4 mb-6">

                    <div
                        class="w-12 h-12 rounded-xl
                               bg-indigo-50
                               flex items-center justify-center
                               text-2xl"
                    >
                        👤
                    </div>

                    <div>

                        <h2 class="text-xl font-bold text-slate-900">
                            Profile Information
                        </h2>

                        <p class="text-sm text-slate-500">
                            Update your name and email address.
                        </p>

                    </div>

                </div>

                <div class="border-t border-slate-100 pt-6">

                    @include('profile.partials.update-profile-information-form')

                </div>

            </div>


            {{-- Password --}}
            <div
                class="bg-white rounded-2xl
                       border border-slate-200
                       shadow-sm
                       p-6 md:p-8 mb-6"
            >

                <div class="flex items-center gap-4 mb-6">

                    <div
                        class="w-12 h-12 rounded-xl
                               bg-blue-50
                               flex items-center justify-center
                               text-2xl"
                    >
                        🔐
                    </div>

                    <div>

                        <h2 class="text-xl font-bold text-slate-900">
                            Update Password
                        </h2>

                        <p class="text-sm text-slate-500">
                            Make sure your account uses a strong password.
                        </p>

                    </div>

                </div>

                <div class="border-t border-slate-100 pt-6">

                    @include('profile.partials.update-password-form')

                </div>

            </div>


            {{-- Delete Account --}}
            <div
                class="bg-white rounded-2xl
                       border border-red-100
                       shadow-sm
                       p-6 md:p-8"
            >

                <div class="flex items-center gap-4 mb-6">

                    <div
                        class="w-12 h-12 rounded-xl
                               bg-red-50
                               flex items-center justify-center
                               text-2xl"
                    >
                        ⚠️
                    </div>

                    <div>

                        <h2 class="text-xl font-bold text-slate-900">
                            Delete Account
                        </h2>

                        <p class="text-sm text-slate-500">
                            Permanently delete your account and all of its data.
                        </p>

                    </div>

                </div>

                <div class="border-t border-red-100 pt-6">

                    @include('profile.partials.delete-user-form')

                </div>

            </div>

        </div>

    </div>

</div>

{{-- Chatbot --}}
@livewire('chatbot')
```

</x-app-layout>
