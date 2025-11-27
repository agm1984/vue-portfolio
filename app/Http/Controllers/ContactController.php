<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Example;
use App\Models\ExampleImage;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        \Log::debug($request->all());

        // 1. Validation (Optional but recommended to prevent crashing the view)
        $validated = $request->validate([
            'sender_email' => 'required|email',
            'sender_name'  => 'required|string',
            'subject'      => 'required|string',
            'content'      => 'required|string',
        ]);

        $data = [
            'to' => 'adam@adammackintosh.net',
            // Pass validated data to avoid accessing nulls
            'sender_email' => $validated['sender_email'],
            'sender_name'  => $validated['sender_name'],
            'subject'      => $validated['subject'],
            'content'      => $validated['content']
        ];

        try {
            // 2. Wrap in Try/Catch to see the real error
            Mail::send('contact.mail', $data, function($message) use ($data) {
                $message->to($data['to'])
                        ->subject('Contact form submission: ' . $data['subject']);

                // FROM: Must be your verified Brevo/Domain email
                $message->from('no-reply@adammackintosh.net', 'Website Robot');

                // REPLY-TO: Crucial! Allows you to hit "Reply" and email the user.
                $message->replyTo($data['sender_email'], $data['sender_name']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully.',
            ]);

        } catch (\Exception $e) {
            // 3. Log the actual error so you can read it in storage/logs/laravel.log
            \Log::error('Mail Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
