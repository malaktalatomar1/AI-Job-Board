<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;


class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('category')
            ->latest()
            ->get();

        return view('jobs.index', compact('jobs'));
    }

    public function show($id)
    {
        $job = Job::with('category')->findOrFail($id);

        return view('jobs.show', compact('job'));
    }

    public function apply(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $alreadyApplied = JobApplication::where('user_id', auth()->id())
            ->where('job_id', $job->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'You have already applied for this job.');
        }

        JobApplication::create([
            'user_id' => auth()->id(),
            'job_id' => $job->id,
            'status' => 'Pending',
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }

    public function myApplications()
{
    $applications = JobApplication::with('job.category')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('applications.index', compact('applications'));
}
public function cancelApplication($id)
{
    $application = \App\Models\JobApplication::findOrFail($id);

    // التأكد إن الـ application بتاعة المستخدم الحالي
    if ($application->user_id !== auth()->id()) {
        abort(403);
    }

    // إلغاء الطلب
    $application->status = 'Canceled';
    $application->save();

    return redirect()
        ->route('applications.index')
        ->with('success', 'Application cancelled successfully.');
}
}