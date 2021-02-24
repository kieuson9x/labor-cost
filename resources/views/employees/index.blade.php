@extends('base')

@section('main')
<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">Employees</h1>
        <a href="{{ route('employees.create')}}" class="btn btn-outline-primary mb-2">Create</a>
        <table class="table table-striped" id="table_employees">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Employee Code</td>
                    <td>Full Name</td>
                    <td>Department</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{$employee->id}}</td>
                    <td>{{$employee->employee_code}}</td>
                    <td>{{$employee->full_name}}
                    <td>{{$employee->department->name}}</td>
                    <td>
                        <a href="{{ route('employees.edit',['id' => $employee->id])}}" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
        </div>
        @endsection

        @section('customScript')
        <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
        <script>
            jQuery(document).ready(function() {
                $('#table_employees').DataTable({
                    responsive: true
                });
            });
        </script>
        @endSection