<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class OpenAIBaseService
{
    protected string $model;

    public function __construct(string $model = 'gpt-3.5-turbo')
    {
        $this->model = $model;
    }

    /**
     * Send a chat message to OpenAI and get the response.
     *
     * @param array $messages
     * @param array $options
     * @return string
     */
    public function chat(array $messages, array $options = []): string
    {
        $payload = array_merge([
            'model' => $this->model,
            'messages' => $messages,
        ], $options);

        $response = OpenAI::chat()->create($payload);

        return $response['choices'][0]['message']['content'] ?? '';
    }
}
