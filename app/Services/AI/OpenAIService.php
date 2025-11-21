<?php

namespace App\Services\AI;

use App\Contracts\AIServiceInterface;
use OpenAI\Client;

/**
 * OpenAI implementation of AI service.
 *
 * Uses OpenAI API to extract structured data from text using chat completions.
 */
class OpenAIService implements AIServiceInterface
{
    /** @var Client OpenAI API client instance */
    private Client $client;

    /**
     * Create a new OpenAI service instance.
     *
     * @param string $apiKey OpenAI API key for authentication
     * @param string $model Model to use for chat completions (default: gpt-4o-mini)
     */
    public function __construct(
        private readonly string $apiKey,
        private readonly string $model = 'gpt-4o-mini'
    ) {
        $this->client = \OpenAI::factory()
            ->withApiKey($this->apiKey)
            ->make();
    }

    /**
     * Extract structured data from text using OpenAI.
     *
     * @param string $systemPrompt The system prompt to guide extraction
     * @param string $userContent The user content to extract data from
     * @return array<string, mixed> The extracted data as associative array
     */
    public function extractStructuredData(string $systemPrompt, string $userContent): array
    {
        $response = $this->client->chat()->create([
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $systemPrompt,
                ],
                [
                    'role' => 'user',
                    'content' => $userContent,
                ],
            ],
            'response_format' => [
                'type' => 'json_object',
            ],
        ]);

        $content = $response->choices[0]->message->content;

        return json_decode($content, true);
    }
}
