<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
  public function index()
    {
        // Lấy tất cả job, hoặc có thể phân trang
        $jobs = Job::latest()->paginate(10); 
        return view('jobs.index', compact('jobs'));
    }

    public function apply(Job $job)
    {
        return view('jobs.apply', compact('job'));
    }

    public function submitApplication(Request $request, Job $job)
    {
        $request->validate([
            'applicant_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'cv_file' => 'required|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string',
        ]);

        $path = $request->file('cv_file')->store('cvs', 'public');

        JobApplication::create([
            'job_id' => $job->id,
            'applicant_name' => $request->applicant_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cv_file' => $path,
            'cover_letter' => $request->cover_letter,
        ]);

        return redirect()->back()->with('success', 'Nộp CV thành công!');
    }
}
