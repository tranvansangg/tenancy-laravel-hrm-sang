@extends('admin.layouts.app')

@section('title', 'Phản hồi liên hệ')

@section('content')
<div class="container mt-4">
    <h1>Phản hồi liên hệ: {{ $contact->name }}</h1>

    <form action="{{ route('admin.contacts.sendReply', $contact->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nội dung liên hệ</label>
            <textarea class="form-control" rows="4" readonly>{{ $contact->message }}</textarea>
        </div>

        <div class="mb-3">
            <label>Phản hồi</label>
            <textarea name="reply" class="form-control" rows="4" required>{{ $contact->reply }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Gửi phản hồi</button>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
 <!-- #region -->