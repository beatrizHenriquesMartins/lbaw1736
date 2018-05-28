<?php

namespace App;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;


    protected $name;
    protected $email;
    protected $phone;
    protected $msg;
    protected $subjecta;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $phone, $msg, $subject)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->msg = $msg;
        $this->subjecta = $subject;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

      return $this->from('amazonas@gmail.com')
                  ->subject($this->subjecta)
                  ->view('emails.sendContactUs')
                  ->with(
                    [
                          'name' => $this->name,
                          'phone' => $this->phone,
                          'msg' => $this->msg,
                          'email' => $this->email,
                    ]);
    }
}
