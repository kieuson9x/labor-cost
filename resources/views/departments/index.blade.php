@extends('base')

@section('main')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="p-4 border-bottom bg-light">
                <h4 class="card-title mb-0">Bộ phận</h4>
            </div>
            <div class="card-body">
                <a href="{{ route('employees.create')}}" class="btn btn-outline-primary mb-2">Tạo nhân viên mới</a>

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
            </div>
        </div>
    </div>
</div>
@endsection

@section('customScript')
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    jQuery(document).ready(function () {
        $('#table_departments').DataTable({
            responsive: true,
        });
    });

</script>
@endSection
