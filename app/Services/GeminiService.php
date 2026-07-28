<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected ?string $apiKey;
    protected string $model;
    protected int $timeout;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->model = config('services.gemini.model', env('GEMINI_MODEL', 'gemini-flash-latest'));
        $this->timeout = config('services.gemini.timeout', env('GEMINI_TIMEOUT', 20));
    }

    /**
     * Check whether the Gemini API is configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * Generate a response from Google Gemini.
     */
    public function generateResponse(string $message, ?User $user = null): ?string
    {
        if (!$this->isConfigured()) {
            Log::warning('GeminiService is not configured: missing GEMINI_API_KEY.');
            return null;
        }

        $systemPrompt = 'You are SkillUp, a career guidance assistant focused on TESDA programs in the Philippines. Provide simple, friendly career advice, course recommendations, and practical guidance.';
        $profileContext = $this->buildProfileContext($user);

        $contents = [
            [
                'parts' => [
                    ['text' => $systemPrompt],
                    ['text' => $profileContext],
                    ['text' => $message],
                ],
            ],
        ];

        try {
            Log::info('GeminiService sending request.', [
                'model' => $this->model,
                'timeout' => $this->timeout,
                'profileContext' => $profileContext,
            ]);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-goog-api-key' => $this->apiKey,
            ])->timeout($this->timeout)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent",
                [
                    'contents' => $contents,
                    'temperature' => 0.75,
                    'max_output_tokens' => 512,
                ]
            );

            if (! $response->successful()) {
                Log::warning('GeminiService returned non-success status.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'model' => $this->model,
                ]);
                return null;
            }

            $text = $this->extractText($response->json());
            if ($text) {
                Log::info('GeminiService received response text.', [
                    'model' => $this->model,
                    'length' => strlen($text),
                ]);
            } else {
                Log::warning('GeminiService did not find text in response.', [
                    'response_body' => $response->body(),
                ]);
            }

            return $text;
        } catch (\Throwable $exception) {
            Log::error('GeminiService request failed.', [
                'message' => $exception->getMessage(),
                'model' => $this->model,
                'timeout' => $this->timeout,
            ]);
            return null;
        }
    }

    protected function buildProfileContext(?User $user): string
    {
        if (! $user) {
            return 'User Profile: Not logged in.';
        }

        $profile = $user->profile;
        if (! $profile) {
            return 'User Profile: No additional profile details available.';
        }

        return sprintf(
            'User Profile: Interest = %s, Skill Level = %s.',
            $profile->interest ?? 'Not specified',
            $profile->skill_level ?? 'Not specified'
        );
    }

    protected function extractText(array $response): ?string
    {
        if (isset($response['candidates'][0]['content'][0]['text'])) {
            return trim($response['candidates'][0]['content'][0]['text']);
        }

        if (isset($response['candidates'][0]['output'][0]['content'][0]['text'])) {
            return trim($response['candidates'][0]['output'][0]['content'][0]['text']);
        }

        if (isset($response['candidates'][0]['output'])) {
            foreach ($response['candidates'][0]['output'] as $outputBlock) {
                if (! empty($outputBlock['content']) && is_array($outputBlock['content'])) {
                    foreach ($outputBlock['content'] as $item) {
                        if (isset($item['text'])) {
                            return trim($item['text']);
                        }
                    }
                }
            }
        }

        if (isset($response['candidates'][0]['content']) && is_array($response['candidates'][0]['content'])) {
            $texts = array_filter(array_column($response['candidates'][0]['content'], 'text'));
            if (! empty($texts)) {
                return trim(implode(' ', $texts));
            }
        }

        return null;
    }
}
