<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;

class ChatbotController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function query(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $data = $this->gemini->query($request->message);

        return response()->json($data);
    }
}
