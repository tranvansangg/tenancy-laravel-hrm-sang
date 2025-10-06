@component('mail::message')
# Xin chào {{ $contact->name }},

Cảm ơn bạn đã liên hệ với chúng tôi.

**Nội dung bạn gửi:**  
{{ $contact->message }}

**Phản hồi từ chúng tôi:**  
{{ $contact->reply }}

Cảm ơn,<br>
{{ config('app.name') }}
@endcomponent
