<?php

namespace App\Http\Requests\Storage;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    protected $allowedTypes = [
        'image' => [
            'max' => 1500,
            'allowedMimes' => ['jpeg', 'jpg', 'png'],
        ],
        'document' => [
            'max' => 1500,
            'allowedMimes' => ['pdf'],
        ],
        'audio' => [
            'max' => 1500,
            'allowedMimes' => ['mp3', 'ogg'],
        ],
    ];


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
        $allowedTypes = implode(',', array_keys($this->allowedTypes));

        $type = $this->type;

        $allowedMimes = implode(',', $this->allowedTypes[$type]['allowedMimes']);
        $allowedMaxSize = $this->allowedTypes[$type]['max'];

        return [
            'type' => "required|string|in:{$allowedTypes}",
            'file' => "required|max:{$allowedMaxSize}|mimes:{$allowedMimes}",
        ];
    }
}
