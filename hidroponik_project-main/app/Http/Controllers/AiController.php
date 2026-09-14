<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\AiPrediction;

class AiController extends Controller
{
    public function index()
    {
        $predictions = AiPrediction::orderBy('created_at', 'desc')->get();

        $result = session('result');

        return view('ai', compact('predictions', 'result'));
    }

    public function predict(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $aiServiceUrl = config(
            'services.ai_service.url',
            'http://127.0.0.1:8000'
        );

        $file = $request->file('file');

        try {

            // SEND IMAGE TO PYTHON AI

            $response = Http::timeout(30)
                ->attach(
                    'file',
                    file_get_contents($file->getRealPath()),
                    $file->getClientOriginalName()
                )
                ->post("{$aiServiceUrl}/predict");


            // CHECK AI RESPONSE

            if (!$response->successful()) {

                Log::error('AI service returned an error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return back()->with(
                    'error',
                    'AI service failed to process the image. Please try again.'
                );
            }


            // GET AI RESULT

            $data = $response->json();

            $result = [
                'prediction' => $data['disease'] ?? 'Unknown',
                'confidence' => $data['confidence'] ?? 0,
                'filename'   => $file->getClientOriginalName(),
            ];


            // SAVE RESULT TO DATABASE

            AiPrediction::create([
                'filename'   => $result['filename'],
                'prediction' => $result['prediction'],
                'confidence' => $result['confidence'],
                'model'      => 'EfficientNet-B0',
            ]);


            // REDIRECT TO /ai

            return redirect()
                ->route('ai.index')
                ->with('result', $result);


        } catch (\Illuminate\Http\Client\ConnectionException $e) {

            Log::error('Cannot connect to AI service', [
                'error' => $e->getMessage()
            ]);

            return back()->with(
                'error',
                'Cannot reach the AI service. Make sure it is running.'
            );


        } catch (\Exception $e) {

            Log::error('Unexpected error during disease analysis', [
                'error' => $e->getMessage()
            ]);

            return back()->with(
                'error',
                'An unexpected error occurred.'
            );
        }
    }
}