<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $job->title }} | AI Job Board</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-gray-800">

    <x-navbar />


    <main class="max-w-7xl mx-auto px-6 py-10">

        {{-- Back --}}
        <a
            href="{{ route('jobs.index') }}"
            class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-800 transition mb-6"
        >
            <span class="text-xl">←</span>
            Back to Jobs
        </a>


        {{-- Alerts --}}
        @if (session('success'))

            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-xl px-5 py-4">
                ✓ {{ session('success') }}
            </div>

        @endif


        @if (session('error'))

            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4">
                ! {{ session('error') }}
            </div>

        @endif


        {{-- Job Header --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-700 via-indigo-600 to-blue-600 text-white shadow-xl mb-8">

            <div class="absolute -top-24 -right-24 w-72 h-72 bg-white/10 rounded-full"></div>

            <div class="absolute -bottom-32 -left-20 w-80 h-80 bg-white/5 rounded-full"></div>


            <div class="relative px-6 sm:px-10 py-10">

                {{-- Category --}}
                @if ($job->category)

                    <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-semibold mb-5">

                        💼

                        {{ $job->category->name }}

                    </div>

                @endif


                {{-- Title --}}
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-tight">

                    {{ $job->title }}

                </h1>


                <p class="mt-4 text-indigo-100 text-lg">

                    Explore this opportunity and take the next step
                    in your career.

                </p>

            </div>

        </div>


        {{-- Main Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">


            {{-- LEFT --}}
            <div class="lg:col-span-2 space-y-8">


                {{-- Job Information --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">

                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        Job Information
                    </h2>


                    <div class="grid sm:grid-cols-2 gap-4">


                        {{-- Category --}}
                        <div class="bg-slate-50 rounded-2xl p-5 border border-gray-100">

                            <div class="text-2xl mb-2">
                                💼
                            </div>

                            <p class="text-sm text-gray-400">
                                Category
                            </p>

                            <p class="font-semibold text-gray-800 mt-1">

                                {{ $job->category?->name ?? 'Not specified' }}

                            </p>

                        </div>


                        {{-- Location --}}
                        <div class="bg-slate-50 rounded-2xl p-5 border border-gray-100">

                            <div class="text-2xl mb-2">
                                📍
                            </div>

                            <p class="text-sm text-gray-400">
                                Location
                            </p>

                            <p class="font-semibold text-gray-800 mt-1">
                                {{ $job->location }}
                            </p>

                        </div>


                        {{-- Work Type --}}
                        <div class="bg-slate-50 rounded-2xl p-5 border border-gray-100">

                            <div class="text-2xl mb-2">
                                🏢
                            </div>

                            <p class="text-sm text-gray-400">
                                Work Type
                            </p>

                            <p class="font-semibold text-gray-800 mt-1">
                                {{ $job->work_type }}
                            </p>

                        </div>


                        {{-- Salary --}}
                        <div class="bg-slate-50 rounded-2xl p-5 border border-gray-100">

                            <div class="text-2xl mb-2">
                                💰
                            </div>

                            <p class="text-sm text-gray-400">
                                Salary
                            </p>

                            <p class="font-semibold text-gray-800 mt-1">
                                {{ $job->salary }}
                            </p>

                        </div>


                        {{-- Deadline --}}
                        <div class="sm:col-span-2 bg-slate-50 rounded-2xl p-5 border border-gray-100">

                            <div class="text-2xl mb-2">
                                📅
                            </div>

                            <p class="text-sm text-gray-400">
                                Application Deadline
                            </p>

                            <p class="font-semibold text-gray-800 mt-1">
                                {{ $job->application_deadline }}
                            </p>

                        </div>


                    </div>

                </div>


                {{-- Description --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">

                    <div class="flex items-center gap-3 mb-5">

                        <div class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl">
                            📄
                        </div>

                        <h2 class="text-2xl font-bold text-gray-900">
                            Job Description
                        </h2>

                    </div>


                    <p class="text-gray-600 leading-8 whitespace-pre-line">

                        {{ $job->description }}

                    </p>

                </div>


                {{-- Skills --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">

                    <div class="flex items-center gap-3 mb-5">

                        <div class="w-11 h-11 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl">
                            🛠️
                        </div>

                        <h2 class="text-2xl font-bold text-gray-900">
                            Required Skills
                        </h2>

                    </div>


                    <div class="bg-purple-50 border border-purple-100 rounded-2xl p-5">

                        <p class="text-gray-700 leading-8 whitespace-pre-line">

                            {{ $job->required_skills }}

                        </p>

                    </div>

                </div>


            </div>


            {{-- RIGHT --}}
            <div>

                <div class="sticky top-6 bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden">


                    {{-- Apply Header --}}
                    <div class="bg-gradient-to-br from-indigo-600 to-blue-600 text-white p-7 text-center">

                        <div class="w-16 h-16 mx-auto rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center text-3xl mb-4">
                            🚀
                        </div>

                        <h2 class="text-2xl font-bold">
                            Ready to Apply?
                        </h2>

                        <p class="text-indigo-100 text-sm mt-2">
                            Take the next step toward your dream job.
                        </p>

                    </div>


                    {{-- Apply Body --}}
                    <div class="p-6">

                        @auth

                            <form
                                action="{{ route('jobs.apply', $job->id) }}"
                                method="POST"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    onclick="return confirm('Are you sure you want to apply for this job?')"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-200 transition hover:-translate-y-0.5"
                                >

                                    Apply Now 🚀

                                </button>

                            </form>

                        @else

                            <a
                                href="{{ route('login') }}"
                                class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition"
                            >

                                Login to Apply

                            </a>

                        @endauth


                        <div class="flex items-center justify-center gap-2 text-gray-400 text-xs mt-5">

                            🔒

                            <span>
                                Your application is secure.
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>


    {{-- AI Chatbot --}}
    @livewire('chatbot')

</body>

</html>