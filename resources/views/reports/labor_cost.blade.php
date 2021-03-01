@extends('base')
@section('customCSS')
<link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" rel="stylesheet">
@endsection
@section('main')
<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">Báo cáo chi phí nhân công</h1>

        <form method="GET" action="{{ route('reports.labor-cost')}}" class="form-horizontal">
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

                <label for="department_id" class="col-xs-2 col-form-label mr-2">Bộ phận</label>
                <div class="col-xs-4">
                    <select class="form-control" id="department_id" name="department_id">
                        @foreach($departmentOptions as $item)
                        <option value="{{ $item['value'] }}" @if ($item['value']===(int) $departmentId) {{ 'selected' }}
                            @endif>
                            {{ $item['title'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                    <button type="submit" class="btn btn-primary mr-1 w-40  flex items-center justify-center">
                        <i
                            class="material-icons">filter_alt</i>
                        Lọc
                    </button>
            </div>

        </form>

        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="chart-container" style="">
                    <canvas id="number_of_employees"></canvas>
                </div>
            </div>

            <div class="col-sm-12 col-md-6">
                <div class="chart-container" style="">
                    <canvas id="total_needed_time"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('customScript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
    $(function () {
        var numberOfEmployeeData = {!!json_encode($numberOfEmployeeData) !!};
        var totalNeededTimeData= {!!json_encode($totalNeededTimeData) !!};
        var totalNeededEmployeeData= {!!json_encode($totalNeededEmployeeData) !!};

        var numberOfEmployeeCtx = document.getElementById('number_of_employees');
        var totalNeededTimeCtx = document.getElementById('total_needed_time');

        var labels = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7',
            'Tháng 8',
            'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];

        var numberOfEmployeeChartData = {
            labels: labels,
            datasets: [{
                label: 'Số nhân công hiện có',
                backgroundColor: 'red',
                borderColor: 'white',
                borderWidth: 1,
                data: labels.map(item => {
                    return numberOfEmployeeData[item] === 0 ? 0.1 : Math.round(numberOfEmployeeData[item]);
                })
            },
            {
                label: 'Số nhân công cần',
                backgroundColor: 'blue',
                borderColor: 'white',
                borderWidth: 1,
                data: labels.map(item => {
                    return totalNeededEmployeeData[item] === 0 ? 0.1 : Math.round(totalNeededEmployeeData[item]);
                })
            }
            ]
        };


        var totalNeededTimeChartData = {
            labels: labels,
            datasets: [{
                labels: labels,
                backgroundColor: ["red", "blue", "green", "cyan", "yellow", "purple", "brown", "grey", "pink", "orange", "teal", "olive"],
                borderColor: 'white',
                borderWidth: 1,
                data: labels.map(item => {
                    return totalNeededTimeData[item] === 0 ? 0.1 : Math.round(totalNeededTimeData[item]);
                })
            }]
        };

        var numberOfEmployeeChart = new Chart(numberOfEmployeeCtx, {
            type: 'bar',
            data: numberOfEmployeeChartData,
            options: {
                title: {
                    display: true,
                    text: 'Biểu đồ so sánh số nhân công và số nhân công cần trong tháng'
                }
            }
        });

        var totalNeededTimeChart = new Chart(totalNeededTimeCtx, {
            type: 'pie',
            data: totalNeededTimeChartData,
            options: {
                title: {
                    display: true,
                    text: 'Biểu đồ tổng thời gian để làm sản phẩm theo kế hoạch đã có'
                }
            }
        });
    });

</script>

@endsection
