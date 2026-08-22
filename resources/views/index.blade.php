<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jobs</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
<x-navbar />
    <div class="max-w-7xl mx-auto px-6 py-10">

        <h1 class="text-3xl font-bold mb-8">
            Available Jobs
        </h1>

        @if ($jobs->count())

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($jobs as $job)

                    <div class="bg-white rounded-lg shadow p-6">

                        <h2 class="text-xl font-bold mb-2">
                            {{ $job->title }}
                        </h2>

                        <p class="text-gray-600 mb-2">
                            Category:
                            {{ $job->category->name }}
                        </p>

                        <p class="mb-2">
                            📍 {{ $job->location }}
                        </p>

                        <p class="mb-2">
                            💼 {{ $job->work_type }}
                        </p>

                        <p class="mb-4">
                            💰 {{ $job->salary }}
                        </p>

                        <a
                            href="{{ route('jobs.show', $job->id) }}"
                            class="inline-block bg-blue-600 text-white px-4 py-2 rounded"
                        >
                            View Details
                        </a>

                    </div>

                @endforeach

            </div>

        @else

            <p class="text-gray-600">
                No jobs available at the moment.
            </p>

        @endif

    </div>
@livewire('chatbot')
</body>

</html>