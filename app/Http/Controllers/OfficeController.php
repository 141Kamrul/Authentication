<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;
use Illuminate\Support\Facades\Validator;
class OfficeController extends Controller
{
    //
    public function index()
    {
        //
        $offices= Office::all();
        return view('admin.office_index',['offices'=> $offices]);
    }

    public function create()
    {
        //
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
            $employee = Office::create($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Employee created successfully!',
                'employee' => $employee
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating employee: ' . $e->getMessage()
            ], 500);
        }
    }
    public function show(Office $office){
        $positions=$office->position;
        return view('admin.position_show',['office'=>$office, 'positions'=>$positions, ]);
    }
}
