@extends('layouts.admin')

@section('title','Edit Employee')

@section('content')
    This is Data Table Page

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Data Table
            </div>
            <a href="{{ route('admin.create') }}" class="btn btn-primary btn-sm">Add New</a>
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
                    @foreach ($employees as $employeeRow)
                        <tr>
                            <td>{{ $employeeRow->name }}</td>
                            <td>{{ $employeeRow->position }}</td>
                            <td>{{ $employeeRow->office }}</td>
                            <td>{{ $employeeRow->age }}</td>
                            <td>{{ $employeeRow->start_date }}</td>
                            <td>${{ number_format($employeeRow->salary, 0) }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.edit', $employeeRow->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <form action="{{ route('admin.destroy', $employeeRow) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Are you sure you want to delete this employee?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <form action="{{ route('admin.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel">Edit Employee</h5>
              <a href="{{ route('admin.index') }}" class="btn-close" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input name="name" value="{{ old('name', $employee->name) }}" class="form-control">
                        @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Position</label>
                        <input name="position" value="{{ old('position', $employee->position) }}" class="form-control">
                        @error('position') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Office</label>
                        <input name="office" value="{{ old('office', $employee->office) }}" class="form-control">
                        @error('office') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Age</label>
                        <input name="age" value="{{ old('age', $employee->age) }}" type="number" class="form-control">
                        @error('age') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Start date</label>
                        <input name="start_date" value="{{ old('start_date', $employee->start_date) }}" type="date" class="form-control">
                        @error('start_date') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Salary</label>
                        <input name="salary" value="{{ old('salary', $employee->salary) }}" type="number" class="form-control" step="0.01">
                        @error('salary') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <a href="{{ route('admin.index') }}" class="btn btn-secondary">Cancel</a>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var modalEl = document.getElementById('editModal');
        if (modalEl) {
          var modal = new bootstrap.Modal(modalEl);
          modal.show();
        }
      });
    </script>

@endsection