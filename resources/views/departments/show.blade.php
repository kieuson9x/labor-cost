@extends('base')

@section('main')
<div class="row">
    <div class="col-md-6 grid-margin">
        <div class="card">
            <div class="p-4 border-bottom bg-light">
                <h4 class="card-title mb-0">{{$department->name}} -- {{$department->department_code}}</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('departments.show', ['departmentId' => $departmentId]) }}">
                    @method('GET')
                    @csrf
                    <div class="form-group row">
                        <label for="year" class="col-xs-2 col-form-label mr-2">Năm</label>
                        <div class="col-xs-4 mr-2">
                            <select id="year-selection" class="form-control" id="year" name="year">
                                @foreach([2021, 2022, 2023] as $item)
                                <option value="{{ $item }}" @if ($item===(int) $year) {{ 'selected' }} @endif>
                                    {{ $item }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mr-1 w-40  flex items-center justify-center">
                            <i class="material-icons">filter_alt</i>
                            Lọc
                        </button>
                    </div>
                </form>
                <table class="table table-striped" id="table_department">
                    <thead>
                        <tr class="tableizer-firstrow">
                            <th class="no-sort">Nội dung</th>
                            <th data-editable="true">Tháng 1</th>
                            <th data-editable="true">Tháng 2</th>
                            <th data-editable="true">Tháng 3</th>
                            <th data-editable="true">Tháng 4</th>
                            <th data-editable="true">Tháng 5</th>
                            <th data-editable="true">Tháng 6</th>
                            <th data-editable="true">Tháng 7</th>
                            <th data-editable="true">Tháng 8</th>
                            <th data-editable="true">Tháng 9</th>
                            <th data-editable="true">Tháng 10</th>
                            <th data-editable="true">Tháng 11</th>
                            <th data-editable="true">Tháng 12</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="not-editable">Lương trung bình</td>
                            @for ($i = 0; $i < 12; $i++) <td data-halign="center" data-align="left" data-name="{{$i+1}}"
                                data-type="text" data-pk="average_salary">
                                {{ number_to_VND(data_get($department->data()->where('month', $i + 1)->first(), 'average_salary', 0)) }}
                                </td>
                                @endfor
                        </tr>
                        <tr>
                            <td class="not-editable">Số công nhân trong tháng</td>
                            @for ($i = 0; $i < 12; $i++) <td data-halign="center" data-align="left" data-name="{{$i+1}}"
                                data-type="text" data-pk="number_of_employees">
                                {{ data_get($department->data()->where('month', $i + 1)->first(), 'number_of_employees', 0) }}
                                </td>
                                @endfor
                        </tr>
                        <tr>
                            <td class="not-editable">Số thời gian làm việc 1 ngày (h)</td>
                            @for ($i = 0; $i < 12; $i++) <td data-halign="center" data-align="left" data-name="{{$i+1}}"
                                data-type="text" data-pk="working_hours_per_day">
                                {{ data_get($department->data()->where('month', $i + 1)->first(), 'working_hours_per_day', 0) }}
                                </td>
                                @endfor
                        </tr>
                        <tr>
                            <td class="not-editable">Số ngày công trong trong tháng</td>
                            @for ($i = 0; $i < 12; $i++) <td data-halign="center" data-align="left" data-name="{{$i+1}}"
                                data-type="text" data-pk="working_days">
                                {{ data_get($department->data()->where('month', $i + 1)->first(), 'working_days', 0) }}
                                </td>
                                @endfor
                        </tr>
                        <tr>
                            <td class="not-editable">Số giờ làm thêm ngày thường (h * 150%)</td>
                            @for ($i = 0; $i < 12; $i++) <td data-halign="center" data-align="left" data-name="{{$i+1}}"
                                data-type="text" data-pk="week_days_overtime_hours">
                                {{ data_get($department->data()->where('month', $i + 1)->first(), 'week_days_overtime_hours', 0) }}
                                </td>
                                @endfor
                        </tr>
                        <tr>
                            <td class="not-editable">Tổng số giờ làm trong tháng (h)</td>
                            @for ($i = 0; $i < 12; $i++) <td data-halign="center" data-align="left" data-name="{{$i+1}}"
                                data-type="text" data-pk="total_working_hours_per_month" class="not-editable">
                                {{ data_get($department->data()->where('month', $i + 1)->first(), 'total_working_hours_in_month', 0) }}
                                </td>
                                @endfor
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="p-4 border-bottom bg-light">
                        <h4 class="card-title mb-0">Bảng đánh giá chi phí</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-striped" id="table_department_report">
                                <thead>
                                    <tr class="tableizer-firstrow">
                                        <th class="no-sort">Nội dung</th>
                                        <th>Tổng</th>
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
                                    <tr>
                                        <td>Luỹ kế theo kế hoạch</td>
                                        <td>{{number_to_VND(data_get($budgetData, "Tổng.Luỹ kế theo kế hoạch", 0))}}</td>
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" data-align="left">
                                            {{ number_to_VND(data_get($budgetData, "Tháng {$i}.Luỹ kế theo kế hoạch", 0)) }}
                                            </td>
                                            @endfor
                                    </tr>
                                    <tr>
                                        <td>Luỹ kế lương theo kế hoạch sản xuất</td>
                                        <td>{{number_to_VND(data_get($budgetData, "Tổng.Luỹ kế lương theo kế hoạch sản xuất", 0))}}</td>
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" data-align="left">
                                            {{ number_to_VND(data_get($budgetData, "Tháng {$i}.Luỹ kế lương theo kế hoạch sản xuất", 0)) }}
                                            </td>
                                            @endfor
                                    </tr>
                                    <tr>
                                        <td>Chi phí thực tế ERP</td>
                                        <td>{{number_to_VND(data_get($budgetData, "Tổng.Chi phí thực tế ERP", 0))}}</td>
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" data-align="left">
                                            {{ number_to_VND(data_get($budgetData, "Tháng {$i}.Chi phí thực tế ERP")) }}
                                            </td>
                                            @endfor
                                    </tr>
                                    <tr>
                                        <td>Kết quả</td>
                                        <td class="{{data_get($budgetData, "Tổng.Vượt") ? 'overload' : 'normal-green'}}">{{ data_get($budgetData, "Tổng.Vượt") ? "Vượt" : "OK" }}</td>
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" data-align="left" class="{{data_get($budgetData, "Tháng {$i}.Vượt") ? 'overload' : 'normal-green'}}">
                                            {{ data_get($budgetData, "Tháng {$i}.Vượt") ? "Vượt" : "OK" }}
                                            </td>
                                            @endfor
                                    </tr>
                                </tbody>
                            </table>
                            {{-- <div class="col-sm-12 col-md-5">
                                <div class="chart-container" style="">
                                    <canvas id="total_chart"></canvas>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-7">
                                <div class="chart-container" style="">
                                    <canvas id="monthly_chart"></canvas>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="p-4 border-bottom bg-light">
                        <h4 class="card-title mb-0">Bảng đánh giá nhân công</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-striped" id="table_department_report">
                                <thead>
                                    <tr class="tableizer-firstrow">
                                        <th class="no-sort">Nội dung</th>
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
                                    <tr>
                                        <td>Số nhân công có</td>
                                        {{-- <td>{{number_to_VND(data_get($laborCostData, "Tổng.Luỹ kế theo kế hoạch", 0))}}</td> --}}
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" data-align="left">
                                            {{ data_get($laborCostData, "Tháng {$i}.Số nhân công có", 0) }}
                                            </td>
                                            @endfor
                                    </tr>
                                    <tr>
                                        <td>Số nhân công cần</td>
                                        {{-- <td>{{number_to_VND(data_get($laborCostData, "Tổng.Luỹ kế lương theo kế hoạch sản xuất", 0))}}</td> --}}
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" data-align="left">
                                            {{ round(data_get($laborCostData, "Tháng {$i}.Số nhân công cần", 0)) }}
                                            </td>
                                            @endfor
                                    </tr>

                                    <tr>
                                        <td>Kết quả</td>
                                        {{-- <td>{{number_to_VND(data_get($laborCostData, "Tổng.Luỹ kế lương theo kế hoạch sản xuất", 0))}}</td> --}}
                                        @for ($i = 1; $i <= 12; $i++) <td data-halign="center" data-align="left" class="{{data_get($laborCostData, "Tháng {$i}.Vượt") ? 'overload' : 'normal-green'}}">
                                            {{ data_get($laborCostData, "Tháng {$i}.Vượt") ? 'Vượt' : 'OK' }}
                                            </td>
                                            @endfor
                                    </tr>
                                </tbody>
                            </table>
                            {{-- <div class="col-sm-12 col-md-5">
                                <div class="chart-container" style="">
                                    <canvas id="total_chart"></canvas>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-7">
                                <div class="chart-container" style="">
                                    <canvas id="monthly_chart"></canvas>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customScript')
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
    $(function () {
        var toast = new Toasty();
        $('#table_department, #table_department_report').DataTable({
            responsive: true,
            paging: false,
            ordering: false,
            searching: false,
            info: false
        });

        $(`#departments`).collapse();
        $(`#departments .nav-link[departmentId='${departmentId}']`).parent().addClass('active')

        var departmentId = {{$departmentId}};
        var url = "{{route('departments.update', ['departmentId' => $departmentId])}}";

        $('#table_department tbody tr td:not(.not-editable)').editable({
            type: 'text',
            title: 'Enter username',
            url: url,
            params: function (params) {
                params.year = {{$year}};
                return params;
            },
            validate: function (value) {
                var type = $(this).attr('data-pk');
                if (type !== 'week_days_overtime_hours' && type !== 'average_salary') {
                    if ($.trim(value) == '') {
                        return 'Trường này bắt buộc!';
                    }

                    if (!$.isNumeric(value) || parseFloat(value) < 0) {
                        return 'Nhập giá trị > 0';
                    }
                }

                if (type === 'number_of_employees') {
                    if (!Number.isInteger(parseFloat(value))) {
                        return 'Chỉ nhập số nguyên';
                    }
                }

                if (type === 'working_hours_per_day') {
                    if (parseFloat(value) > 24) {
                        return 'Không được quá 24h / ngày';
                    }
                }

                if (type === 'working_days') {
                    if (parseFloat(value) > 31) {
                        return 'Không được quá 31 ngày';
                    }
                }
            },
            success: function (response, newValue) {
                if (response.success) {
                    var total = response.total_working_hours_in_month;
                    var month = response.month;
                    var selector =
                        `td[data-pk="total_working_hours_per_month"][data-name="${month}"]`;
                    jQuery(selector).text(total);

                    location.reload();

                    // renderChart(response.budgetData);

                    toast.success("Cập nhật thành công!");
                }
            },
            ajaxOptions: {
                type: 'put',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
            }
        });

        // var budgetData = {!!json_encode($budgetData) !!};
        // renderChart(budgetData);

        // function renderChart(budgetData) {
        //     var totalChartCtx = document.getElementById('total_chart');
        //     var monthlyChartCtx = document.getElementById('monthly_chart');

        //     const LUY_KE_KH = {
        //         "label": "Luỹ kế theo kế hoạch",
        //         "name": "Luỹ kế theo kế hoạch",
        //         "color": "#ff8a5b"
        //     };
        //     const LUY_KE_LUONG_KH_SX = {
        //         "label": "Luỹ kế lương theo kế hoạch sản xuất",
        //         "name": "Luỹ kế lương theo kế hoạch sản xuất",
        //         "color": "#395b50",
        //         "passColor": "green",
        //         "failColor": "red"
        //     };
        //     const CHI_PHI_ERP = {
        //         "label": "Chi phí thực tế ERP",
        //         "name": "Chi phí thực tế ERP",
        //         "color": "#5c9ead",
        //         "passColor": "green",
        //         "failColor": "red"
        //     };

        //     var labels = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7',
        //         'Tháng 8',
        //         'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        //     ];

        //     var barchartTotal = {
        //         labels: ['Tổng Ngân sách Năm'],
        //         datasets: [{
        //                 label: LUY_KE_KH.label,
        //                 backgroundColor: LUY_KE_KH.color,
        //                 borderColor: 'white',
        //                 borderWidth: 1,
        //                 data: [Math.round(budgetData['Tổng'][LUY_KE_KH.name])]
        //             }, {
        //                 label: LUY_KE_LUONG_KH_SX.label,
        //                 backgroundColor: LUY_KE_LUONG_KH_SX.color,
        //                 borderColor: 'white',
        //                 borderWidth: 1,
        //                 data: [Math.round(budgetData['Tổng'][LUY_KE_LUONG_KH_SX.name])]
        //             },
        //             {
        //                 label: CHI_PHI_ERP.label,
        //                 backgroundColor: CHI_PHI_ERP.color,
        //                 borderColor: 'white',
        //                 borderWidth: 1,
        //                 data: [Math.round(budgetData['Tổng'][CHI_PHI_ERP.name])]
        //             }
        //         ]
        //     }
        //     var barChartDataMonthly = {
        //         labels: labels,
        //         datasets: [{
        //                 label: LUY_KE_KH.label,
        //                 backgroundColor: LUY_KE_KH.color,
        //                 borderColor: 'white',
        //                 borderWidth: 1,
        //                 data: labels.map(item => {
        //                     return Math.round(budgetData[item][LUY_KE_KH.name]);
        //                 })
        //             }, {
        //                 label: LUY_KE_LUONG_KH_SX.label,
        //                 backgroundColor: LUY_KE_LUONG_KH_SX.color,
        //                 borderColor: 'white',
        //                 borderWidth: 1,
        //                 data: labels.map(item => {
        //                     return Math.round(budgetData[item][
        //                         LUY_KE_LUONG_KH_SX.name
        //                     ]);
        //                 })
        //             },
        //             {
        //                 label: CHI_PHI_ERP.label,
        //                 backgroundColor: CHI_PHI_ERP.color,
        //                 borderColor: 'white',
        //                 borderWidth: 1,
        //                 data: labels.map(item => {
        //                     return Math.round(budgetData[item][CHI_PHI_ERP.name]);
        //                 }),
        //             },
        //         ]

        //     };

        //     var globalOptions = {
        //         scales: {
        //             yAxes: [{
        //                 ticks: {
        //                     beginAtZero: true,
        //                     callback: function (value, index, values) {
        //                         if (parseInt(value) >= 1000) {
        //                             return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
        //                                 ".") + "VND";
        //                         } else {
        //                             return value + "VND";
        //                         }
        //                     }
        //                 }
        //             }]
        //         },
        //         tooltips: {
        //             callbacks: {
        //                 label: function (t, d) {
        //                     var xLabel = d.datasets[t.datasetIndex].label;
        //                     var yLabel = t.yLabel >= 1000 ? t.yLabel.toString().replace(
        //                         /\B(?=(\d{3})+(?!\d))/g, ".") + 'VND' : t.yLabel + 'VND';
        //                     return xLabel + ': ' + yLabel;
        //                 }
        //             }
        //         },

        //     };


        //     var myBarChartForMonthly = new Chart(monthlyChartCtx, {
        //         type: 'bar',
        //         data: barChartDataMonthly,
        //         options: {
        //             ...globalOptions,
        //             title: {
        //                 display: true,
        //                 text: 'Biểu đồ theo tháng'
        //             },
        //             animation: {
        //                 onProgress: function () {
        //                     var chartInstance = this.chart,
        //                         ctx = chartInstance.ctx;
        //                     var scales = chartInstance.scales;
        //                     ctx.textAlign = 'center';
        //                     ctx.textBaseline = 'bottom';
        //                     ctx.font = "600 20px Roboto";
        //                     ctx.fillStyle = "red";
        //                     const datasets = this.data.datasets;

        //                     datasets.forEach(function (dataset, i) {
        //                         var meta = chartInstance.controller.getDatasetMeta(i);

        //                         meta.data.forEach(function (bar, index) {
        //                             var data = dataset.data[index];


        //                             var budgetPlan = datasets[0].data[index];
        //                             var budget = datasets[1].data[index];
        //                             var budgetErp = datasets[2].data[index];

        //                             var compariableActualBudget = budgetErp === 0 ?
        //                                 budget : budgetErp;
        //                             var compariableActualBudgetIndex = budgetErp ===
        //                                 0 ?
        //                                 1 : 2;

        //                             var view = bar._view;
        //                             var x = view.x;
        //                             var yScale = scales['y-axis-0'];
        //                             var y = yScale.bottom - 30;
        //                             ctx.save();
        //                             ctx.translate(view.x, y);

        //                             ctx.rotate(-0.5 * Math.PI);

        //                             if (compariableActualBudget > budgetPlan) {
        //                                 if (budgetErp === 0) {
        //                                     if (bar._model.datasetLabel ===
        //                                         LUY_KE_LUONG_KH_SX.label) {
        //                                         ctx.fillStyle = LUY_KE_LUONG_KH_SX
        //                                             .failColor;
        //                                         ctx.fillText("Vượt", 0, 0);
        //                                     }
        //                                 } else {
        //                                     if (bar._model.datasetLabel ===
        //                                         CHI_PHI_ERP.label) {
        //                                         ctx.fillStyle = CHI_PHI_ERP
        //                                             .failColor;
        //                                         ctx.fillText("Vượt", 0, 0);

        //                                     }
        //                                 }

        //                             } else {
        //                                 if (budgetErp === 0) {
        //                                     if (bar._model.datasetLabel ===
        //                                         LUY_KE_LUONG_KH_SX.label) {
        //                                         ctx.fillStyle = LUY_KE_LUONG_KH_SX
        //                                             .passColor;
        //                                         ctx.fillText("OK", 0, 0);
        //                                     }
        //                                 } else {
        //                                     if (bar._model.datasetLabel ===
        //                                         CHI_PHI_ERP.label) {
        //                                         ctx.fillStyle = CHI_PHI_ERP
        //                                             .passColor;
        //                                         ctx.fillText("OK", 0, 0);
        //                                     }
        //                                 }
        //                             }

        //                             ctx.restore();
        //                         });
        //                     });
        //                 }
        //             }
        //         }
        //     });

        //     var myBarChartForTotal = new Chart(totalChartCtx, {
        //         type: 'bar',
        //         data: barchartTotal,
        //         options: {
        //             ...globalOptions,
        //             title: {
        //                 display: true,
        //                 text: 'Biểu đồ tổng theo năm'
        //             }
        //         }
        //     });
        // }
    });

</script>
@endSection
