<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    /**
     * Show the AI detection page.
     */
    public function index()
    {
        return view('ai');
    }

    /**
     * Receive an uploaded image, forward it to the Python AI service,
     * and re-render the AI page with the prediction result.
     */
    public function predict(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png|max:10240', // max 10MB
        ]);

        $aiServiceUrl = config('services.ai_service.url', 'http://127.0.0.1:8000');

        $file = $request->file('file');

        try {
            $response = Http::timeout(30)
                ->attach(
                    'file',
                    file_get_contents($file->getRealPath()),
                    $file->getClientOriginalName()
                )
                ->post("{$aiServiceUrl}/predict");

            if (! $response->successful()) {
                Log::error('AI service returned an error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return back()->with('error', 'AI service failed to process the image. Please try again.');
            }

            $data = $response->json();

            // Python service mengirim "disease" & "confidence"
            $result = [
                'prediction' => $data['disease'] ?? 'Unknown',
                'confidence' => $data['confidence'] ?? 0,
                'filename'   => $file->getClientOriginalName(),
            ];

            return view('ai', compact('result'));

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Cannot connect to AI service', ['error' => $e->getMessage()]);

            return back()->with('error', 'Cannot reach the AI service. Make sure it is running.');

        } catch (\Exception $e) {
            Log::error('Unexpected error during disease analysis', ['error' => $e->getMessage()]);

            return back()->with('error', 'An unexpected error occurred.');
        }
    }
}