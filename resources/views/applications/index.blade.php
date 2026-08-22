<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Applications - AI Job Board</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50">

    {{-- Navbar --}}
    <x-navbar />

    {{-- Background --}}
    <div class="relative overflow-hidden">

        {{-- Decorative background --}}
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-indigo-200/40 rounded-full blur-3xl"></div>
        <div class="absolute top-96 -left-32 w-96 h-96 bg-blue-200/30 rounded-full blur-3xl"></div>

        <div class="relative max-w-6xl mx-auto px-6 py-12">

            {{-- Page Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">

                <div>
                    <div class="flex items-center gap-3 mb-3">

                        <div
                            class="w-11 h-11 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg">
                            📄
                        </div>

                        <span class="text-sm font-semibold text-indigo-600 uppercase tracking-wider">
                            Application Center
                        </span>

                    </div>

                    <h1 class="text-4xl font-extrabold text-slate-900">
                        My Applications
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Track and manage all your job applications.
                    </p>
                </div>

                <a
                    href="{{ route('jobs.index') }}"
                    class="inline-flex items-center justify-center gap-2
                           bg-indigo-600 hover:bg-indigo-700
                           text-white font-semibold
                           px-6 py-3 rounded-xl
                           shadow-lg shadow-indigo-200
                           transition duration-200 hover:-translate-y-0.5"
                >
                    <span>🔎</span>
                    Browse Jobs
                </a>

            </div>


            {{-- Applications --}}
            @if ($applications->count())

                <div class="space-y-5">

                    @foreach ($applications as $application)

                        <div
                            class="group bg-white rounded-2xl
                                   border border-slate-200
                                   shadow-sm hover:shadow-xl
                                   transition duration-300
                                   overflow-hidden"
                        >

                            <div class="p-6 md:p-7">

                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                                    {{-- Job Information --}}
                                    <div class="flex gap-5">

                                        {{-- Job Icon --}}
                                        <div
                                            class="hidden sm:flex flex-shrink-0
                                                   w-14 h-14
                                                   rounded-2xl
                                                   bg-gradient-to-br from-indigo-500 to-blue-600
                                                   text-white
                                                   items-center justify-center
                                                   text-2xl
                                                   shadow-md"
                                        >
                                            💼
                                        </div>

                                        <div>

                                            <h2
                                                class="text-2xl font-bold text-slate-900
                                                       group-hover:text-indigo-600
                                                       transition"
                                            >
                                                {{ $application->job->title }}
                                            </h2>

                                            <div class="flex flex-wrap gap-x-5 gap-y-2 mt-3">

                                                <p class="text-slate-500 text-sm">
                                                    <span class="font-semibold text-slate-700">
                                                        Category:
                                                    </span>
                                                    {{ $application->job->category->name }}
                                                </p>

                                                <p class="text-slate-500 text-sm">
                                                    <span class="font-semibold text-slate-700">
                                                        Location:
                                                    </span>
                                                    📍 {{ $application->job->location }}
                                                </p>

                                            </div>

                                            <p class="text-slate-400 text-sm mt-3">
                                                Applied on
                                                <span class="font-medium text-slate-600">
                                                    {{ $application->created_at->format('M d, Y') }}
                                                </span>
                                            </p>

                                        </div>

                                    </div>


                                    {{-- Status --}}
                                    <div class="flex flex-col items-start md:items-end gap-3">

                                        @if ($application->status === 'Pending')

                                            <span
                                                class="inline-flex items-center gap-2
                                                       bg-amber-50
                                                       text-amber-700
                                                       border border-amber-200
                                                       px-4 py-2
                                                       rounded-full
                                                       text-sm font-semibold"
                                            >
                                                <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                                                Pending
                                            </span>

                                        @elseif ($application->status === 'Accepted')

                                            <span
                                                class="inline-flex items-center gap-2
                                                       bg-emerald-50
                                                       text-emerald-700
                                                       border border-emerald-200
                                                       px-4 py-2
                                                       rounded-full
                                                       text-sm font-semibold"
                                            >
                                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                                Accepted
                                            </span>

                                        @elseif ($application->status === 'Canceled')

                                            <span
                                                class="inline-flex items-center gap-2
                                                       bg-slate-100
                                                       text-slate-600
                                                       border border-slate-200
                                                       px-4 py-2
                                                       rounded-full
                                                       text-sm font-semibold"
                                            >
                                                <span class="w-2 h-2 bg-slate-400 rounded-full"></span>
                                                Canceled
                                            </span>

                                        @else

                                            <span
                                                class="inline-flex items-center gap-2
                                                       bg-red-50
                                                       text-red-700
                                                       border border-red-200
                                                       px-4 py-2
                                                       rounded-full
                                                       text-sm font-semibold"
                                            >
                                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                                Rejected
                                            </span>

                                        @endif


                                        {{-- Cancel Button --}}
                                        @if ($application->status === 'Pending')

                                            <form
                                                action="{{ route('applications.cancel', $application->id) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    onclick="return confirm('Are you sure you want to cancel this application?')"
                                                    class="inline-flex items-center gap-2
                                                           text-red-600 hover:text-red-700
                                                           text-sm font-semibold
                                                           px-4 py-2
                                                           rounded-lg
                                                           hover:bg-red-50
                                                           transition"
                                                >
                                                    ✕ Cancel Application
                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </div>

                            </div>

                            {{-- Bottom line --}}
                            <div
                                class="h-1 w-full
                                       bg-gradient-to-r
                                       from-indigo-500
                                       via-blue-500
                                       to-cyan-400
                                       opacity-0
                                       group-hover:opacity-100
                                       transition duration-300"
                            ></div>

                        </div>

                    @endforeach

                </div>

            @else

                {{-- Empty State --}}
                <div
                    class="bg-white rounded-3xl
                           border border-slate-200
                           shadow-sm
                           p-12 md:p-16
                           text-center"
                >

                    <div
                        class="w-20 h-20 mx-auto mb-6
                               rounded-full
                               bg-indigo-50
                               flex items-center justify-center
                               text-4xl"
                    >
                        📋
                    </div>

                    <h2 class="text-2xl font-bold text-slate-900 mb-2">
                        No Applications Yet
                    </h2>

                    <p class="text-slate-500 max-w-md mx-auto mb-7">
                        You haven't applied for any jobs yet.
                        Start exploring available opportunities and submit your first application.
                    </p>

                    <a
                        href="{{ route('jobs.index') }}"
                        class="inline-flex items-center gap-2
                               bg-indigo-600 hover:bg-indigo-700
                               text-white font-semibold
                               px-6 py-3 rounded-xl
                               shadow-lg shadow-indigo-200
                               transition"
                    >
                        🔎 Browse Available Jobs
                    </a>

                </div>

            @endif

        </div>

    </div>


    {{-- AI Chatbot --}}
    @livewire('chatbot')

</body>

</html>