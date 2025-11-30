<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Example;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PublicApiTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_can_list_public_categories()
    {
        $this->getJson(route('public.categories.list'))
            ->assertStatus(200);
    }

    #[Test]
    public function it_can_list_public_examples()
    {
        $this->getJson(route('public.examples.list'))
            ->assertStatus(200);
    }

    #[Test]
    public function it_can_send_contact_form()
    {
        Mail::fake();

        $this->postJson(route('public.contact.send'), [
            'sender_name' => 'John Doe',
            'sender_email' => 'john@example.com',
            'subject' => 'Test Subject',
            'content' => 'This is a test message from the contact form.',
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Your message has been sent successfully.',
            ]);
    }

    #[Test]
    public function it_validates_contact_form_input()
    {
        $this->postJson(route('public.contact.send'), [
            'sender_name' => '',
            'sender_email' => 'invalid-email',
            'subject' => '',
            'content' => '',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['sender_name', 'sender_email', 'subject', 'content']);
    }
}
