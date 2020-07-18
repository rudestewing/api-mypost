<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,'.request()->user()->id,
            'name' => 'required|string',
            'password' => 'nullable|string|min:6|max:18|confirmed',
            'old_password' => 'required_with:password|string',
            'avatar_file' => 'nullable|string|file_exists_check',
            'id_card_file' => 'nullable|string|file_exists_check',
        ];
    }
}
