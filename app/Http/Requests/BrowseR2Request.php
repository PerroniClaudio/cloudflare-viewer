<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrowseR2Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'prefix' => ['nullable', 'string', 'max:1024'],
            'search' => ['nullable', 'string', 'max:255'],
            'token' => ['nullable', 'string', 'max:2048'],
            'sort' => ['nullable', 'in:name,size,modified'],
            'direction' => ['nullable', 'in:asc,desc'],
        ];
    }
}
