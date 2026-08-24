<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jobs | AI Job Board</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-gray-800">

    <x-navbar />

    <main class="max-w-7xl mx-auto px-6 py-10">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">

            <div>
                <div class="flex items-center gap-3 mb-3">

                    <div class="w-11 h-11 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg">
                        💼
                    </div>

                    <span class="text-sm font-semibold text-indigo-600 uppercase tracking-wider">
                        AI Job Board
                    </span>

                </div>

                <h1 class="text-4xl font-extrabold text-slate-900">
                    Find Your Dream Job
                </h1>

                <p class="mt-2 text-slate-500">
                    Explore the latest job opportunities and find the perfect career for you.
                </p>
            </div>

        </div>


        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-xl px-5 py-4">
                ✓ {{ session('success') }}
            </div>
        @endif


        {{-- Error Message --}}
        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4">
                ! {{ session('error') }}
            </div>
        @endif


        {{-- Jobs --}}
        @if ($jobs->count())

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($jobs as $job)

                    <div class="group bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 overflow-hidden">

                        {{-- Card Top --}}
                        <div class="h-2 bg-gradient-to-r from-indigo-500 via-blue-500 to-cyan-400"></div>

                        <div class="p-6">

                            {{-- Icon + Category --}}
                            <div class="flex items-center justify-between mb-5">

                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 text-white flex items-center justify-center text-2xl shadow-md">
                                    💼
                                </div>

                                @if ($job->category)
                                    <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold">
                                        {{ $job->category->name }}
                                    </span>
                                @endif

                            </div>


                            {{-- Title --}}
                            <h2 class="text-xl font-bold text-slate-900 group-hover:text-indigo-600 transition">

                                {{ $job->title }}

                            </h2>


                            {{-- Description --}}
                            <p class="text-gray-500 text-sm mt-3 line-clamp-3">

                                {{ $job->description }}

                            </p>


                            {{-- Job Info --}}
                            <div class="space-y-3 mt-5">

                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <span>📍</span>
                                    <span>{{ $job->location }}</span>
                                </div>

                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <span>🏢</span>
                                    <span>{{ $job->work_type }}</span>
                                </div>

                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <span>💰</span>
                                    <span>{{ $job->salary }}</span>
                                </div>

                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <span>📅</span>
                                    <span>
                                        Deadline:
                                        {{ $job->application_deadline }}
                                    </span>
                                </div>

                            </div>


                            {{-- Button --}}
                            <div class="mt-6">

                                <a
                                    href="{{ route('jobs.show', $job->id) }}"
                                    class="w-full inline-flex items-center justify-center gap-2
                                           bg-indigo-600 hover:bg-indigo-700
                                           text-white font-semibold
                                           py-3 rounded-xl
                                           transition duration-200
                                           hover:-translate-y-0.5"
                                >

                                    View Job

                                    <span>→</span>

                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            {{-- Empty State --}}
            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-12 text-center">

                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-indigo-50 flex items-center justify-center text-4xl">
                    🔎
                </div>

                <h2 class="text-2xl font-bold text-slate-900 mb-2">
                    No Jobs Available
                </h2>

                <p class="text-gray-500">
                    There are currently no job opportunities available.
                    Please check again later.
                </p>

            </div>

        @endif

    </main>


    {{-- AI Chatbot --}}
    @livewire('chatbot')

</body>

</html>