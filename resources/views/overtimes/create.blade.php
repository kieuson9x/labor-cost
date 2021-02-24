@extends('base')

@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-3">Đăng ký giờ làm thêm trong tháng</h1>
        <div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
            @endif
            <form method="post" action="{{ route('overtimes.store', ['employee_id' => $employeeId ]) }}">
                @csrf
                <div class="form-group">
                    <div>Tháng</div>
                    <input class="form-control" id="month" type="text" placeholder="Tháng" name="month">
                </div>

                <div class="form-group">
                    <div>Năm</div>
                    <input class="form-control" id="month" type="text" placeholder="Năm" name="year">
                </div>

                <div class="form-group">
                    <div>Làm thêm ngày thường</div>
                    <input class="form-control" id="month" type="text" placeholder="" name="weekdays">
                </div>

                <div class="form-group">
                    <div>Làm thêm ngày CN</div>
                    <input class="form-control" id="month" type="text" placeholder="" name="sunday">
                </div>

                <div class="form-group">
                    <div>Làm thêm ngày lễ</div>
                    <input class="form-control" id="month" type="text" placeholder="" name="holiday">
                </div>
                <div class="form-group">
                    <div>Làm việc ban đêm </div>
                    <input class="form-control" id="month" type="text" placeholder="" name="night">
                </div>
                <div class="form-group">
                    <div>Làm thêm ban đêm ngày thường</div>
                    <input class="form-control" id="month" type="text" placeholder="" name="weekdays_night">
                </div>

                <div class="form-group">
                    <div>Làm thêm ban đêm ngày CN</div>
                    <input class="form-control" id="month" type="text" placeholder="" name="sunday_night">
                </div>

                <div class="form-group">
                    <div>Làm thêm ban đêm ngày lế</div>
                    <input class="form-control" id="month" type="text" placeholder="" name="holiday_night">
                </div>

                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </form>
        </div>
    </div>
</div>
@endsection