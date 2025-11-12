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

    public function store(Request $request, Office $office)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:20'],
            'total_employee_count' => ['required', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create position with all fields
            $position = Position::create([
                'name' => $request->name,
                'total_employee_count' => $request->total_employee_count,
                'hired_employee_count' => 0, // Default to 0
                'office_id' => $office->id
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Position created successfully!',
                'position' => $position // Make sure this includes all fields
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating position: ' . $e->getMessage()
            ], 500);
        }
    }
    public function show($positionParameter){
    
        $position = Position::find($positionParameter);
        
        $position->load('office');
        $office_name = $position->office?->name ?? 'Unknown Office';
        
        $employees = $position->data_tables;
        
        return view('admin.position_show', [
            'office_name' => $office_name, 
            'position' => $position, 
            'employees' => $employees
        ]);
}

    public function destroy(Position $position){
        try {
            $position->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Position deleted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting Position: ' . $e->getMessage()
            ], 500);
        }
    } 
}
