@extends('layouts.admin')

@section('title','Position Table Page')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Position Table
            </div>
            
            
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($positions as $position)
                        <tr data-id="{{ $position->id }}">
                            <td>{{ $position->name }}</td>
                            <td class="text-center">
                                <button 
                                    class="btn btn-sm btn-warning editEmployeeBtn"
                                    data-id="{{ $position->id }}"
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
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Include the modal partial --}}
    
@endsection

@section('scripts')
    {{-- <script src="{{ asset('js/position.js') }}"></script> --}}
@endsection
