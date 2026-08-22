<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jobs | AI Job Board</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-gray-800">

    {{-- ================= NAVBAR ================= --}}
    <x-navbar />


    {{-- ================= HERO SECTION ================= --}}
    <section
        class="relative overflow-hidden
               bg-gradient-to-br from-indigo-700
               via-indigo-600 to-blue-600
               text-white"
    >

        {{-- Background decorations --}}
        <div
            class="absolute -top-24 -right-24
                   w-72 h-72
                   bg-white/10
                   rounded-full"
        ></div>

        <div
            class="absolute -bottom-32 -left-20
                   w-80 h-80
                   bg-blue-400/10
                   rounded-full"
        ></div>


        <div
            class="relative
                   max-w-7xl
                   mx-auto
                   px-6
                   py-16
                   sm:py-20"
        >

            <div class="max-w-3xl">

                {{-- Small Badge --}}
                <div
                    class="inline-flex
                           items-center
                           gap-2
                           px-4
                           py-2
                           rounded-full
                           bg-white/10
                           border border-white/20
                           backdrop-blur-sm
                           text-sm
                           font-medium
                           mb-6"
                >

                    <span>✨</span>

                    <span>
                        Find your next opportunity
                    </span>

                </div>


                {{-- Main Heading --}}
                <h1
                    class="text-4xl
                           sm:text-5xl
                           lg:text-6xl
                           font-extrabold
                           leading-tight"
                >

                    Find a Job That
                    <span class="text-yellow-300">
                        Fits You
                    </span>

                </h1>


                {{-- Description --}}
                <p
                    class="mt-5
                           text-lg
                           sm:text-xl
                           text-indigo-100
                           leading-relaxed"
                >

                    Explore the latest job opportunities and
                    discover the perfect position for your skills
                    and career goals.

                </p>


                {{-- Stats --}}
                <div class="flex flex-wrap gap-8 mt-8">

                    <div>

                        <p class="text-3xl font-bold">
                            {{ $jobs->count() }}
                        </p>

                        <p class="text-indigo-200 text-sm">
                            Available Jobs
                        </p>

                    </div>

                    <div class="border-l border-white/20 pl-8">

                        <p class="text-3xl font-bold">
                            AI
                        </p>

                        <p class="text-indigo-200 text-sm">
                            Smart Job Board
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- ================= JOBS SECTION ================= --}}
    <main
        class="max-w-7xl
               mx-auto
               px-6
               py-12"
    >

        {{-- Section Header --}}
        <div
            class="flex
                   flex-col
                   sm:flex-row
                   sm:items-end
                   sm:justify-between
                   gap-4
                   mb-8"
        >

            <div>

                <p
                    class="text-indigo-600
                           font-semibold
                           text-sm
                           uppercase
                           tracking-wider"
                >
                    Opportunities
                </p>

                <h2
                    class="text-3xl
                           font-extrabold
                           text-gray-900
                           mt-1"
                >
                    Available Jobs
                </h2>

                <p class="text-gray-500 mt-2">
                    Browse our latest job opportunities.
                </p>

            </div>


            {{-- Job Count --}}
            <div
                class="inline-flex
                       items-center
                       gap-2
                       bg-white
                       border border-gray-200
                       rounded-xl
                       px-4
                       py-3
                       shadow-sm"
            >

                <span
                    class="w-2.5
                           h-2.5
                           rounded-full
                           bg-green-500"
                ></span>

                <span class="text-sm font-medium text-gray-600">

                    {{ $jobs->count() }}
                    {{ $jobs->count() == 1 ? 'Job' : 'Jobs' }}

                </span>

            </div>

        </div>



        @if ($jobs->count())

            {{-- ================= JOB CARDS ================= --}}
            <div
                class="grid
                       sm:grid-cols-2
                       lg:grid-cols-3
                       gap-6"
            >

                @foreach ($jobs as $job)

                    <article
                        class="group
                               bg-white
                               rounded-2xl
                               border border-gray-100
                               shadow-sm
                               overflow-hidden
                               hover:shadow-2xl
                               hover:-translate-y-1
                               transition-all
                               duration-300"
                    >

                        {{-- Card Top --}}
                        <div
                            class="relative
                                   h-2
                                   bg-gradient-to-r
                                   from-indigo-500
                                   to-blue-500"
                        ></div>


                        <div class="p-6">

                            {{-- Category + Icon --}}
                            <div
                                class="flex
                                       items-start
                                       justify-between
                                       gap-4
                                       mb-5"
                            >

                                <span
                                    class="inline-flex
                                           items-center
                                           px-3
                                           py-1.5
                                           rounded-full
                                           bg-indigo-50
                                           text-indigo-600
                                           text-xs
                                           font-bold"
                                >

                                    {{ $job->category->name }}

                                </span>


                                <div
                                    class="w-11
                                           h-11
                                           rounded-xl
                                           bg-indigo-50
                                           text-indigo-600
                                           flex
                                           items-center
                                           justify-center
                                           text-xl
                                           group-hover:bg-indigo-600
                                           group-hover:text-white
                                           transition"
                                >
                                    💼
                                </div>

                            </div>


                            {{-- Job Title --}}
                            <h3
                                class="text-xl
                                       font-bold
                                       text-gray-900
                                       leading-snug
                                       group-hover:text-indigo-600
                                       transition"
                            >

                                {{ $job->title }}

                            </h3>


                            {{-- Job Details --}}
                            <div
                                class="mt-5
                                       space-y-3
                                       text-sm"
                            >

                                {{-- Location --}}
                                <div
                                    class="flex
                                           items-center
                                           gap-3
                                           text-gray-600"
                                >

                                    <span
                                        class="w-9
                                               h-9
                                               rounded-lg
                                               bg-gray-50
                                               flex
                                               items-center
                                               justify-center"
                                    >
                                        📍
                                    </span>

                                    <div>

                                        <p class="text-xs text-gray-400">
                                            Location
                                        </p>

                                        <p class="font-medium text-gray-700">
                                            {{ $job->location }}
                                        </p>

                                    </div>

                                </div>


                                {{-- Work Type --}}
                                <div
                                    class="flex
                                           items-center
                                           gap-3
                                           text-gray-600"
                                >

                                    <span
                                        class="w-9
                                               h-9
                                               rounded-lg
                                               bg-gray-50
                                               flex
                                               items-center
                                               justify-center"
                                    >
                                        🏢
                                    </span>

                                    <div>

                                        <p class="text-xs text-gray-400">
                                            Work Type
                                        </p>

                                        <p class="font-medium text-gray-700">
                                            {{ $job->work_type }}
                                        </p>

                                    </div>

                                </div>


                                {{-- Salary --}}
                                <div
                                    class="flex
                                           items-center
                                           gap-3
                                           text-gray-600"
                                >

                                    <span
                                        class="w-9
                                               h-9
                                               rounded-lg
                                               bg-gray-50
                                               flex
                                               items-center
                                               justify-center"
                                    >
                                        💰
                                    </span>

                                    <div>

                                        <p class="text-xs text-gray-400">
                                            Salary
                                        </p>

                                        <p
                                            class="font-semibold
                                                   text-gray-800"
                                        >
                                            {{ $job->salary }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- Divider --}}
                            <div
                                class="border-t
                                       border-gray-100
                                       my-6"
                            ></div>


                            {{-- Footer --}}
                            <div
                                class="flex
                                       items-center
                                       justify-between
                                       gap-4"
                            >

                                <span
                                    class="text-xs
                                           text-gray-400"
                                >
                                    View job details
                                </span>


                                <a
                                    href="{{ route('jobs.show', $job->id) }}"
                                    class="inline-flex
                                           items-center
                                           gap-2
                                           bg-indigo-600
                                           hover:bg-indigo-700
                                           text-white
                                           font-semibold
                                           text-sm
                                           px-4
                                           py-2.5
                                           rounded-xl
                                           transition
                                           group-hover:shadow-lg"
                                >

                                    View Details

                                    <span
                                        class="group-hover:translate-x-1
                                               transition"
                                    >
                                        →
                                    </span>

                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>


        @else

            {{-- ================= EMPTY STATE ================= --}}
            <div
                class="bg-white
                       rounded-3xl
                       border border-gray-100
                       shadow-sm
                       p-12
                       text-center"
            >

                <div
                    class="w-20
                           h-20
                           mx-auto
                           rounded-2xl
                           bg-indigo-50
                           flex
                           items-center
                           justify-center
                           text-4xl
                           mb-6"
                >
                    🔍
                </div>


                <h2
                    class="text-2xl
                           font-bold
                           text-gray-900"
                >
                    No Jobs Available
                </h2>


                <p
                    class="text-gray-500
                           mt-2
                           max-w-md
                           mx-auto"
                >
                    There are no job opportunities available
                    at the moment. Please check again later.
                </p>

            </div>

        @endif

    </main>



    {{-- ================= CHATBOT ================= --}}
    @livewire('chatbot')


</body>

</html>