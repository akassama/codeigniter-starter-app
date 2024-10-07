<?php

declare(strict_types=1);

namespace App\Services;

use \Mailjet\Resources;
use \Mailjet\Client;

/**
 * The EmailService class handles sending different types of emails using Mailjet.
 */
final class EmailService
{
    /**
     * @property Client $mailjet The Mailjet client instance for sending emails.
     */
    private Client $mailjet;

    /**
     * Constructs the EmailService and initializes the Mailjet client using configuration.
     */
    public function __construct()
    {
        //get email config
        $config = config('Email');
        $this->mailjet = new Client($config->mailjetApiKey, $config->mailjetApiSecret, true, ['version' => 'v3.1']);
    }

    /**
     * Sends an email using the provided details.
     *
     * @param string $to The recipient's email address.
     * @param string $subject The subject of the email.
     * @param string $body The content of the email.
     * @param string $from The sender's email address. Defaults to 'example@mail.com'.
     * @return bool Returns true if the email was successfully sent, false otherwise.
     */
    public function sendEmail(string $to, string $subject, string $body, string $from = 'example@mail.com'): bool
    {
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $from,
                        'Name' => "Your Name"
                    ],
                    'To' => [
                        [
                            'Email' => $to
                        ]
                    ],
                    'Subject' => $subject,
                    'TextPart' => $body,
                    'HTMLPart' => $body
                ]
            ]
        ];

        $response = $this->mailjet->post(Resources::$Email, ['body' => $body]);

        return $response->success();
    }

    /**
     * Sends a password recovery email in HTML format.
     *
     * @param string $toEmail The recipient's email address.
     * @param string $toName The recipient's name.
     * @param string $subject The subject of the email.
     * @param array $templateData The data used for the email template.
     * @param string $from The sender's email address. Defaults to 'example@mail.com'.
     * @return bool Returns true if the email was successfully sent, false otherwise.
     */
    public function sendPasswordRecoveryHtmlEmail(string $toEmail, string $toName, string $subject, array $templateData, string $from = 'example@mail.com'): bool
    {
        $htmlContent = $this->generateHtmlContent($templateData);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $from,
                        'Name' => $toName
                    ],
                    'To' => [
                        [
                            'Email' => $toEmail
                        ]
                    ],
                    'Subject' => $subject,
                    'HTMLPart' => $htmlContent,
                    'TextPart' => strip_tags($htmlContent) // Fallback plain text version
                ]
            ]
        ];

        $response = $this->mailjet->post(Resources::$Email, ['body' => $body]);

        return $response->success();
    }

    /**
     * Sends an HTML email using the provided template data.
     *
     * @param string $to The recipient's email address.
     * @param string $subject The subject of the email.
     * @param array $templateData The data used for the email template.
     * @param string $from The sender's email address. Defaults to 'example@mail.com'.
     * @return bool Returns true if the email was successfully sent, false otherwise.
     */
    public function sendHtmlEmail(string $to, string $subject, array $templateData, string $from = 'example@mail.com'): bool
    {
        $htmlContent = $this->generateHtmlContent($templateData);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $from,
                        'Name' => "Your Name"
                    ],
                    'To' => [
                        [
                            'Email' => $to
                        ]
                    ],
                    'Subject' => $subject,
                    'HTMLPart' => $htmlContent,
                    'TextPart' => strip_tags($htmlContent) // Fallback plain text version
                ]
            ]
        ];

        $response = $this->mailjet->post(Resources::$Email, ['body' => $body]);

        return $response->success();
    }

    /**
     * Generates HTML content by replacing placeholders in the template with actual data.
     *
     * @param array $data The data used to replace placeholders in the HTML template.
     * @return string The generated HTML content.
     */
    private function generateHtmlContent(array $data): string
    {
        // Load the HTML template
        $template = file_get_contents(APPPATH . 'Views/back-end/emails/template.php');

        // Replace placeholders in the template with actual data
        $placeholders = [
            '{{SUBJECT}}' => $data['subject'] ?? '',
            '{{PREHEADER}}' => $data['preheader'] ?? '',
            '{{GREETING}}' => $data['greeting'] ?? 'Hi there',
            '{{MAIN_CONTENT}}' => $data['main_content'] ?? '',
            '{{CTA_TEXT}}' => $data['cta_text'] ?? 'Call To Action',
            '{{CTA_URL}}' => $data['cta_url'] ?? '#',
            '{{FOOTER_TEXT}}' => $data['footer_text'] ?? '',
            '{{COMPANY_ADDRESS}}' => $data['company_address'] ?? 'Company Inc, 7-11 Commercial Ct, Belfast BT1 2NB',
            '{{UNSUBSCRIBE_URL}}' => $data['unsubscribe_url'] ?? '#'
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $template);
    }
}