
@extends('layouts.admin')

@section('title','Add Employee')

@section('content')
    This is Create Page
    <form id="employeeForm" method="POST" action="{{ isset($employee) ? route('admin.update', $employee->id) : route('admin.store') }}">
        @csrf
        @if(isset($employee))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input 
                type="text" 
                class="form-control" 
                id="name" 
                name="name" 
                value="{{ old('name', $employee->name ?? '') }}" 
                required>
        </div>

        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <input 
                type="text" 
                class="form-control" 
                id="position" 
                name="position" 
                value="{{ old('position', $employee->position ?? '') }}" 
                required>
        </div>

        <div class="mb-3">
            <label for="office" class="form-label">Office</label>
            <input 
                type="text" 
                class="form-control" 
                id="office" 
                name="office" 
                value="{{ old('office', $employee->office ?? '') }}" 
                required>
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input 
                type="number" 
                class="form-control" 
                id="age" 
                name="age" 
                value="{{ old('age', $employee->age ?? '') }}" 
                required>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input 
                type="date" 
                class="form-control" 
                id="start_date" 
                name="start_date" 
                value="{{ old('start_date', isset($employee->start_date) ? \Carbon\Carbon::parse($employee->start_date)->format('Y-m-d') : '') }}" 
                required>
        </div>

        <div class="mb-3">
            <label for="salary" class="form-label">Salary ($)</label>
            <input 
                type="number" 
                class="form-control" 
                id="salary" 
                name="salary" 
                step="0.01" 
                value="{{ old('salary', $employee->salary ?? '') }}" 
                required>
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($employee) ? 'Update Employee' : 'Add Employee' }}
        </button>
    </form>


    

@endsection