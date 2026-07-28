<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $query = Equipment::with(['brand', 'equipmentModel', 'company']);
        
        if ($user->role === 'technician' || $user->role === 'client') {
            $query->where('company_id', $user->company_id);
        }
        
        return response()->json($query->paginate(15));
    }
}
