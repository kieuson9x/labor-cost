@extends('base')

@section('main')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="p-4 border-bottom bg-light">
                <h4 class="card-title mb-0">Lọc</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('dashboard') }}">
                    @method('GET')
                    @csrf
                    <div class="form-group row">
                        <label for="year" class="col-xs-2 col-form-label mr-2">Năm</label>
                        <div class="col-xs-4 mr-2">
                            <select id="year-selection" class="form-control" id="year" name="year">
                                @foreach([2021, 2022, 2023] as $item)
                                <option value="{{ $item }}" @if ($item===(int) $year) {{ 'selected' }} @endif>{{ $item }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mr-1 w-40  flex items-center justify-center">
                            <i
                                class="material-icons">filter_alt</i>
                            Lọc
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="p-4 border-bottom bg-light">
                <h4 class="card-title mb-0">Tổng quan</h4>
            </div>
            <div class="card-body">
                <table class="table" data-toggle="table" id="table_dashboard_overall">
                    <thead>
                        <tr class="tableizer-firstrow">
                            <th>Nội dung</th>
                            <th>Lũy kế cả năm</th>
                            <th>Tháng 1</th>
                            <th>Tháng 2</th>
                            <th>Tháng 3</th>
                            <th>Tháng 4</th>
                            <th>Tháng 5</th>
                            <th>Tháng 6</th>
                            <th>Tháng 7</th>
                            <th>Tháng 8</th>
                            <th>Tháng 9</th>
                            <th>Tháng 10</th>
                            <th>Tháng 11</th>
                            <th>Tháng 12</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departmentOptions as $department)
                            <tr>
                               <td>{{str_replace('HY_', '', $department['title'])}}</td>
                                <td data-halign="center" class="{{data_get($dashboardData, "overall.{$department['value']}.total") ? 'normal' : 'overload'}}">
                                    {{data_get($dashboardData, "overall.{$department['value']}.total") ? 'OK' : 'Vượt'}}
                                </td>
                                @for ($i = 1; $i <= 12; $i++) <td data-halign="center" id="{{$department['value']}}" class="{{data_get($dashboardData, "overall.{$department['value']}.{$i}") ? 'normal' : 'overload'}}">
                                        {{data_get($dashboardData, "overall.{$department['value']}.{$i}") ? 'OK' : 'Vượt'}}
                                    </td>
                                    @endfor
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="p-4 border-bottom bg-light">
                <h4 class="card-title mb-0">Nhân công</h4>
            </div>
            <div class="card-body">
                <table class="table" data-toggle="table" id="table_dashboard_employee_needed">
                    <thead>
                        <tr class="tableizer-firstrow">
                            <th>Nội dung</th>
                            <th>Lũy kế cả năm</th>
                            <th>Tháng 1</th>
                            <th>Tháng 2</th>
                            <th>Tháng 3</th>
                            <th>Tháng 4</th>
                            <th>Tháng 5</th>
                            <th>Tháng 6</th>
                            <th>Tháng 7</th>
                            <th>Tháng 8</th>
                            <th>Tháng 9</th>
                            <th>Tháng 10</th>
                            <th>Tháng 11</th>
                            <th>Tháng 12</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departmentOptions as $department)
                            <tr>
                               <td>{{str_replace('HY_', '', $department['title'])}}</td>
                                <td data-halign="center">
                                    {{-- {{data_get($dashboardData, "overall.{$department['value']}.total")} --}}
                                </td>
                                @for ($i = 1; $i <= 12; $i++) <td data-halign="center" id="{{$department['value']}}" class="{{data_get($dashboardData, "employee_needed.{$department['value']}.{$i}.is_overload") ? 'overload' : 'normal'}}">
                                        {{round(data_get($dashboardData, "employee_needed.{$department['value']}.{$i}.needed"))}}
                                    </td>
                                    @endfor
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="p-4 border-bottom bg-light">
                <h4 class="card-title mb-0">Chi phí</h4>
            </div>
            <div class="card-body">
                <table class="table" data-toggle="table" id="table_dashboard_overall">
                    <thead>
                        <tr class="tableizer-firstrow">
                            <th>Nội dung</th>
                            <th>Lũy kế cả năm</th>
                            <th>Tháng 1</th>
                            <th>Tháng 2</th>
                            <th>Tháng 3</th>
                            <th>Tháng 4</th>
                            <th>Tháng 5</th>
                            <th>Tháng 6</th>
                            <th>Tháng 7</th>
                            <th>Tháng 8</th>
                            <th>Tháng 9</th>
                            <th>Tháng 10</th>
                            <th>Tháng 11</th>
                            <th>Tháng 12</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departmentOptions as $department)
                            <tr>
                                <td>{{str_replace('HY_', '', $department['title'])}}</td>
                                <td data-halign="center">
                                    {{number_to_VND(data_get($dashboardData, "salary_cost.{$department['value']}.total")) }}
                                </td>
                                @for ($i = 1; $i <= 12; $i++) <td data-halign="center" id="{{$department['value']}}">
                                        {{number_to_VND(data_get($dashboardData, "salary_cost.{$department['value']}.{$i}"))}}
                                    </td>
                                    @endfor
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endSection