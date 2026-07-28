<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Intervention;

class InterventionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $query = Intervention::with(['equipment', 'technician', 'supervisor']);
        
        if ($user->role === 'technician') {
            $query->where('technician_id', $user->id);
        } elseif ($user->role === 'client') {
            $query->whereHas('equipment', function ($q) use ($user) {
                $q->where('company_id', $user->company_id);
            });
        }
        
        return response()->json($query->latest()->paginate(15));
    }

    public function show(Request $request, $id)
    {
        $intervention = Intervention::with(['equipment', 'checklists', 'spareParts'])->findOrFail($id);
        
        // Autorización simple
        if ($request->user()->role === 'technician' && $intervention->technician_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        
        return response()->json($intervention);
    }

    public function update(Request $request, $id)
    {
        $intervention = Intervention::findOrFail($id);
        
        if ($request->user()->role === 'technician' && $intervention->technician_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        
        $validated = $request->validate([
            'status' => 'sometimes|string',
            'symptoms' => 'sometimes|string|nullable',
            'error_codes' => 'sometimes|array',
            'diagnostic_summary' => 'sometimes|string|nullable',
            'preliminary_diagnosis' => 'sometimes|string|nullable',
            'ai_suggestions' => 'sometimes|array|nullable',
            'ai_confidence' => 'sometimes|numeric|nullable',
            'recommended_action' => 'sometimes|string|nullable',
        ]);
        
        $intervention->update($validated);
        
        return response()->json($intervention);
    }
}
