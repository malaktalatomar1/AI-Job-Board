<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class AIChatbotService
{
    /*
    |--------------------------------------------------------------------------
    | Main Chat Function
    |--------------------------------------------------------------------------
    */

    public function ask(User $user, string $question): string
    {
        $question = trim($question);

        if ($question === '') {
            return 'Please enter a question.';
        }

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {

            // Try to answer directly from database
            $directAnswer = $this->getDirectAdminAnswer($question);

            if ($directAnswer !== null) {
                return $directAnswer;
            }

            // Get admin database context
            $context = $this->getAdminContext();

        }

        /*
        |--------------------------------------------------------------------------
        | Candidate
        |--------------------------------------------------------------------------
        */

        else {

            // Try to answer directly from candidate data
            $directCandidateAnswer = $this->getDirectCandidateAnswer(
                $user,
                $question
            );

            if ($directCandidateAnswer !== null) {
                return $directCandidateAnswer;
            }

            // Get candidate database context
            $context = $this->getCandidateContext($user);
        }


        /*
        |--------------------------------------------------------------------------
        | Send Question To OpenAI
        |--------------------------------------------------------------------------
        */

        try {

            $response = OpenAI::chat()->create([

                'model' => 'gpt-4o-mini',

                'messages' => [

                    [
                        'role' => 'system',
                        'content' => $this->getSystemPrompt($user),
                    ],

                    [
                        'role' => 'user',
                        'content' =>
                            "Database information:\n"
                            . $context
                            . "\n\nQuestion:\n"
                            . $question,
                    ],

                ],

            ]);

            return $response->choices[0]->message->content
                ?? 'I could not generate an answer.';

        } catch (\Throwable $e) {

            Log::error('AI Chatbot Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return 'Sorry, something went wrong while contacting the AI.';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Direct Admin Questions
    |--------------------------------------------------------------------------
    */

    private function getDirectAdminAnswer(string $question): ?string
    {
        $question = strtolower(trim($question));


        /*
        |--------------------------------------------------------------------------
        | Number Of Candidates
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($question, 'how many candidates') ||
            str_contains($question, 'number of candidates') ||
            str_contains($question, 'candidate count') ||
            str_contains($question, 'how many candidates are registered') ||
            str_contains($question, 'عدد المتقدمين') ||
            str_contains($question, 'عدد المرشحين')
        ) {

            $count = User::where('role', 'candidate')->count();

            return "There are {$count} registered candidates.";
        }


        /*
        |--------------------------------------------------------------------------
        | Number Of Jobs
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($question, 'how many jobs') ||
            str_contains($question, 'number of jobs') ||
            str_contains($question, 'job count') ||
            str_contains($question, 'عدد الوظائف')
        ) {

            $count = Job::count();

            return "There are {$count} jobs in the system.";
        }


        /*
        |--------------------------------------------------------------------------
        | Available Jobs
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($question, 'available jobs') ||
            str_contains($question, 'active jobs') ||
            str_contains($question, 'list all available jobs') ||
            str_contains($question, 'show all available jobs') ||
            str_contains($question, 'الوظائف المتاحة')
        ) {

            $jobs = Job::with('category')
                ->whereDate(
                    'application_deadline',
                    '>=',
                    now()->toDateString()
                )
                ->get();

            if ($jobs->isEmpty()) {
                return 'There are no available jobs right now.';
            }

            $jobList = $jobs->map(function ($job) {

                $categoryName = $job->category
                    ? $job->category->name
                    : 'Uncategorized';

                return "- {$job->title} ({$categoryName})";

            })->implode("\n");

            return "Available jobs are:\n{$jobList}";
        }


        /*
        |--------------------------------------------------------------------------
        | Job With Most Applications
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($question, 'most applications') ||
            str_contains($question, 'most applied') ||
            str_contains($question, 'highest applications') ||
            str_contains($question, 'which job has the most applications') ||
            str_contains($question, 'أكثر وظيفة')
        ) {

            $job = Job::withCount('applications')
                ->orderByDesc('applications_count')
                ->first();

            if (!$job) {
                return 'There are no jobs in the system.';
            }

            return "The job with the most applications is '{$job->title}' with {$job->applications_count} applications.";
        }


        /*
        |--------------------------------------------------------------------------
        | Programming Jobs
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($question, 'programming category') ||
            str_contains($question, 'show jobs in the programming category') ||
            str_contains($question, 'jobs in the programming category') ||
            str_contains($question, 'programming')
        ) {

            $jobs = Job::with('category')
                ->whereHas('category', function ($query) {
                    $query->where('name', 'Programming');
                })
                ->get();

            if ($jobs->isEmpty()) {
                return 'There are no jobs in the Programming category.';
            }

            $jobList = $jobs
                ->pluck('title')
                ->implode(', ');

            return "Jobs in the Programming category are: {$jobList}";
        }


        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | Direct Candidate Questions
    |--------------------------------------------------------------------------
    */

    private function getDirectCandidateAnswer(
        User $user,
        string $question
    ): ?string {

        $question = strtolower(trim($question));


        /*
        |--------------------------------------------------------------------------
        | Best Jobs
        |--------------------------------------------------------------------------
        */

        $isBestJobsQuestion =
            str_contains($question, 'best jobs for me') ||
            str_contains($question, 'best jobs') ||
            str_contains($question, 'what jobs should i apply for') ||
            str_contains($question, 'which jobs are good for me') ||
            str_contains($question, 'أفضل وظائف لي') ||
            str_contains($question, 'ما هي أفضل الوظائف') ||
            str_contains($question, 'أحسن وظائف لي');


        /*
        |--------------------------------------------------------------------------
        | Matching Jobs
        |--------------------------------------------------------------------------
        */

        $isMatchQuestion =
            str_contains($question, 'match my skills') ||
            str_contains($question, 'jobs match my skills') ||
            str_contains($question, 'which jobs match') ||
            str_contains($question, 'which jobs fit my skills') ||
            str_contains($question, 'وظائف مناسبة لمهاراتي') ||
            str_contains($question, 'تطابق مهاراتي');


        /*
        |--------------------------------------------------------------------------
        | Skills
        |--------------------------------------------------------------------------
        */

        $isSkillQuestion =
            str_contains($question, 'what skills should i learn') ||
            str_contains($question, 'skills should i learn') ||
            str_contains($question, 'what skills should i improve') ||
            str_contains($question, 'what skills do i need') ||
            str_contains($question, 'مهارات يجب أن أتعلمها') ||
            str_contains($question, 'مهارات أحتاجها') ||
            str_contains($question, 'مهارات علي أن أتعلم');


        if (
            !$isBestJobsQuestion &&
            !$isMatchQuestion &&
            !$isSkillQuestion
        ) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Get Available Jobs
        |--------------------------------------------------------------------------
        */

        $jobs = Job::with('category')
            ->whereDate(
                'application_deadline',
                '>=',
                now()->toDateString()
            )
            ->get();

        if ($jobs->isEmpty()) {

            return 'There are no available jobs right now. Please check later for new openings.';
        }


        /*
        |--------------------------------------------------------------------------
        | Candidate Skills
        |--------------------------------------------------------------------------
        */

        $candidateSkills = $this->normalizeSkills(
            $user->skills
        );

        $candidateTitle = strtolower(
            (string) ($user->job_title ?? '')
        );


        /*
        |--------------------------------------------------------------------------
        | Score Jobs
        |--------------------------------------------------------------------------
        */

        $scoredJobs = $jobs
            ->map(function ($job) use (
                $candidateSkills,
                $candidateTitle
            ) {

                $jobSkills = $this->normalizeSkills(
                    $job->required_skills
                );

                $matches = array_values(
                    array_unique(
                        array_intersect(
                            $candidateSkills,
                            $jobSkills
                        )
                    )
                );

                $titleScore = 0;

                if ($candidateTitle !== '') {

                    $jobTitle = strtolower(
                        (string) $job->title
                    );

                    if (
                        str_contains($jobTitle, $candidateTitle) ||
                        str_contains($candidateTitle, $jobTitle)
                    ) {
                        $titleScore = 1;
                    }
                }

                return [
                    'job' => $job,
                    'match_count' => count($matches),
                    'score' => count($matches) + $titleScore,
                    'matches' => $matches,
                ];

            })
            ->sortByDesc('score')
            ->values();


        if ($scoredJobs->isEmpty()) {

            return 'I could not find a strong match from your current skills. Consider updating your profile with more skills and experience.';
        }


        /*
        |--------------------------------------------------------------------------
        | Best Jobs Answer
        |--------------------------------------------------------------------------
        */

        if ($isBestJobsQuestion) {

            $topJobs = $scoredJobs->take(3);

            $jobList = $topJobs
                ->map(function ($item) {

                    return "- {$item['job']->title} ({$item['match_count']} matching skills)";

                })
                ->implode("\n");

            return "Based on your profile and the current openings, the best jobs for you are:\n"
                . $jobList
                . "\n\nYour strongest matches are the roles that align closely with your current skills and experience.";
        }


        /*
        |--------------------------------------------------------------------------
        | Matching Jobs Answer
        |--------------------------------------------------------------------------
        */

        if ($isMatchQuestion) {

            $matchingJobs = $scoredJobs
                ->filter(
                    fn ($item) => $item['match_count'] > 0
                )
                ->take(5);

            if ($matchingJobs->isEmpty()) {

                return 'There are no jobs that match your current skills right now. You may want to add more relevant skills to your profile.';
            }

            $jobList = $matchingJobs
                ->map(function ($item) {

                    return "- {$item['job']->title} (matches: "
                        . implode(', ', $item['matches'])
                        . ')';

                })
                ->implode("\n");

            return "Jobs that match your skills are:\n{$jobList}";
        }


        /*
        |--------------------------------------------------------------------------
        | Missing Skills
        |--------------------------------------------------------------------------
        */

        $topMissingSkills = [];

        foreach ($scoredJobs->take(3) as $item) {

            $requiredSkills = $this->normalizeSkills(
                $item['job']->required_skills
            );

            foreach ($requiredSkills as $skill) {

                if (
                    !in_array(
                        $skill,
                        $candidateSkills,
                        true
                    ) &&
                    !in_array(
                        $skill,
                        $topMissingSkills,
                        true
                    )
                ) {

                    $topMissingSkills[] = $skill;
                }
            }
        }


        if (empty($topMissingSkills)) {

            return 'Your profile already matches the available roles closely. You are in a strong position for the current job market.';
        }


        $skillsList = implode(
            ', ',
            array_slice($topMissingSkills, 0, 5)
        );

        return "To improve your chances, you should focus on these skills:\n"
            . "- {$skillsList}\n\n"
            . "These are the most relevant skills that appear in the top jobs matching your profile.";
    }


    /*
    |--------------------------------------------------------------------------
    | Normalize Skills
    |--------------------------------------------------------------------------
    */

    private function normalizeSkills(?string $value): array
    {
        if (
            !is_string($value) ||
            trim($value) === ''
        ) {
            return [];
        }

        return array_values(
            array_unique(
                array_filter(
                    array_map(
                        function ($skill) {

                            $clean = strtolower(
                                trim((string) $skill)
                            );

                            return $clean !== ''
                                ? str_replace(
                                    [';', ','],
                                    ' ',
                                    $clean
                                )
                                : null;

                        },
                        preg_split(
                            '/[\n,;]+/',
                            $value
                        )
                    ),
                    fn ($skill) =>
                        $skill !== null &&
                        $skill !== ''
                )
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | System Prompt
    |--------------------------------------------------------------------------
    */

    private function getSystemPrompt(User $user): string
    {
        if ($user->role === 'admin') {

            return <<<PROMPT
You are an AI assistant for a job recruitment system.

You are assisting an administrator.

Use ONLY the database information provided.

You can help the administrator with:
- Jobs
- Candidates
- Applications
- Categories
- Available jobs

Never invent numbers or database information.

Give short and clear answers.
PROMPT;
        }


        return <<<PROMPT
You are an AI career assistant for a job recruitment system.

You are assisting a candidate.

Use the candidate profile and available jobs provided in the database information.

You can help with:
- Finding suitable jobs
- Matching jobs with skills
- Explaining job requirements
- Suggesting skills to learn

Never invent jobs or skills.

Give clear and useful answers.
PROMPT;
    }


    /*
    |--------------------------------------------------------------------------
    | Candidate Context
    |--------------------------------------------------------------------------
    */

    private function getCandidateContext(User $user): string
    {
        $jobs = Job::with('category')
            ->whereDate(
                'application_deadline',
                '>=',
                now()->toDateString()
            )
            ->get();


        $candidate = [
            'name' => $user->name,
            'job_title' => $user->job_title,
            'profile_description' => $user->profile_description,
            'skills' => $user->skills,
        ];


        $availableJobs = $jobs->map(function ($job) {

            return [
                'title' => $job->title,
                'description' => $job->description,
                'required_skills' => $job->required_skills,
                'category' => $job->category?->name,
                'location' => $job->location,
                'work_type' => $job->work_type,
                'salary' => $job->salary,
                'application_deadline' => $job->application_deadline,
            ];

        });


        return json_encode(
            [
                'candidate' => $candidate,
                'available_jobs' => $availableJobs,
            ],
            JSON_PRETTY_PRINT
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Context
    |--------------------------------------------------------------------------
    */

    private function getAdminContext(): string
    {
        $candidateCount = User::where(
            'role',
            'candidate'
        )->count();


        $availableJobs = Job::with('category')
            ->whereDate(
                'application_deadline',
                '>=',
                now()->toDateString()
            )
            ->get();


        $jobsWithApplications = Job::withCount(
            'applications'
        )
            ->orderByDesc(
                'applications_count'
            )
            ->get();


        $categories = Category::with('jobs')
            ->get();


        return json_encode(
            [
                'candidate_count' => $candidateCount,

                'available_jobs' => $availableJobs->map(
                    function ($job) {

                        return [
                            'title' => $job->title,
                            'category' => $job->category?->name,
                            'location' => $job->location,
                            'work_type' => $job->work_type,
                            'application_deadline' =>
                                $job->application_deadline,
                        ];
                    }
                ),

                'jobs_with_application_counts' =>
                    $jobsWithApplications->map(
                        function ($job) {

                            return [
                                'title' => $job->title,
                                'applications_count' =>
                                    $job->applications_count,
                            ];
                        }
                    ),

                'categories' =>
                    $categories->map(
                        function ($category) {

                            return [
                                'category' => $category->name,
                                'jobs' =>
                                    $category->jobs
                                        ->pluck('title'),
                            ];
                        }
                    ),
            ],
            JSON_PRETTY_PRINT
        );
    }
}