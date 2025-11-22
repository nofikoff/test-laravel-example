<?php

namespace App\Http\Requests;

use App\Rules\ValidActorDescription;
use Illuminate\Foundation\Http\FormRequest;

class StoreActorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:actors,email'],
            'description' => ['required', 'string', 'unique:actors,description', app(ValidActorDescription::class)],
        ];
    }
}
