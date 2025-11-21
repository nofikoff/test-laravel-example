<?php

namespace App\Services;

class ActorExtractionService
{
    public function extractActorData(string $description): array
    {
        $prompt = config('ai.actor_extraction_prompt');

        $client = \OpenAI::factory()
            ->withApiKey(config('openai.api_key'))
            ->make();

        $response = $client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $prompt,
                ],
                [
                    'role' => 'user',
                    'content' => $description,
                ],
            ],
            'response_format' => [
                'type' => 'json_object',
            ],
        ]);

        $content = $response->choices[0]->message->content;
        $data = json_decode($content, true);

        if (!isset($data['firstName']) || !isset($data['lastName']) || !isset($data['address'])) {
            throw new \Exception(__('messages.missing_required_fields'));
        }

        return [
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'address' => $data['address'],
            'height' => $data['height'] ?? null,
            'weight' => $data['weight'] ?? null,
            'gender' => $data['gender'] ?? null,
            'age' => $data['age'] ?? null,
        ];
    }
}
