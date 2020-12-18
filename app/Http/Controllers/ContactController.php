<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Example;
use App\ExampleImage;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        \Log::debug($request->all());
        $submission = [
            'to' => 'adam@adammackintosh.net',
            'sender_email' => $request->input('sender_email'),
            'sender_name' => $request->input('sender_name'),
            'subject' => $request->input('subject'),
            'content' => $request->input('content')
        ];

        Mail::send('contact.mail', $submission, function($message) use ($submission) {
            $message->to($submission['to'])
                ->subject('Contact form submission');

            $message->from('adam@adammackintosh.net','Adam Mackintosh');
        });

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully.'
        ]);
    }

}
