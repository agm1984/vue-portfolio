<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required|in:web',
        ];
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.email' => 'Your email must at least be legit.',
            'email.required' => 'Your email or password is incorrect.',
            'password.required' => 'Your email or password is incorrect.',
            'device_name.required' => 'You may need to refresh the page.',
            'device_name.in' => 'Your device is invalid. Please contact support.',
        ];
    }
}
