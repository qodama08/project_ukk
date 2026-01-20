<?php

namespace App\Http\Controllers;

use App\Services\GroqAiService;
use Illuminate\Http\Request;

class BkAiController extends Controller
{
    protected $groqAi;

    public function __construct(GroqAiService $groqAi)
    {
        $this->groqAi = $groqAi;
    }

    public function index()
    {
        return view('bk_ai.chat');
    }

    public function chat(Request $request)
    {
        \Log::info('BK AI Chat request received', ['user' => auth()->user()?->id, 'message' => substr($request->message ?? '', 0, 50)]);
        
        $request->validate([
            'message' => 'required|string|max:2000'
        ]);

        try {
            \Log::info('Calling GroqAiService->chat()');
            $response = $this->groqAi->chat($request->message);
            \Log::info('GroqAiService returned', ['response_length' => strlen($response)]);
            
            return response()->json([
                'status' => 'success',
                'message' => $request->message,
                'response' => $response
            ]);
        } catch (\Exception $e) {
            \Log::error('BK AI Chat Error', ['error' => $e->getMessage(), 'line' => $e->getLine()]);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
