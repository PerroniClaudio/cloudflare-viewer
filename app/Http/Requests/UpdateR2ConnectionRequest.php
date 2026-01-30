<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateR2ConnectionRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'access_key_id' => ['required', 'string', 'max:255'],
            'secret_access_key' => ['required', 'string', 'max:255'],
            'endpoint' => ['required', 'url', 'max:255'],
            'bucket' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Il nome connessione è obbligatorio.',
            'color.required' => 'Il colore è obbligatorio.',
            'color.regex' => 'Il colore deve essere un valore hex valido (es. #ff00aa).',
            'access_key_id.required' => 'L’access key id è obbligatorio.',
            'secret_access_key.required' => 'La secret access key è obbligatoria.',
            'endpoint.required' => 'L’endpoint è obbligatorio.',
            'endpoint.url' => 'L’endpoint deve essere un URL valido.',
            'bucket.required' => 'Il nome del bucket è obbligatorio.',
        ];
    }
}
