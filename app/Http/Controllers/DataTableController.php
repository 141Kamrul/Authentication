<?php

namespace App\Http\Controllers;

use App\Models\DataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $employees= DataTable::all();
        return view('admin.employee_index',['employees'=> $employees]);
    }

    /**
     * Show the form for creating a new resource.
     */
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
            'position' => ['required', 'string', 'max:255'],
            'office' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:18', 'max:65'],
            'start_date' => ['required', 'date'],
            'salary' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $employee = DataTable::create($request->all());
            
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

    /**
     * Display the specified resource.
     */
    public function show(DataTable $dataTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataTable $employee)
    {
        //
        return view('admin.edit',['employee'=> $employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:5', 'max:20'],
            'position' => ['required', 'string', 'max:255'],
            'office' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:18', 'max:65'],
            'start_date' => ['required', 'date'],
            'salary' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $employee = DataTable::findOrFail($id);
            $employee->update($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Employee updated successfully!',
                'employee' => $employee
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating employee: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataTable $employee)
    {
        //

        try {
            $employee->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Employee deleted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting employee: ' . $e->getMessage()
            ], 500);
        }
    }
}
