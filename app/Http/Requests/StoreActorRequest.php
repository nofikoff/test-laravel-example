<?php

namespace App\Http\Requests;

use App\Rules\ValidActorDescription;
use Illuminate\Foundation\Http\FormRequest;

class StoreActorRequest extends FormRequest
{
    public function __construct(
        private readonly ValidActorDescription $validActorRule
    ) {
        parent::__construct();
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get validation rules.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:actors,email'],
            'description' => ['required', 'string', 'unique:actors,description', $this->validActorRule],
        ];
    }
}
