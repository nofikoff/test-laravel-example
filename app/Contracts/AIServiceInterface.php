<?php

namespace App\Contracts;

/**
 * Interface for AI services that extract structured data from text.
 *
 * This interface allows for different AI provider implementations
 * (OpenAI, Claude, Gemini, etc.) to be used interchangeably.
 */
interface AIServiceInterface
{
    /**
     * Extract structured data from text using AI.
     *
     * @param string $systemPrompt The system prompt to guide extraction
     * @param string $userContent The user content to extract data from
     * @return array<string, mixed> The extracted data as associative array
     * @throws \Exception If extraction fails
     */
    public function extractStructuredData(string $systemPrompt, string $userContent): array;
}
