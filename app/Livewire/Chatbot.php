<?php

namespace App\Livewire;

use App\Models\Job;
use App\Models\User;
use App\Models\JobApplication;
use Illuminate\Support\Str;
use Livewire\Component;

class Chatbot extends Component
{
    public bool $open = false;

    public string $question = '';

    public array $messages = [];

    public function toggleChat(): void
    {
        $this->open = ! $this->open;
    }

    public function ask(): void
    {
        $question = trim($this->question);

        if ($question === '') {
            return;
        }

        // User message
        $this->messages[] = [
            'role' => 'user',
            'message' => $question,
        ];

        $answer = $this->generateAnswer($question);

        // Assistant message
        $this->messages[] = [
            'role' => 'assistant',
            'message' => $answer,
        ];

        $this->question = '';
    }

    private function generateAnswer(string $question): string
    {
        $q = Str::lower($question);

        /*
        |--------------------------------------------------------------------------
        | ADMIN QUESTIONS
        |--------------------------------------------------------------------------
        */

        if (auth()->check() && auth()->user('admin')) {

            // How many candidates?
            if (
                Str::contains($q, 'how many candidates') ||
                Str::contains($q, 'number of candidates') ||
                Str::contains($q, 'candidates registered')
            ) {
                $count = User::where('role', 'candidate')->count();

                return "There are {$count} registered candidates.";
            }

            // Most applications
            if (
                Str::contains($q, 'most applications') ||
                Str::contains($q, 'most applied') ||
                Str::contains($q, 'popular job')
            ) {
                $job = Job::withCount([
                    'applications' => function ($query) {
                        $query->where('status', '!=', 'Cancelled');
                    }
                ])
                    ->orderByDesc('applications_count')
                    ->first();

                if (!$job) {
                    return "There are no jobs available.";
                }

                return "The job with the most applications is '{$job->title}' "
                    . "with {$job->applications_count} applications.";
            }

            // List all jobs
            if (
                Str::contains($q, 'list all available jobs') ||
                Str::contains($q, 'all available jobs') ||
                Str::contains($q, 'available jobs')
            ) {
                $jobs = Job::with('category')
                    ->whereDate('application_deadline', '>=', now())
                    ->get();

                if ($jobs->isEmpty()) {
                    return "There are no available jobs at the moment.";
                }

                $answer = "Here are the available jobs:\n\n";

                foreach ($jobs as $job) {
                    $answer .= "• {$job->title} - "
                        . ($job->category->name ?? 'No category')
                        . " - {$job->work_type}\n";
                }

                return $answer;
            }

            // Programming jobs
            if (
                Str::contains($q, 'programming') ||
                Str::contains($q, 'programming category')
            ) {
                $jobs = Job::whereHas('category', function ($query) {
                    $query->where('name', 'Programming');
                })
                    ->whereDate('application_deadline', '>=', now())
                    ->get();

                if ($jobs->isEmpty()) {
                    return "There are no available jobs in the Programming category.";
                }

                $answer = "Jobs in the Programming category:\n\n";

                foreach ($jobs as $job) {
                    $answer .= "• {$job->title}\n";
                }

                return $answer;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CANDIDATE QUESTIONS
        |--------------------------------------------------------------------------
        */

        if (auth()->check()) {

            $user = auth()->user();

            // Best jobs / matching jobs
            if (
                Str::contains($q, 'best jobs') ||
                Str::contains($q, 'jobs for me') ||
                Str::contains($q, 'match my skills') ||
                Str::contains($q, 'matching jobs')
            ) {
                return $this->recommendJobs($user);
            }

            // Skills to learn
            if (
                Str::contains($q, 'skills should i learn') ||
                Str::contains($q, 'what skills should i learn') ||
                Str::contains($q, 'skills to learn')
            ) {
                return $this->skillsToLearn($user);
            }
        }

        return "I can help you with jobs, applications, skills, and recommendations. "
            . "Try asking: What are the best jobs for me?";
    }

    /*
    |--------------------------------------------------------------------------
    | Recommend jobs based on candidate skills
    |--------------------------------------------------------------------------
    */

    private function recommendJobs($user): string
    {
        $userSkills = $this->extractSkills($user->skills);

        if (empty($userSkills)) {
            return "Please add your skills to your profile first so I can recommend suitable jobs.";
        }

        $jobs = Job::with('category')
            ->whereDate('application_deadline', '>=', now())
            ->get();

        $recommendations = [];

        foreach ($jobs as $job) {

            $requiredSkills = $this->extractSkills($job->required_skills);

            $matches = array_intersect($userSkills, $requiredSkills);

            $score = count($matches);

            // Job title match
            if (
                !empty($user->job_title) &&
                Str::contains(
                    Str::lower($job->title),
                    Str::lower($user->job_title)
                )
            ) {
                $score += 2;
            }

            if ($score > 0) {
                $recommendations[] = [
                    'job' => $job,
                    'score' => $score,
                    'matches' => $matches,
                ];
            }
        }

        usort($recommendations, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        if (empty($recommendations)) {
            return "I couldn't find a strong job match based on your current profile.";
        }

        $answer = "Based on your profile, these jobs are good matches:\n\n";

        foreach (array_slice($recommendations, 0, 5) as $recommendation) {

            $job = $recommendation['job'];

            $matchedSkills = implode(
                ', ',
                $recommendation['matches']
            );

            $answer .= "• {$job->title}\n";

            if ($matchedSkills) {
                $answer .= "  Matching skills: {$matchedSkills}\n";
            }

            $answer .= "  Work type: {$job->work_type}\n\n";
        }

        return $answer;
    }

    /*
    |--------------------------------------------------------------------------
    | Skills to learn
    |--------------------------------------------------------------------------
    */

    private function skillsToLearn($user): string
    {
        $userSkills = $this->extractSkills($user->skills);

        $jobs = Job::whereDate('application_deadline', '>=', now())
            ->get();

        $missingSkills = [];

        foreach ($jobs as $job) {

            $requiredSkills = $this->extractSkills($job->required_skills);

            foreach ($requiredSkills as $skill) {

                if (!in_array($skill, $userSkills)) {
                    $missingSkills[] = $skill;
                }
            }
        }

        $missingSkills = array_unique($missingSkills);

        if (empty($missingSkills)) {
            return "Your current skills match the available jobs very well.";
        }

        return "Based on the available jobs, you may want to learn:\n\n• "
            . implode("\n• ", array_slice($missingSkills, 0, 10));
    }

    /*
    |--------------------------------------------------------------------------
    | Convert skills string into array
    |--------------------------------------------------------------------------
    */

    private function extractSkills(?string $skills): array
    {
        if (!$skills) {
            return [];
        }

        $skills = preg_split('/[,;|]+/', Str::lower($skills));

        return array_values(
            array_filter(
                array_map('trim', $skills)
            )
        );
    }

    public function render()
    {
        return view('components.chatbot');
    }
}