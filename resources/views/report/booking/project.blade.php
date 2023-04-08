@extends('layouts.app')

@section('content')
@push('script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js" integrity="sha512-cuQouV/8K/1e7VzbF34fJhME9hgnivP5xRzkwifk1S+cx1G6QZwzbgiP7/Fq3Y4cOOgVhphx6H1ag6uQJs6ZaA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

@endpush
<style>
    #container {
    height: 370px;
}

.highcharts-figure,
.highcharts-data-table table {
    min-width: 400px;
    max-width: 100%;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: 'Sarabun', sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

</style>
    <section class="content-header">
        <h1>
            รายงาน
            <small>โครงการ</small>
            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                <i class="fa fa-file"></i> รายงาน แยกโครงการ
            </button> --}}
        </h1>
    </section>


    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-6 col-xs-12">

                <div class="box box-solid">
                    <div class="box-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <h3 class="box-title">กราฟแท่ง</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <figure class="highcharts-figure">
                            <div id="container1"></div>
                        </figure>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">

                <div class="box box-solid">
                    <div class="box-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <h3 class="box-title">แผนภูมิวงกลม</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <figure class="highcharts-figure">
                            <div id="container3"></div>
                        </figure>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-xs-12">

                <div class="box box-solid">
                    <div class="box-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <h3 class="box-title">กราฟแท่ง</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <figure class="highcharts-figure">
                            <div id="container2"></div>
                        </figure>
                    </div>
                </div>
            </div>
        </div> <!-- /row -->

    </section>
    <!-- /.content -->






@endsection


@push('script')

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.when(
                $.ajax({
                    type: 'GET',
                    url: '/report/booking/project',
                    success: function(response) {

                        const result1 = response;
                        const chartData = Array(12).fill(0);
                        result1.forEach(booking => {
                            const month = booking.month - 1; // ลบ 1 เนื่องจากเดือนใน JavaScript เริ่มจาก 0 ไม่ใช่ 1
                            chartData[month] = booking.total_bookings;
                        });


                        const chartSeries = [{
                            type: 'column',
                            name: 'จำนวนรายการจอง',
                            colorByPoint: true,
                            data: chartData,
                            showInLegend: false,
                            dataLabels: {
                            enabled: true,
                            color: '#000',
                            align: 'center',
                            formatter: function() {
                                return this.y;
                            }
                            }
                        }];

                        const chart = Highcharts.chart('container1', {
                            title: {
                                text: 'สรุปลูกค้าเข้าชมโครงการในปี ' + moment().add(543, 'years').format('YYYY'),
                                align: 'center'
                            },
                            xAxis: {
                                categories: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
                                title: {
                                    text: 'เดือน'
                                }
                            },
                            yAxis: {
                                title: {
                                    text: 'จำนวน'
                                },
                                allowDecimals: false,
                            },
                            series: chartSeries
                        });


                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                }),
                $.ajax({
                    type: 'GET',
                    url: '/report/booking/group/project',
                    success: function(response) {
                        const chartSeries = [];
                        const result2 = response;
                        //console.log(result2);
                            result2.forEach((booking, index) => {
                                //const month = moment(booking.booking_start).month();
                                const month = parseInt(booking.month) - 1;
                                const project_name = booking.booking_project_ref.map(p => p.name).join(', '); // นำชื่อโครงการมาต่อกันเป็น String
                                if (index === 0 || booking.project_id !== response[index - 1].project_id) {
                                    chartSeries.push({
                                        type: 'column',
                                        name: 'โครงการ ' + project_name,
                                        data: Array(12).fill(0),
                                        showInLegend: true,
                                        dataLabels: {
                                        enabled: true,
                                        color: '#000',
                                        align: 'center',
                                        formatter: function() {
                                            return this.y;
                                        }
                                        }
                                    });
                                }
                                const projectIndex = chartSeries.findIndex(series => series.name === 'โครงการ ' + project_name);
                                chartSeries[projectIndex].data[month]++;
                        });
                        const chart = Highcharts.chart('container2', {
                        title: {
                            text: 'สรุปลูกค้าเข้าแต่ละโครงการในปี ' + moment().add(543, 'years').format('YYYY'),
                            align: 'center'
                        },
                        xAxis: {
                            categories: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
                            title: {
                                text: 'เดือน'
                            }
                        },
                        yAxis: {
                            title: {
                                text: 'จำนวน'
                            },
                            allowDecimals: false,
                        },
                        series: chartSeries
                    });


                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                }),
                $.ajax({
                    type: 'GET',
                    url: '/report/booking/group/project/pie',
                    success: function(response) {
                        const chartData = [];
                        const result3 = response;
                        //console.log(result3);
                        result3.forEach(function(item) {
                            chartData.push({
                                name: item.booking_project_ref[0].name,
                                y: item.total_bookings
                            });
                        });
                        // create the chart
                        Highcharts.chart('container3', {
                            chart: {
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false,
                                type: 'pie'
                            },
                            title: {
                                text: 'สรุปภาพรวมลูกค้าเข้าชมแต่ละโครงการในปี ' + moment().add(543, 'years').format('YYYY'),
                                align: 'center'
                            },
                            tooltip: {
                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                            },
                            accessibility: {
                                point: {
                                    valueSuffix: '%'
                                }
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: true,
                                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                    }
                                }
                            },
                            series: [{
                                name: 'จำนวน',
                                colorByPoint: true,
                                data: chartData
                            }]
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                }),



            ).then(function(result1, result2, result3) {

                //console.log(result1);
                //console.log(result2);
            });




        });
    </script>
@endpush
