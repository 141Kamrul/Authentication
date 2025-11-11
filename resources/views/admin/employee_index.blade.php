@extends('layouts.admin')

@section('title','Data Table Page')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Data Table
            </div>
            
            <button class="btn btn-primary btn-sm" id="addEmployeeBtn" data-bs-toggle="modal" data-bs-target="#employeeModal">
                Add New
            </button>
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
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
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->office }}</td>
                            <td>{{ $employee->age }}</td>
                            <td>{{ $employee->start_date }}</td>
                            <td>${{ number_format($employee->salary, 0) }}</td>
                            <td class="text-center">
                                <button 
                                    class="btn btn-sm btn-warning editEmployeeBtn"
                                    data-id="{{ $employee->id }}"
                                    data-name="{{ $employee->name }}"
                                    data-position="{{ $employee->position }}"
                                    data-office="{{ $employee->office }}"
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
                        <th>Position</th>
                        <th>Office</th>
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
    @include('admin.modal')
@endsection

@section('scripts')
    <script src="{{ asset('js/employee.js') }}"></script>
@endsection
