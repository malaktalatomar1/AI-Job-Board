<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post"
      action="{{ route('profile.update') }}"
      enctype="multipart/form-data"
      class="mt-6 space-y-6">

        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />

            <x-text-input
            required 
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input
            required 
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />

            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button
                            form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        >
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Age --}}
        <div>
            <x-input-label for="age" :value="__('Age')" />

            <x-text-input
            required
                id="age"
                name="age"
                type="number"
                class="mt-1 block w-full"
                :value="old('age', $user->age)"
                min="13"
                max="100"
            />

            <x-input-error class="mt-2" :messages="$errors->get('age')" />
        </div>

        {{-- Job Title --}}
        <div>
            <x-input-label for="job_title" :value="__('Job Title')" />

            <x-text-input
            required
                id="job_title"
                name="job_title"
                type="text"
                class="mt-1 block w-full"
                :value="old('job_title', $user->job_title)"
                placeholder="e.g. Frontend Developer"
            />

            <x-input-error class="mt-2" :messages="$errors->get('job_title')" />
        </div>

        {{-- Phone --}}
        <div>
            <x-input-label for="phone" :value="__('Phone')" />

            <x-text-input
            required
                id="phone"
                name="phone"
                type="text"
                class="mt-1 block w-full"
                :value="old('phone', $user->phone)"
            />

            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- Skills --}}
        <div>
            <x-input-label for="skills" :value="__('Skills')" />

            <textarea
            
                required
                id="skills"
                name="skills"
                rows="3"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                placeholder="PHP, Laravel, MySQL, JavaScript..."
            >{{ old('skills', $user->skills) }}</textarea>

            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
        </div>

        {{-- Profile Description --}}
        <div>
            <x-input-label
                for="profile_description"
                :value="__('Profile Description')"
            />

            <textarea
                id="profile_description"
                name="profile_description"
                rows="5"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                placeholder="Tell us about yourself..."
            >{{ old('profile_description', $user->profile_description) }}</textarea>

            <x-input-error
                class="mt-2"
                :messages="$errors->get('profile_description')"
            />
        </div>

        {{-- Profile Image --}}
<div>
    <x-input-label for="profile_image" :value="__('Profile Image')" />

    <input
        id="profile_image"
        name="profile_image"
        type="file"
        accept=".jpg,.jpeg,.png,.webp"
        class="mt-1 block w-full"
    />

    @if ($user->profile_image)
        <img
            src="{{ asset('storage/' . $user->profile_image) }}"
            alt="Profile Image"
            class="mt-3 w-24 h-24 rounded-full object-cover"
        >
    @endif

    <x-input-error
        class="mt-2"
        :messages="$errors->get('profile_image')"
    />
</div>

{{-- Resume --}}
<div>
    <x-input-label for="resume" :value="__('Resume / CV')" />

    <input
        id="resume"
        name="resume"
        type="file"
        accept=".pdf,.doc,.docx"
        class="mt-1 block w-full"
    />

    @if ($user->resume)
        <a
            href="{{ asset('storage/' . $user->resume) }}"
            target="_blank"
            class="mt-3 inline-block text-indigo-600 hover:underline"
        >
            View Current Resume
        </a>
    @endif

    <x-input-error
        class="mt-2"
        :messages="$errors->get('resume')"
    />
</div>

        {{-- Save --}}
        <div class="flex items-center gap-4">
            <x-primary-button>
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>

    </form>
</section>