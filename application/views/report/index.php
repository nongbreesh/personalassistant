<script src="<?php echo base_url() ?>public/js/highcharts.js"></script>
<script src="<?php echo base_url() ?>public/js/modules/exporting.js"></script>




<div class="col-xs-4" >
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">MONTHLY JOB STATUS</h3>
        </div>
        <div class="panel-body">
            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>
</div>


<div class="col-xs-8" >
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">MONTHLY JOB CREATE</h3>
        </div>
        <div class="panel-body">
            <div id="container_create_by_month" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>
</div>

<div class="col-xs-4" >
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">YEARLY JOB STATUS</h3>
        </div>
        <div class="panel-body">
            <div id="container_status_by_year" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>
</div>


<div class="col-xs-8" >
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">MONTHLY JOB STATUS</h3>
        </div>
        <div class="panel-body">
            <div id="container_monthly" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $.ajax({
            url: "<?php echo base_url(); ?>" + "index.php/service/getjobreport",
            type: "POST",
            dataType: "json",
            success: function(data) {

                $('#container_status_by_year').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'สถานะงานรายปี'
                    },
                    subtitle: {
                        text: ''
                    },
                    yAxis: {
                        title: {
                            text: 'Jobs total'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: true
                        }
                    },
                    series: [{
                            name: 'overdue',
                            color: '#F00000',
                            data: [parseInt(data.y_overdue)
                            ]
                        }, {
                            name: 'ปิด',
                            color: '#26A65B',
                            data: [parseInt(data.y_close)]
                        }, {
                            name: 'ติดต่อกลับ',
                            data: [parseInt(data.y_callback)]
                        }, {
                            name: 'รอจัดส่ง',
                            color: '#6C7A89',
                            data: [parseInt(data.y_waiting)]
                        }, {
                            name: 'เปิด',
                            color: '#F9BF3B',
                            data: [parseInt(data.y_open)]
                        }, {
                            name: 'ยกเลิก',
                            color: '#52B3D9',
                            data: [parseInt(data.cancel)]
                        }]
                });

                $('#container').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'สถานะงานรายเดือน'
                    },
                    subtitle: {
                        text: ''
                    },
                    yAxis: {
                        title: {
                            text: 'Jobs total'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: true
                        }
                    },
                    series: [{
                            name: 'overdue',
                            color: '#F00000',
                            data: [parseInt(data.overdue)
                            ]
                        }, {
                            name: 'ปิด',
                            color: '#26A65B',
                            data: [parseInt(data.close)]
                        }, {
                            name: 'ติดต่อกลับ',
                            data: [parseInt(data.callback)]
                        }, {
                            name: 'รอจัดส่ง',
                            color: '#6C7A89',
                            data: [parseInt(data.waiting)]
                        }, {
                            name: 'เปิด',
                            color: '#F9BF3B',
                            data: [parseInt(data.open)]
                        }, {
                            name: 'ยกเลิก',
                            color: '#52B3D9',
                            data: [parseInt(data.cancel)]
                        }]
                });

                var xmonthlyLabel = [];
                var monthlySeries_close = [];
                var monthlySeries_callback = [];
                var monthlySeries_waiting = [];
                var monthlySeries_open = [];
                var monthlySeries_cancel = [];
                for (var i = 0; i < data.monthly_report.length; i++) {
                    xmonthlyLabel.push(data.monthly_report[i].EACH_DATE);
                    monthlySeries_close.push(parseInt(data.monthly_report[i].FCLOSE));
                    //i++;
                }
                for (var i = 0; i < data.monthly_report.length; i++) {
                    monthlySeries_callback.push(parseInt(data.monthly_report[i].FCALLBACK));
                    //i++;
                }
                for (var i = 0; i < data.monthly_report.length; i++) {
                    monthlySeries_waiting.push(parseInt(data.monthly_report[i].FWAITING));
                    //i++;
                }
                for (var i = 0; i < data.monthly_report.length; i++) {
                    monthlySeries_open.push(parseInt(data.monthly_report[i].FOPEN));
                    //i++;
                }
                for (var i = 0; i < data.monthly_report.length; i++) {
                    monthlySeries_cancel.push(parseInt(data.monthly_report[i].FCANCEL));
                    //i++;
                }

                console.log(data.monthly_report);

                $('#container_monthly').highcharts({
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'กราฟแสดงสถานะงานรายเดือน'
                    },
                    xAxis: {
                        categories: xmonthlyLabel
                    },
                    yAxis: {
                        title: {
                            text: 'Jobs total'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: true
                        }
                    },
                    series: [{
                            name: ['เปิด'],
                            color: '#F9BF3B',
                            data: monthlySeries_open
                        }, {
                            name: 'ปิด',
                            color: '#26A65B',
                            data: monthlySeries_close
                        }, {
                            name: 'ติดต่อกลับ',
                            data: monthlySeries_callback
                        }, {
                            name: 'รอจัดส่ง',
                            color: '#6C7A89',
                            data: monthlySeries_waiting
                        }, {
                            name: 'ยกเลิก',
                            color: '#52B3D9',
                            data: monthlySeries_cancel
                        }]
                });


                var xopenmonthlyLabel = [];
                var openmonthlySeries_open = [];
                for (var i = 0; i < data.createjob_report.length; i++) {
                    xopenmonthlyLabel.push(data.createjob_report[i].EACH_DATE);
                    openmonthlySeries_open.push(parseInt(data.createjob_report[i].FOPEN));
                    //i++;
                }
                //console.log(openmonthlySeries_open);




                $('#container_create_by_month').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'กราฟแสดงสถานะการเปิดงานประจำเดือน'
                    },
                    xAxis: {
                        categories: xopenmonthlyLabel
                    },
                    yAxis: {
                        title: {
                            text: 'Jobs total'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: true
                        }
                    },
                    series: [{
                            name: ['จำนวนงานที่เปิดในแต่ละวัน'],
                            color: '#F9BF3B',
                            data: openmonthlySeries_open
                        }]
                });

            },
            error: function(XMLHttpRequest) {
            }
        });




    });
</script>