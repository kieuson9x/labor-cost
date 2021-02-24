@extends('base')

@section('main')
<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">Giờ làm thêm</h1>
        <a href="{{ route('overtimes.create')}}" class="btn btn-outline-primary mb-2">Create</a>
        <table class="table table-striped" id="table_employee_overtimes">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Mã NV</td>
                    <td>Họ tên nhân viên</td>
                    <td>Bộ phận</td>
                    <td>Lương chính</td>
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
                    <td>{{$employee->salaries()->latest()->first()->amount ?? '-'}}</td>
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
                $('#table_employee_overtimes').DataTable({
                    responsive: true
                });
            });
        </script>
        @endSection