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
            <small>ทีม / สายงาน</small>
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
            <div class="col-md-12 col-xs-12">

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
                // Team is booking
                $.ajax({
                    type: 'GET',
                    url: '/report/booking/team',
                    success: function(response) {
                        const chartSeries = [];
                        const result1 = response;

                        result1.forEach((booking, index) => {
                               //const month = moment(booking.booking_start).month()-1;
                               const month = parseInt(booking.month) - 1;
                               let teamName = 'ทีม ' + booking.team_name;


                                chartSeries.push({
                                    type: 'column',
                                    name: teamName,
                                    data: Array(12).fill(0),
                                    //showInLegend: true,
                                    dataLabels: {
                                        enabled: true,
                                        color: '#000',
                                        align: 'center',
                                        formatter: function() {
                                            return this.y;
                                        }
                                    },
                                });


                                    // อัพเดทข้อมูล series
                                const teamIndex = chartSeries.findIndex(series => series.name === teamName);
                                chartSeries[teamIndex].data[month]++;
                        });

                        const chart = Highcharts.chart('container1', {
                        title: {
                            text: 'สรุปลูกค้าเข้าชมโครงการแยกแต่ละทีมในปี ' + moment().add(543, 'years').format('YYYY'),
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
                    url: '/report/booking/subteam',
                    success: function(response) {
                        const chartSeries = [];
                        const result2 = response;
                        console.log(result2);
                        result2.forEach((booking, index) => {
                                //const month = moment(booking.booking_start).month();
                                const month = parseInt(booking.month) - 1;
                                chartSeries.push({
                                    type: 'column',
                                    name: 'สายงาน ' + booking.subteam_name,
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

                                const SubTeamIndex = chartSeries.findIndex(series => series.name === 'สายงาน ' + booking.subteam_name);
                                chartSeries[SubTeamIndex].data[month]++;
                        });

                        const chart = Highcharts.chart('container2', {
                        title: {
                            text: 'สรุปลูกค้าเข้าชมโครงการแยกแต่ละสายงานในปี ' + moment().add(543, 'years').format('YYYY'),
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

                // Team null booking
                // $.ajax({
                //     type: 'GET',
                //     url: '/report/booking/team',
                //     success: function(response) {
                //         const result1 = response;
                //         const chart = Highcharts.chart('container1', {
                //             title: {
                //                 text: 'สรุปลูกค้านัดเข้าชมแต่ละทีมในปี ' + moment().add(543, 'years').format('YYYY'),
                //                 align: 'center'
                //             },
                //             xAxis: {
                //                 categories: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
                //                 title: {
                //                     text: 'เดือน'
                //                 }
                //             },
                //             yAxis: {
                //                 title: {
                //                     text: 'จำนวน'
                //                 },
                //                 allowDecimals: false,
                //             },
                //         });

                //         const teams = [...new Set(result1.map(booking => booking.team_name))];

                //         teams.forEach(team => {
                //             const teamBookings = result1.filter(booking => booking.team_name === team);
                //             const data = Array(12).fill(0);

                //             teamBookings.forEach(booking => {
                //                 const month = parseInt(booking.month) - 1;
                //                 data[month] = booking.total_bookings;
                //             });

                //             chart.addSeries({
                //                 type: 'column',
                //                 name: 'ทีม ' + team,
                //                 data: data,
                //                 showInLegend: true,
                //                 dataLabels: {
                //                     enabled: true,
                //                     color: '#000',
                //                     align: 'center',
                //                     formatter: function() {
                //                         return this.y;
                //                     }
                //                 }
                //             });
                //         });
                //     },
                //     error: function(xhr) {
                //         console.log(xhr.responseText);
                //     }
                // });





            ).then(function(result1,result2) {

                //console.log(result1);
                //console.log(result2);
            });




        });
    </script>
@endpush
