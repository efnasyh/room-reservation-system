<?php

namespace App\Mail;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $studentName;

    public function __construct(Event $event, $studentName)
    {
        $this->event = $event;
        $this->studentName = $studentName;
    }

    public function build()
    {
        return $this->subject('Event Registration Confirmation: ' . $this->event->program_name)
                    ->view('emails.event-notification')
                    ->with([
                        'event' => $this->event,
                        'studentName' => $this->studentName,
                    ]);
    }
    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Event Notification',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
