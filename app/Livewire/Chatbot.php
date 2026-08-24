<?php

namespace App\Livewire;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Gemini\Laravel\Facades\Gemini;

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

        try {
    $answer = $this->generateAIAnswer($question);
} catch (\Throwable $e) {
    dd($e->getMessage());
}

        // Assistant message
        $this->messages[] = [
            'role' => 'assistant',
            'message' => $answer,
        ];

        $this->question = '';
    }

    private function generateAIAnswer(string $question): string
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | User information
        |--------------------------------------------------------------------------
        */

        $userData = [];

        if ($user) {
            $userData = [
                'name' => $user->name,
                'role' => $user->role,
                'job_title' => $user->job_title,
                'skills' => $user->skills,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Available jobs
        |--------------------------------------------------------------------------
        */

        $jobs = Job::with('category')
            ->whereDate('application_deadline', '>=', now())
            ->get();

        $jobsData = $jobs->map(function ($job) {
            return [
                'title' => $job->title,
                'category' => $job->category->name ?? 'No category',
                'work_type' => $job->work_type,
                'required_skills' => $job->required_skills,
                'application_deadline' => $job->application_deadline,
            ];
        })->toArray();

        /*
        |--------------------------------------------------------------------------
        | Admin information
        |--------------------------------------------------------------------------
        */

        $adminData = [];

        if ($user && $user->role === 'admin') {

            $candidateCount = \App\Models\User::where(
                'role',
                'candidate'
            )->count();

            $mostAppliedJob = Job::withCount([
                'applications' => function ($query) {
                    $query->where('status', '!=', 'Cancelled');
                }
            ])
                ->orderByDesc('applications_count')
                ->first();

            $adminData = [
                'number_of_candidates' => $candidateCount,

                'most_applied_job' => $mostAppliedJob
                    ? [
                        'title' => $mostAppliedJob->title,
                        'applications' => $mostAppliedJob->applications_count,
                    ]
                    : null,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Prompt for Gemini
        |--------------------------------------------------------------------------
        */

        $prompt = <<<PROMPT

You are an AI assistant for a Job Recruitment System.

Your job is to help users with:

- Available jobs
- Job recommendations
- Skills
- Skills they should learn
- Job categories
- Work types
- Application information
- General questions about the recruitment system

IMPORTANT RULES:

1. Answer based on the data provided below.
2. Do NOT invent jobs or information.
3. If the requested information is not available, say that clearly.
4. If the user asks for job recommendations, compare their skills with the required skills of available jobs.
5. If the user is an admin, they can ask about candidates and application statistics.
6. If the user is a candidate, focus on jobs, skills and recommendations.
7. The user may speak Arabic or English.
8. Answer in the same language used by the user.
9. Keep answers clear and relatively concise.
10. You are an assistant inside a recruitment website.

CURRENT USER:

{$this->jsonEncode($userData)}

ADMIN DATA:

{$this->jsonEncode($adminData)}

AVAILABLE JOBS:

{$this->jsonEncode($jobsData)}

USER QUESTION:

{$question}

PROMPT;

        /*
        |--------------------------------------------------------------------------
        | Send request to Gemini
        |--------------------------------------------------------------------------
        */

        $response = Gemini::generativeModel(
    model: 'gemini-3.6-flash'
)->generateContent($prompt);

        return $response->text();
    }

    private function jsonEncode($data): string
    {
        return json_encode(
            $data,
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
    }

    public function render()
    {
        return view('components.chatbot');
    }
}