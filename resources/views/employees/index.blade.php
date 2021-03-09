@extends('base')

@section('main')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="p-4 border-bottom bg-light">
                <h4 class="card-title mb-0">Nhân viên</h4>
            </div>
            <div class="card-body">
                <a href="{{ route('employees.create')}}" class="btn btn-outline-primary mb-2">Tạo nhân viên mới</a>

                <table class="table table-striped" id="table_employees">
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
                                <a href="{{ route('employees.edit',['id' => $employee->id])}}"
                                    class="btn btn-primary">Edit</a>
                                <a href="{{ route('employees.overtimes.index',['employeeId' => $employee->id])}}"
                                    class="btn btn-primary">Bảng tăng ca</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customScript')
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    jQuery(document).ready(function () {
        $('#table_employees').DataTable({
            responsive: true,
        });
    });

</script>
@endSection
