<?php

namespace App\Mail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\File;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    private $user;
    private $file;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, File $file)
    {
        $this->user = $user;
        $this->file = $file;
        //dd($this->user);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $this->subject('Relatório Aplicativo');
        $this->to($this->user->email, $this->user->name);


        return $this->markdown('emails.index', [
            'user' => $this->user,
            'file' => $this->file
        ]);
    }
}
