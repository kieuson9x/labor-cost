@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-3">Update employee</h1>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br />
        @endif
        <form method="post" action="{{ route('employees.update', ['id' => $employee->id]) }}">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="first_name">Họ tên nhân viên</label>
                <input type="text" class="form-control" name="full_name" length={255}
                    value="{{ $employee->full_name }}" />
            </div>

            <div class="form-group">
                <label for="department_id">Bộ phận</label>

                <select class="form-control" id="department_id" name="department_id">
                    @foreach($departmentOptions as $item)
                    <option value="{{ $item['value'] }}" @if ($item['value']===$employee->
                        department_id) {{ 'selected' }}
                        @endif>{{ $item['title'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="first_name">Lương</label>
                <input type="text" class="form-control" name="amount" length={255}
                    value="{{ $employee->salaries()->latest()->first()->amount ?? "" }}" />
            </div>

            <button type="submit" class="btn btn-primary">Sửa</button>
        </form>
    </div>
</div>
@endsection