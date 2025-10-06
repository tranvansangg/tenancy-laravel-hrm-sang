<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::latest()->paginate(10);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'nullable|string|max:255',
        ]);

        Job::create($request->all());

        return redirect()->route('admin.jobs.index')->with('success', 'Tạo việc làm thành công!');
    }

    public function edit(Job $job)
    {
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'nullable|string|max:255',
        ]);

        $job->update($request->all());

        return redirect()->route('admin.jobs.index')->with('success', 'Cập nhật việc làm thành công!');
    }

    public function destroy(Job $job)
    {
        $job->forceDelete();
        return redirect()->route('admin.jobs.index')->with('success', 'Xóa việc làm thành công!');
    }
}
