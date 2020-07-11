<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewArrivals extends Mailable
{
    use Queueable, SerializesModels;

    protected $new_arrival;
    protected $user;

    public function __construct($user, $new_arrival)
    {
        $this->user = $user;
        $this->new_arrival = $new_arrival;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    logger($this->new_arrival->body);
        return $this->markdown('emails.newarrivals')
            ->subject($this->new_arrival->title)
            ->from('example@company.com', 'Example Company')
            ->with([
                'user'=> $this->user,
                'message' => json_decode($this->new_arrival->body),
            ]);
    }
}
