<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\Office;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    //
    public function index()
    {
        //
        $positions= Position::with('office')->get();
        return view('admin.position_index',['positions'=> $positions]);
    }

    public function store(Request $request, Office $office) // Add Office parameter
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:5', 'max:20'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create position and associate with the office
            $position = Position::create([
                'name' => $request->name,
                'office_id' => $office->id // Add office_id
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Position created successfully!',
                'position' => $position
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating position: ' . $e->getMessage()
            ], 500);
        }
    }
    // public function show(Position $position){
    //     $positions=$office->position;
    //     return view('admin.position_show',['office'=>$office, 'positions'=>$positions, ]);
    // }
}
