<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sender_email' => ['required', 'email'],
            'sender_name'  => ['required', 'string', 'max:255'],
            'subject'      => ['required', 'string', 'max:255'],
            'content'      => ['required', 'string'],
        ];
    }
}
