<?php

namespace App\Http\Requests;

use App\Rules\ValidActorDescription;
use Illuminate\Foundation\Http\FormRequest;

class StoreActorRequest extends FormRequest
{
    private ?ValidActorDescription $validActorRule = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $this->validActorRule = app(ValidActorDescription::class);

        return [
            'email' => ['required', 'email', 'unique:actors,email'],
            'description' => ['required', 'string', 'unique:actors,description', $this->validActorRule],
        ];
    }

    /**
     * Get the extracted actor data from AI.
     *
     * @return array<string, mixed>
     */
    public function getExtractedActorData(): array
    {
        return $this->validActorRule?->getExtractedData() ?? [];
    }
}
