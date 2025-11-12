@extends('layouts.admin')

@section('title','Employee Table Page')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <a href="{{ route('admin.office_position', $position->office->id) }}" class="text-decoration-none text-primary fw-semibold">
                    {{ $office_name }}
                </a> City  
                <a href="{{ route('admin.position_employees', $position->id) }}" class="text-decoration-none text-primary fw-semibold">
                    {{ $position->name }}
                </a> Position Employees Table
            </div>

            
            <button class="btn btn-primary btn-sm" id="addEmployeeBtn" data-bs-toggle="modal" data-bs-target="#employeeModal">
                Add New
                {{-- Add this hidden field in your view --}}
                <input type="hidden" id="current_position_id" value="{{ $position->id }}">
            </button>
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($employees as $employee)
                        <tr data-id="{{ $employee->id }}">
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->age }}</td>
                            <td>{{ $employee->start_date }}</td>
                            <td>${{ number_format($employee->salary, 0) }}</td>
                            <td class="text-center">
                                <button 
                                    class="btn btn-sm btn-warning editEmployeeBtn"
                                    data-id="{{ $employee->id }}"
                                    data-name="{{ $employee->name }}"
                                    data-age="{{ $employee->age }}"
                                    data-start_date="{{ $employee->start_date }}"
                                    data-salary="{{ $employee->salary }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                               <button class="btn btn-sm btn-danger deleteEmployeeBtn" data-id="{{ $employee->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Include the modal partial --}}
    @include('admin.employee_modal')
@endsection

@section('scripts')
    <script src="{{ asset('js/employee.js') }}"></script>
@endsection
