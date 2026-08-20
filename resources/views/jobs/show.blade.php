<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $job->title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto px-6 py-10">

        <a href="{{ route('jobs.index') }}"
           class="text-blue-600 hover:underline">
            ← Back to Jobs
        </a>

        <div class="bg-white rounded-lg shadow p-8 mt-6">

            <h1 class="text-3xl font-bold mb-4">
                {{ $job->title }}
            </h1>

            <div class="space-y-3">

                <p>
                    <strong>Category:</strong>
                    {{ $job->category->name }}
                </p>

                <p>
                    <strong>Location:</strong>
                    {{ $job->location }}
                </p>

                <p>
                    <strong>Work Type:</strong>
                    {{ $job->work_type }}
                </p>

                <p>
                    <strong>Salary:</strong>
                    {{ $job->salary }}
                </p>

                <p>
                    <strong>Application Deadline:</strong>
                    {{ $job->application_deadline }}
                </p>

            </div>

            <hr class="my-6">

            <h2 class="text-xl font-bold mb-3">
                Description
            </h2>

            <p class="text-gray-700 mb-6">
                {{ $job->description }}
            </p>

            <h2 class="text-xl font-bold mb-3">
                Required Skills
            </h2>

            <p class="text-gray-700 mb-8">
                {{ $job->required_skills }}
            </p>

            @if (session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
        {{ session('error') }}
    </div>
@endif

@if (auth()->check())

    <form action="{{ route('jobs.apply', $job->id) }}" method="POST">
        @csrf

        <button
            type="submit"
            class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
            Apply Now
        </button>
    </form>

@else

    <a
        href="{{ route('login') }}"
        class="inline-block bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
        Login to Apply
    </a>

@endif

        </div>

    </div>

</body>

</html>