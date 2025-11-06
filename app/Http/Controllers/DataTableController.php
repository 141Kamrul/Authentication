<?php

namespace App\Http\Controllers;

use App\Models\DataTable;
use Illuminate\Http\Request;

class DataTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $employees= Datatable::all();
        return view('admin.index',['employees'=> $employees]);
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
        //
        $request->validate( [
            'name'=> ['required','min:5','max:20'],
            'position' => ['required'],
            'office' => ['required'],
            'age' => ['required'],
            'start_date' => ['required'],
            'salary' => ['required'],
        ]);

        DataTable::create($request->all());
        return redirect()->route('admin.index')->with('success','');

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
    public function edit(DataTable $dataTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataTable $dataTable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataTable $employee)
    {
        //
        $employee->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
