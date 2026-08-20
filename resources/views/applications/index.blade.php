<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Applications</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="max-w-6xl mx-auto px-6 py-10">

        <div class="flex justify-between items-center mb-8">

            <h1 class="text-3xl font-bold">
                My Applications
            </h1>

            <a
                href="{{ route('jobs.index') }}"
                class="bg-blue-600 text-white px-5 py-2 rounded"
            >
                Browse Jobs
            </a>

        </div>

        @if ($applications->count())

            <div class="space-y-4">

                @foreach ($applications as $application)

                    <div class="bg-white rounded-lg shadow p-6">

                        <div class="flex justify-between items-start">

                            <div>

                                <h2 class="text-xl font-bold">
                                    {{ $application->job->title }}
                                </h2>

                                <p class="text-gray-600 mt-2">
                                    Category:
                                    {{ $application->job->category->name }}
                                </p>

                                <p class="text-gray-600">
                                    Location:
                                    {{ $application->job->location }}
                                </p>

                                <p class="text-gray-500 text-sm mt-2">
                                    Applied:
                                    {{ $application->created_at->format('Y-m-d') }}
                                </p>

                            </div>

                            <div>

    @if ($application->status === 'Pending')

        <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full">
            Pending
        </span>

        <form
            action="{{ route('applications.cancel', $application->id) }}"
            method="POST"
            class="mt-4"
        >
            @csrf
            @method('PATCH')

            <button
                type="submit"
                class="bg-red-600 text-white px-4 py-2 rounded"
            >
                Cancel Application
            </button>
        </form>

    @elseif ($application->status === 'Accepted')

        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full">
            Accepted
        </span>

    @elseif ($application->status === 'Canceled')

        <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full">
            Canceled
        </span>

    @else

        <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full">
            Rejected
        </span>

    @endif

</div>
                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="bg-white rounded-lg shadow p-8 text-center">

                <p class="text-gray-600 mb-4">
                    You haven't applied for any jobs yet.
                </p>

                <a
                    href="{{ route('jobs.index') }}"
                    class="text-blue-600 hover:underline"
                >
                    Browse Available Jobs
                </a>

            </div>

        @endif

    </div>

</body>

</html>