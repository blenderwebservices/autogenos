<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Intervention;
use App\Models\ErrorCodeLibrary;
use Illuminate\Support\Facades\Http;

class AiDiagnosticController extends Controller
{
    public function generate(Request $request, $id)
    {
        $intervention = Intervention::findOrFail($id);

        if ($request->user()->role === 'technician' && $intervention->technician_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $symptoms = $intervention->symptoms ?: 'No especificados';
        $errorCodes = $intervention->error_codes ?? [];

        $context = '';
        if (count($errorCodes) > 0) {
            $codes = ErrorCodeLibrary::whereIn('code', $errorCodes)->get();
            foreach ($codes as $c) {
                $context .= "- Código {$c->code}: {$c->description}. Causas: " . json_encode($c->possible_causes) . ". Acciones: " . json_encode($c->recommended_actions) . "\n";
            }
        }

        $prompt = "Eres un sistema experto en generadores eléctricos.\nSíntomas reportados: {$symptoms}.\nCódigos de error: " . implode(', ', $errorCodes) . ".\nContexto técnico: {$context}\nDevuelve EXCLUSIVAMENTE un JSON válido con esta estructura:\n{\n  \"ai_suggestions\": {\n    \"Motor\": \"Revisar...\",\n    \"Sistema B\": \"Acción...\"\n  },\n  \"ai_confidence\": 90,\n  \"recommended_action\": \"inspect\"\n}\n(recommended_action debe ser EXACTAMENTE una de estas opciones: inspect, repair, replace, o rebuild)";

        $apiKey = env('GEMINI_API_KEY');
        $model = env('GEMINI_MODEL', 'gemini-3.5-flash-lite');

        if (!$apiKey) {
            return response()->json(['message' => 'API Key no configurada'], 500);
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                'contents' => [['parts' => [['text' => $prompt]]]],
                'generationConfig' => ['responseMimeType' => 'application/json']
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $jsonText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
                $result = json_decode($jsonText, true);

                if ($result) {
                    $intervention->update([
                        'ai_suggestions' => $result['ai_suggestions'] ?? [],
                        'ai_confidence' => $result['ai_confidence'] ?? null,
                        'recommended_action' => $result['recommended_action'] ?? null,
                    ]);

                    return response()->json([
                        'message' => 'Diagnóstico generado exitosamente',
                        'data' => $intervention->fresh()
                    ]);
                }
            }
            return response()->json(['message' => 'Error al parsear respuesta de Gemini'], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
