<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactReplyMail;
use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{
    // Hiển thị danh sách liên hệ
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    // Xóa liên hệ
    public function destroy(Contact $contact)
    {
        $contact->forceDelete();
        return redirect()->route('admin.contacts.index')
                         ->with('success', 'Xóa liên hệ thành công!');
    }
    
// Form phản hồi
public function reply(Contact $contact)
{
    return view('admin.contacts.reply', compact('contact'));
}

// Xử lý gửi phản hồi
public function sendReply(Request $request, Contact $contact)
{
    $request->validate([
        'reply' => 'required|string'
    ]);

    $contact->reply = $request->reply;
    $contact->save();

    // Gửi mail phản hồi
    Mail::to($contact->email)->send(new ContactReplyMail($contact));

    return redirect()->route('admin.contacts.index')->with('success', 'Đã gửi phản hồi thành công!');
}
}
