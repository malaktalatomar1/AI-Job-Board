<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display all jobs.
     */
    public function index()
    {
        $jobs = Job::with('category')
            ->latest()
            ->get();

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Display a single job.
     */
    public function show($id)
    {
        $job = Job::with('category')
            ->findOrFail($id);

        return view('jobs.show', compact('job'));
    }

    /**
     * Apply for a job.
     */
    public function apply(Request $request, $id)
{
    $job = Job::findOrFail($id);

    $user = auth()->user();

    // Check if profile is complete
    if (
        empty($user->name) ||
        empty($user->email) ||
        empty($user->age) ||
        empty($user->job_title) ||
        empty($user->profile_description) ||
        empty($user->phone) ||
        empty($user->skills) ||
        empty($user->resume)
    ) {
        return back()->with(
            'error',
            'Please complete your profile before applying for a job.'
        );
    }

    // Check if already applied
    $alreadyApplied = JobApplication::where('user_id', $user->id)
        ->where('job_id', $job->id)
        ->exists();

    if ($alreadyApplied) {
        return back()->with(
            'error',
            'You have already applied for this job.'
        );
    }

    // Create application
    JobApplication::create([
        'user_id' => $user->id,
        'job_id' => $job->id,
        'status' => 'Pending',
    ]);

    return back()->with(
        'success',
        'Application submitted successfully!'
    );
}

    /**
     * Display user's applications.
     */
    public function myApplications()
    {
        $applications = JobApplication::with('job.category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'applications.index',
            compact('applications')
        );
    }

    /**
     * Cancel user's application.
     */
    public function cancelApplication($id)
    {
        $application = JobApplication::findOrFail($id);

        // Make sure the application belongs to the current user
        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        // Cancel application
        $application->status = 'Canceled';
        $application->save();

        return redirect()
            ->route('applications.index')
            ->with(
                'success',
                'Application cancelled successfully.'
            );
    }
}