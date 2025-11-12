@extends('layouts.admin')

@section('title','Data Table Page')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Employee Table
            </div> 
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
                       
                    </tr>
                </thead>

                <tbody>
                    @foreach ($employees as $employee)
                        <tr data-id="{{ $employee->id }}">
                            <td>{{ $employee->name }}</td>

                            {{-- Position link --}}
                            <td>
                                <a href="{{ route('admin.position_employees', $employee->position->id) }}">
                                    {{ $employee->position->name }}
                                </a>
                            </td>

                            {{-- Office (city) link --}}
                            <td>
                                <a href="{{ route('admin.office_position', $employee->position->office->id) }}">
                                    {{ $employee->position->office->name }}
                                </a>
                            </td>

                            <td>{{ $employee->age }}</td>
                            <td>{{ $employee->start_date }}</td>
                            <td>${{ number_format($employee->salary, 0) }}</td>
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
                       
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    
@endsection


