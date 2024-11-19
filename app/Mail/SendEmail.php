<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class SendEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public function __construct(array $data)
    {
    $this->data = $data;
    }
    public function build()
    {
    return $this->subject($this->data['subject'])
    ->view('emails.sendemail');
    }
}
