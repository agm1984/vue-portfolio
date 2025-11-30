<?php

namespace Tests\Feature;

use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    #[Test]
    public function it_validates_required_fields(): void
    {
        $response = $this->postJson(route('public.contact.send'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'sender_email',
                'sender_name',
                'subject',
                'content',
            ]);
    }

    #[Test]
    public function it_validates_email_format(): void
    {
        $payload = [
            'sender_email' => 'not-an-email',
            'sender_name'  => 'John Doe',
            'subject'      => 'Hello',
            'content'      => 'World',
        ];

        $this->postJson(route('public.contact.send'), $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['sender_email']);
    }

    #[Test]
    public function it_sends_email_successfully(): void
    {
        Mail::fake();
        Config::set('mail.admin_address', 'admin@test.com');

        $payload = [
            'sender_email' => 'visitor@example.com',
            'sender_name'  => 'Visitor Name',
            'subject'      => 'Inquiry',
            'content'      => 'I love your site!',
        ];

        $response = $this->postJson(route('public.contact.send'), $payload);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Your message has been sent successfully.',
            ]);

        Mail::assertSent(ContactFormMail::class, function (ContactFormMail $mail) use ($payload) {
            return $mail->hasTo('admin@test.com') &&
                   $mail->data['sender_email'] === $payload['sender_email'] &&
                   $mail->data['subject'] === $payload['subject'];
        });
    }

    #[Test]
    public function it_handles_mailing_exceptions_gracefully(): void
    {
        Mail::shouldReceive('to')->andReturnSelf();
        Mail::shouldReceive('send')
            ->once()
            ->andThrow(new \Exception('SMTP Server Offline'));

        Log::spy();
        Config::set('mail.admin_address', 'admin@test.com');

        $payload = [
            'sender_email' => 'visitor@example.com',
            'sender_name'  => 'Visitor',
            'subject'      => 'Bug Report',
            'content'      => 'Something broke',
        ];

        $response = $this->postJson(route('public.contact.send'), $payload);

        $response->assertStatus(500)
            ->assertJson([
                'success' => false,
                'message' => 'Failed to send email. Please try again later.',
            ]);

        Log::shouldHaveReceived('error')
            ->once()
            ->withArgs(fn($msg) => str_contains($msg, 'Mail Error: SMTP Server Offline'));
    }
}
