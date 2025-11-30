<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(ContactRequest $request)
    {
        Log::debug($request->all());

        $validatedData = $request->validated();

        try {
            Mail::to(config('mail.admin_address'))
                ->send(new ContactFormMail($validatedData));

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Mail Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Please try again later.',
            ], 500);
        }
    }
}
