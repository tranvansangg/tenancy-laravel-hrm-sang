<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApplication;

class JobApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::with('job')->latest()->paginate(10);
        return view('admin.applications.index', compact('applications'));
    }

    public function show(JobApplication $application)
    {
        return view('admin.applications.show', compact('application'));
    }

    public function destroy(JobApplication $application)
    {
        // Xóa file CV nếu có
        if($application->cv_file && \Storage::disk('public')->exists($application->cv_file)) {
            \Storage::disk('public')->delete($application->cv_file);
        }

        $application->forceDelete();

        return redirect()->route('admin.applications.index')->with('success', 'Xóa CV thành công!');
    }
}
