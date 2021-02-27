@extends('base')

@section('main')
<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">Bộ phận</h1>
        {{-- <a href="{{ route('employees.create')}}" class="btn btn-outline-primary mb-2">Tạo nhân viên mới</a> --}}

        <table class="table table-striped" id="table_departments">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Mã bộ phận</td>
                    <td>Tên bộ phận</td>
                    <td>Số nhân viên</td>
                </tr>
            </thead>
            <tbody>
                @foreach($departments as $department)
                <tr>
                    <td>{{$department->id}}</td>
                    <td>{{$department->department_code}}</td>
                    <td>{{$department->name}}
                    <td>{{$department->employees_count}}</td>
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
                $('#table_departments').DataTable({
                    responsive: true,
                });
            });
        </script>
        @endSection