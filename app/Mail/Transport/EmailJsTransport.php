<?php

namespace App\Mail\Transport;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Email;

/**
 * Sends mail through the EmailJS REST API instead of SMTP.
 *
 * EmailJS templates work with named placeholders, not arbitrary HTML, so the
 * EmailJS template configured via EMAILJS_TEMPLATE_ID must be a generic
 * relay with exactly these four variables: to_email, cc_email, subject,
 * html_body (inserted as {{{html_body}}} so the HTML is not escaped).
 */
class EmailJsTransport extends AbstractTransport
{
    private const API_URL = 'https://api.emailjs.com/api/v1.0/email/send';

    public function __construct(
        private readonly string $serviceId,
        private readonly string $templateId,
        private readonly string $publicKey,
        private readonly string $privateKey,
    ) {
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        $email = $message->getOriginalMessage();

        if (! $email instanceof Email) {
            throw new RuntimeException('EmailJsTransport only supports Symfony\Component\Mime\Email messages.');
        }

        $subject = (string) $email->getSubject();
        $htmlBody = $email->getHtmlBody() ?: $email->getTextBody() ?: '';
        $toAddresses = $this->stringifyAddresses($email->getTo());
        $ccAddresses = $this->stringifyAddresses($email->getCc());
        $bccAddresses = $this->stringifyAddresses($email->getBcc());

        $this->deliver($toAddresses, $ccAddresses, $subject, $htmlBody);

        // EmailJS has no dedicated Bcc field, so each bcc recipient gets an
        // individual copy instead of being folded into cc (which would leak
        // their address to the primary recipients).
        foreach ($bccAddresses as $bccAddress) {
            $this->deliver([$bccAddress], [], $subject, $htmlBody);
        }
    }

    /**
     * @param  string[]  $to
     * @param  string[]  $cc
     */
    private function deliver(array $to, array $cc, string $subject, string $htmlBody): void
    {
        if (empty($to)) {
            return;
        }

        $response = Http::asJson()->post(self::API_URL, [
            'service_id' => $this->serviceId,
            'template_id' => $this->templateId,
            'user_id' => $this->publicKey,
            'accessToken' => $this->privateKey,
            'template_params' => [
                'to_email' => implode(',', $to),
                'cc_email' => implode(',', $cc),
                'subject' => $subject,
                'html_body' => $htmlBody,
            ],
        ]);

        if ($response->failed()) {
            Log::error('EmailJS delivery failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'to' => $to,
            ]);

            throw new RuntimeException("EmailJS API error ({$response->status()}): {$response->body()}");
        }
    }

    public function __toString(): string
    {
        return 'emailjs://'.$this->serviceId;
    }
}
