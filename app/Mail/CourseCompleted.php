<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CourseCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $employeeName,
        public string $courseName,
        public string $completedAt,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Course completed: :course', ['course' => $this->courseName]),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.course-completed',
            with: [
                'employeeName' => $this->employeeName,
                'courseName' => $this->courseName,
                'completedAt' => $this->completedAt,
            ],
        );
    }
}
