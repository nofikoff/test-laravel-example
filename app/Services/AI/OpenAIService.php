<?php

namespace App\Services\AI;

use App\Contracts\AIServiceInterface;
use App\Exceptions\AIServiceException;
use Illuminate\Support\Facades\Log;
use OpenAI\Client;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;

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
     * @throws AIServiceException
     */
    public function extractStructuredData(string $systemPrompt, string $userContent): array
    {
        try {
            Log::info('OpenAI API request started', [
                'model' => $this->model,
                'user_content_length' => strlen($userContent),
            ]);

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

            $content = $response->choices[0]->message->content ?? null;

            if ($content === null) {
                Log::error('OpenAI API returned null content');
                throw AIServiceException::invalidResponse();
            }

            $decoded = json_decode($content, true);

            if ($decoded === null) {
                Log::error('Failed to decode OpenAI response', ['content' => $content]);
                throw AIServiceException::invalidResponse();
            }

            Log::info('OpenAI API request completed successfully');

            return $decoded;
        } catch (ErrorException $e) {
            Log::error('OpenAI API error', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            throw AIServiceException::apiError($e->getMessage());
        } catch (TransporterException $e) {
            Log::error('OpenAI API transport error', [
                'message' => $e->getMessage(),
            ]);

            throw AIServiceException::timeout();
        } catch (AIServiceException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Unexpected error in OpenAI service', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw new AIServiceException(
                "Unexpected error: {$e->getMessage()}",
                previous: $e
            );
        }
    }
}
