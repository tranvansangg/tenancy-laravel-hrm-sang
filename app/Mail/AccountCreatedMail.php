<?php

namespace App\Mail;

use App\Models\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash;

class AccountCreatedMail extends Mailable
{
    use Queueable, SerializesModels;
       public $user;      // <<< public property để truyền user
         public $password; // <<< public property để truyền mật khẩu


    /**
     * Create a new message instance.
     */
    public function __construct(Account $user, $password)
    {
        $this->user =$user;
        $this->password = $password;
    }
    public function build()
    {
        return $this->subject('thông tin tài khoản của bạn')
                    ->view('emails.account_created');
    
    }

}
