<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GroqAiService;

class TestGroqApi extends Command
{
    protected $signature = 'groq:test';
    protected $description = 'Test Groq API connection';

    public function handle()
    {
        $this->info('Testing Groq API Connection...');
        
        $apiKey = env('GROQ_API_KEY');
        
        if (!$apiKey) {
            $this->error('❌ GROQ_API_KEY tidak ditemukan di .env');
            return 1;
        }

        $this->info('✓ API Key ditemukan: ' . substr($apiKey, 0, 10) . '...');
        $this->info('API URL: ' . config('groq.api_url'));
        $this->info('Model: ' . config('groq.model'));

        try {
            $groqService = new GroqAiService();
            $response = $groqService->chat('Siapa kamu?');
            
            $this->info('✓ Koneksi Groq API berhasil!');
            $this->line('Response: ' . $response);
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            
            // Show log file untuk debug
            $this->line('');
            $this->info('Cek file: storage/logs/laravel.log untuk detail error');
            
            return 1;
        }
    }
}
