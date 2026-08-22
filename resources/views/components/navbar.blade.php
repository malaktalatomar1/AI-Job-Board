<nav class="bg-white shadow-md border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ url('/jobs') }}"
               class="text-2xl font-bold text-indigo-600">
                AI Job Board
            </a>

            {{-- Links --}}
            <div class="flex items-center gap-6">

                {{-- Jobs --}}
                <a href="{{ route('jobs.index') }}"
                   class="text-gray-700 hover:text-indigo-600 font-medium transition">
                    Jobs
                </a>

                {{-- My Applications --}}
                <a href="{{ route('applications.index') }}"
                   class="text-gray-700 hover:text-indigo-600 font-medium transition">
                    My Applications
                </a>

                {{-- Profile --}}
                <a href="{{ route('profile.edit') }}"
                   class="text-gray-700 hover:text-indigo-600 font-medium transition">
                    Profile
                </a>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf

                    <button type="submit"
                            class="text-red-600 hover:text-red-700 font-medium transition">
                        Logout
                    </button>
                </form>

            </div>

        </div>
    </div>
</nav>