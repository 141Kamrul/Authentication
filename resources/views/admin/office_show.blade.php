@extends('layouts.admin')

@section('title','Position Table Page')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                {{ $office->name }} city Position Table
            </div>
            <button class="btn btn-primary btn-sm" id="addPositionBtn" data-bs-toggle="modal" data-bs-target="#positionModal">
                Add New
            </button>
            
            
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Position Name</th>
                        <th>Total Employee</th>
                        <th>Hired Employee</th>
                        <th>Available Position</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($positions as $position)
                        <tr data-id="{{ $position->id }}">
                            <td>
                                <a href="{{ route('admin.position_employees', $position) }}" class="text-decoration-none">
                                    {{ $position->name }}
                                </a>
                            </td>
                            <td>{{ $position->total_employee_count }}</td>
                            <td>{{ $position->hired_employee_count }}</td>
                            <td>{{ $position->total_employee_count - $position->hired_employee_count }}</td>
                            <td class="text-center">
                                <button 
                                    class="btn btn-sm btn-warning editPositionBtn"
                                    data-id="{{ $position->id }}"
                                    data-name="{{ $position->name }}"
                                    data-total_employee_count="{{ $position->total_employee_count }}"
                                    data-hired_employee_count="{{ $position->hired_employee_count }}"
                                    data-available_position="{{ $position->total_employee_count - $position->hired_employee_count }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <button class="btn btn-sm btn-danger deletePositionBtn" data-id="{{ $position->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th>Position Name</th>
                        <th>Total Employee</th>
                        <th>Hired Employee</th>
                        <th>Available Position</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Include the modal partial --}}
    @include('admin.position_modal')
@endsection

@section('scripts')
    <script src="{{ asset('js/position.js') }}"></script>
@endsection