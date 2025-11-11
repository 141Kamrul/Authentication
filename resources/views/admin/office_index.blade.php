@extends('layouts.admin')

@section('title','Data Table Page')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Office Table
            </div>
            
            <button class="btn btn-primary btn-sm" id="addOfficeBtn" data-bs-toggle="modal" data-bs-target="#officeModal">
                Add New
            </button>
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Office Name</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($offices as $office)
                        <tr data-id="{{ $office->id }}">
                            <td>
                                <a href="{{ route('admin.office_position', $office->id) }}" class="text-decoration-none">
                                    {{ $office->name }}
                                </a>
                            </td>
                            <td class="text-center">
                                <button 
                                    class="btn btn-sm btn-warning editOfficeBtn"
                                    data-id="{{ $office->id }}"
                                    data-name="{{ $office->name }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <button class="btn btn-sm btn-danger deleteOfficeBtn" data-id="{{ $office->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Include the modal partial --}}
    @include('admin.office_modal')
@endsection

@section('scripts')
    <script src="{{ asset('js/office.js') }}"></script>
@endsection