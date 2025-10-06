@extends('layouts.welcome')

@section('title', 'Liên Hệ')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Liên Hệ Với Chúng Tôi</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('contact.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Họ và tên</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" name="phone" id="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Nội dung liên hệ</label>
            <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Gửi liên hệ</button>
    </form>
</div>
@endsection
