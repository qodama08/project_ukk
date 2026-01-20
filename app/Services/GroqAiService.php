<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqAiService
{
    protected $apiKey;
    protected $apiUrl;
    protected $model;

    public function __construct()
    {
        $this->apiKey = config('groq.api_key');
        $this->apiUrl = config('groq.api_url');
        $this->model = config('groq.model');
    }

    public function chat($message, $systemPrompt = null)
    {
        if (!$this->apiKey) {
            throw new \Exception('Groq API key tidak dikonfigurasi. Silakan periksa file .env');
        }

        $defaultSystem = 'Kamu adalah BK AI, asisten pendampingan bimbingan konseling yang membantu siswa dengan masalah akademik, emosional, dan pengembangan diri. Berikan saran yang konstruktif, empati, dan profesional.';
        
        $messages = [
            [
                'role' => 'system',
                'content' => $systemPrompt ?? $defaultSystem
            ],
            [
                'role' => 'user',
                'content' => $message
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])
            ->timeout(30)
            ->retry(1, 1000)
            ->post($this->apiUrl . '/chat/completions', [
                'model' => $this->model,
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 1024
            ]);

            Log::info('Groq API Response Status', ['status' => $response->status()]);

            if ($response->successful()) {
                $result = $response->json();
                Log::info('Groq API Response Body', ['result' => $result]);
                
                if (isset($result['choices'][0]['message']['content'])) {
                    $content = $result['choices'][0]['message']['content'];
                    Log::info('Groq API Success', ['content' => $content]);
                    return $content;
                }
                
                throw new \Exception('Format respons dari Groq API tidak sesuai. Received: ' . json_encode($result));
            }

            // Handle error response
            $errorBody = $response->body();
            $errorJson = $response->json();
            
            Log::error('Groq API Error', [
                'status' => $response->status(), 
                'body' => $errorBody,
                'json' => $errorJson,
                'url' => $this->apiUrl . '/chat/completions',
                'model' => $this->model
            ]);

            if ($response->status() === 401) {
                throw new \Exception('API Key tidak valid. Silakan periksa GROQ_API_KEY di file .env');
            }

            if ($response->status() === 429) {
                throw new \Exception('Terlalu banyak request. Silakan coba lagi dalam beberapa saat');
            }

            throw new \Exception('Error dari Groq API: ' . $response->status());
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Groq Connection Error', ['message' => $e->getMessage()]);
            throw new \Exception('Tidak bisa terhubung ke Groq AI. Periksa koneksi internet Anda');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('Groq Request Error', ['message' => $e->getMessage()]);
            throw new \Exception('Error saat mengirim request: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Groq Chat Error', ['message' => $e->getMessage()]);
            throw $e;
        }
    }
}
