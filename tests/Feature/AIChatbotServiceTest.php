<?php

use App\Models\Category;
use App\Models\Job;
use App\Models\User;
use App\Services\AIChatbotService;

test('admin users are redirected to filament after login', function () {
    $user = User::factory()->create([
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/admin');
});

test('candidate users are redirected to dashboard after login', function () {
    $user = User::factory()->create([
        'email' => 'candidate@example.com',
        'password' => bcrypt('password'),
        'role' => 'candidate',
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/dashboard');
});

test('admin can ask about candidates, most applications, available jobs, and programming jobs', function () {
    $category = Category::create([
        'name' => 'Programming',
    ]);

    Category::create(['name' => 'Design']);

    $jobOne = Job::create([
        'title' => 'PHP Developer',
        'description' => 'Build backend logic',
        'required_skills' => 'PHP, Laravel, SQL',
        'category_id' => $category->id,
        'location' => 'Cairo',
        'work_type' => 'Remote',
        'salary' => 12000,
        'application_deadline' => now()->addMonth()->toDateString(),
    ]);

    $jobTwo = Job::create([
        'title' => 'Frontend Engineer',
        'description' => 'Build interfaces',
        'required_skills' => 'JavaScript, React',
        'category_id' => $category->id,
        'location' => 'Alexandria',
        'work_type' => 'Hybrid',
        'salary' => 11000,
        'application_deadline' => now()->addMonth()->toDateString(),
    ]);

    User::factory()->count(3)->create(['role' => 'candidate']);

    $jobOne->applications()->create([
        'user_id' => User::factory()->create(['role' => 'candidate'])->id,
    ]);
    $jobOne->applications()->create([
        'user_id' => User::factory()->create(['role' => 'candidate'])->id,
    ]);
    $jobTwo->applications()->create([
        'user_id' => User::factory()->create(['role' => 'candidate'])->id,
    ]);

    $admin = User::factory()->create(['role' => 'admin']);
    $service = app(AIChatbotService::class);

    $candidateCount = $service->ask($admin, 'How many candidates are registered?');
    $mostApplied = $service->ask($admin, 'Which job has the most applications?');
    $availableJobs = $service->ask($admin, 'List all available jobs.');
    $programmingJobs = $service->ask($admin, 'Show jobs in the Programming category.');

    expect($candidateCount)->toContain('6');
    expect($mostApplied)->toContain('PHP Developer');
    expect($availableJobs)->toContain('PHP Developer');
    expect($programmingJobs)->toContain('PHP Developer');
});

test('candidate questions are answered from profile and jobs data', function () {
    $category = Category::create([
        'name' => 'Development',
    ]);

    Job::create([
        'title' => 'Frontend Developer',
        'description' => 'Build web interfaces',
        'required_skills' => 'JavaScript, React, HTML, CSS',
        'category_id' => $category->id,
        'location' => 'Cairo',
        'work_type' => 'Remote',
        'salary' => 8000,
        'application_deadline' => now()->addMonth()->toDateString(),
    ]);

    Job::create([
        'title' => 'Backend Developer',
        'description' => 'Build APIs',
        'required_skills' => 'PHP, Laravel, MySQL',
        'category_id' => $category->id,
        'location' => 'Alexandria',
        'work_type' => 'Hybrid',
        'salary' => 9000,
        'application_deadline' => now()->addMonth()->toDateString(),
    ]);

    $user = User::create([
        'name' => 'Ahmed',
        'email' => 'ahmed@example.com',
        'password' => bcrypt('password'),
        'role' => 'candidate',
        'job_title' => 'Frontend Developer',
        'profile_description' => 'Frontend developer with experience in web apps.',
        'skills' => 'JavaScript, React, HTML, CSS, Git',
    ]);

    $service = app(AIChatbotService::class);

    $bestJobs = $service->ask($user, 'What are the best jobs for me?');
    $matchingJobs = $service->ask($user, 'Which jobs match my skills?');
    $skillsToLearn = $service->ask($user, 'What skills should I learn?');

    expect($bestJobs)->toContain('Frontend Developer');
    expect($matchingJobs)->toContain('Frontend Developer');
    expect($skillsToLearn)->toContain('php');
});
