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

        $validated = $request->validate([
            'sender_email' => 'required|email',
            'sender_name'  => 'required|string',
            'subject'      => 'required|string',
            'content'      => 'required|string',
        ]);

        $data = [
            'to'           => 'agm1984@gmail.com',
            'sender_email' => $validated['sender_email'],
            'sender_name'  => $validated['sender_name'],
            'subject'      => $validated['subject'],
            'content'      => $validated['content']
        ];

        try {
            Mail::send('contact.mail', $data, function($message) use ($data) {
                $message->to($data['to'])
                        ->subject('Contact form submission: ' . $data['subject']);

                $message->from('no-reply@adammackintosh.net', 'Adam Mackintosh');

                $message->replyTo($data['sender_email'], $data['sender_name']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully.',
            ]);

        } catch (\Exception $e) {
            \Log::error('Mail Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
