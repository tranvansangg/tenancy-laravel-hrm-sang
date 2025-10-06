@extends('layouts.welcome')

@section('title', 'Tuyển dụng')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Cơ hội việc làm</h1>

    @forelse($jobs as $job)
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ $job->title }}</h5>
            <p class="card-text">{{ $job->description }}</p>
            <p><strong>Địa điểm:</strong> {{ $job->location }}</p>
            <a href="{{ route('jobs.apply', $job->id) }}" class="btn btn-primary">Nộp CV</a>
        </div>
    </div>
    @empty
        <p>Hiện chưa có công việc nào.</p>
    @endforelse

    {{ $jobs->links() }}
</div>
@endsection
