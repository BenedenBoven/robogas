<?php declare(strict_types=1);

namespace App\Support\Services;

use BenedenBoven\Atom\Modules\Mail\Contracts\MailInterface;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailer;

final class SendMail {

    public function __construct(
        private Mailer        $mailer,
        private MailInterface $mailRepository
    ) {}

    public function execute(Mailable $mailable, string $to): void {

        $this->mailRepository->create([
            'from_name'  => $mailable->post['name'],
            'from_email' => $mailable->post['email'],
            'subject'    => $mailable->customSubject,
            'body'       => $mailable->render(),
            'read'       => 0
        ]);

        $this->mailer->to($to)->send($mailable);
    }
}