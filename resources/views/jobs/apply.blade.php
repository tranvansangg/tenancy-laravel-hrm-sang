@extends('layouts.welcome')

@section('title', 'Nộp CV')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Nộp CV cho: {{ $job->title }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('jobs.submitApplication', $job->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="applicant_name" class="form-label">Họ và tên</label>
            <input type="text" name="applicant_name" id="applicant_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email liên hệ</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" name="phone" id="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label for="cv_file" class="form-label">CV (PDF/DOC)</label>
            <input type="file" name="cv_file" id="cv_file" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="cover_letter" class="form-label">Thư xin việc</label>
            <textarea name="cover_letter" id="cover_letter" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Gửi CV</button>
    </form>
</div>
@endsection
