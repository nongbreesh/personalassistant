<?php if (!empty($status) && empty($input_search)): ?>
    <div class="col-xs-12 " >
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong>Success!</strong> แก้ไขงานเรียบร้อย
        </div>
    </div>
<?php endif; ?>
<input id="current_jobstatus"  type="hidden"/>
<input id="userid"  type="hidden"/>
<div class="col-xs-12 " >
    <div class="col-xs-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">เลือกประเภทบริการ</h3>
            </div>
            <div class="panel-body">
                <div class="form-inline col-xs-6">
                    <input type="checkbox" id="selfjob" name="selfjob" value="selfjob"/> <label for="selfjob"><b><u>[งานของฉัน]</u></b></label>
                </div>
                <?php foreach ($service as $each): ?>
                    <div class="form-inline col-xs-6">
                        <input type="checkbox" id="input_service<?php echo $each->SERVICE_ID; ?>" name="input_service<?php echo $each->SERVICE_ID; ?>" value="<?php echo $each->SERVICE_ID; ?>"/> <label for="input_service<?php echo $each->SERVICE_ID; ?>"><?php echo $each->SERVICE_NAME; ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>



<div class="col-xs-12" >
    <div class="col-xs-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">รายละเอียดการใช้บริการ Personal Assistant ล่าสุด</h3>
            </div>
            <div class="panel-body">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#jobstatus_detail" class="jobstatus_detail" role="tab" data-toggle="0">ทั้งหมด</a></li>
                    <li><a href="#jobstatus_detail" role="tab" class="jobstatus_detail" id="overdue"  data-toggle="9999">Overdue</a></li>
                    <?php foreach ($jobstatus as $each): ?>
                        <li><a href="#jobstatus_detail" class="jobstatus_detail" role="tab" data-toggle="<?php echo $each->JOBSTATUS_ID; ?>"><?php echo $each->JOBSTATUS_NAME; ?></a></li>
                    <?php endforeach; ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Export <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:;" onclick="openselectrangreport('CSV')"> <span class="glyphicon glyphicon-export" > CSV format</span></a></li>
                            <li><a href="javascript:;"  onclick="openselectrangreport('EXCEL')"> <span class="glyphicon glyphicon-export" > EXCEL format</span></a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="jobstatus_detail">

                        <table class="table"  style="width:1500px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>#</th>
                                    <th >สถานะ</th>
                                    <th >วันที่ due date</th>
                                    <th >ประเภทการใช้บริการ</th>
                                    <th style="width: 150px;">รายละเอียดเพิ่มเติม</th>
                                    <th >ผู้ใช้บริการ</th>
                                    <th >ผู้ให้บริการ</th>
                                    <th >กลุ่ม AGENT</th>
                                    <th >วันที่ทำรายการ</th>
                                    <th >วันที่แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody id="job_detail">


                            </tbody>
                        </table>
                    </div>
                </div>
                <input type="hidden" id="type" />
                <input type="hidden" id="status" />
                <input type="hidden" id="offset" />
                <center><div id="loding_state"></div><button class="btn btn-primary" id="btn_loadmore" onclick="loadmore()">LOAD MORE...</button></center>



            </div>
        </div>
    </div>

</div>
<!-- Modal -->
<div class="modal fade" id="service_detail_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="form_apply_job" onsubmit="return apply_job();">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">เปลี่ยนแปลงสถานะงาน</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="activity_id" name="activity_id" />
                    <div class="col-xs-12">
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="input_jobstatus">สถานะงาน</label>
                                <select required="required" class="form-control"  id="input_jobstatus" name="input_jobstatus" >
                                    <option value="">--- Select one ----</option>';
                                    <?php foreach ($jobstatus as $each) { ?>
                                        <option value="<?php echo $each->JOBSTATUS_ID; ?>"><?php echo $each->JOBSTATUS_NAME; ?></option>';
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="input_howclosejob">วิธีปิดงาน <span style="color:red;font-size:16px;">*</span></label>
                                <select  required="required" class="form-control"  id="input_howclosejob" name="input_howclosejob" >
                                    <option value="">--- Select one ----</option>';

                                    <option value="NONE">NONE</option>
                                    <option value="SMS">ส่ง SMS</option>
                                    <option value="CALLBACK">โทรกลับ</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="input_note">รายละเอียดเพิ่มเติม</label>
                                <textarea type="text" class="form-control" id="input_note" name="input_note" placeholder="ระบุรายละเอียดเพิ่มเติม"></textarea>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <strong>รายละเอียดงาน</strong>
                            <br>ชื่อ-สกุล ผู้ติดต่อ : <label id="lbl_contactname"  class='lblhilight'></label>
                            <br>เบอร์ติดต่อ : <label id="lbl_contactnumber"  class='lblhilight'></label>
                            <br>email : <label id="lbl_contactemail"  class='lblhilight'></label>
                            <br>
                            <div id="customfield_area"></div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="input_duedate">วัน/เวลา ขอรับบริการ</label><span style="color:red;font-size:16px;">*</span>
                                <br>
                                <div style="width: 130px; float: left;">
                                    <input  required="required" type="selectdate" class="form-control" id="input_duedate" name="input_duedate" data-date-format="DD/MM/YYYY" placeholder="ระบุวันที่"  /> 
                                </div>
                                <div style="width: 90px; float: left;margin-left: 10px;">
                                    <input  required="required" type="selecttime"  class="form-control"  id="input_duetime" name="input_duetime"  placeholder="ระบุเวลา"   />
                                </div>
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    <div style="clear: both;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" id="input_btneditstatus" name="input_btneditstatus" class="btn btn-primary" value="Save changes" />
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="service_rang_report" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="form_apply_job" onsubmit="return getreport();">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">เลือกช่วงเวลา</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="export_servicetype" name="export_servicetype" />
                    <div class="col-xs-12">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="input_from">From</label><span style="color:red;font-size:16px;">*</span>

                                <input  required="required" type="selectdate" class="form-control" id="input_exportfrom" name="input_exportfrom" data-date-format="DD/MM/YYYY" placeholder="ระบุวันที่"  /> 

                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="input_exportto">To</label><span style="color:red;font-size:16px;">*</span>

                                <input  required="required" type="selectdate" class="form-control" id="input_exportto" name="input_exportto" data-date-format="DD/MM/YYYY" placeholder="ระบุวันที่"  /> 

                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    <div style="clear: both;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" id="input_export" name="input_export" class="btn btn-primary" value="Export" />
                </div>
            </form>
        </div>
    </div>
</div>

<script>


    function apply_job() {
        $('#input_btneditstatus').attr('disabled', 'disabled');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "index.php/service/edit_service",
            data: $('#form_apply_job').serialize(),
            async: false,
            dataType: "json",
            success: function(data) {
                console.log(data.result);
                if (data != null) {
                    if (data.result == true) {
                        location.href = '<?php echo base_url(); ?>' + 'index.php/pending_case/index?status=success';
                    }
                }
            },
            error: function(XMLHttpRequest) {
                alert(XMLHttpRequest.status);
                console.log(XMLHttpRequest.status);
            }
        });
        return false;
    }
    $(document).ready(function() {
        $('#btn_loadmore').hide();
        var status = '<?php echo isset($_GET['status']) ? $_GET['status'] : ''; ?>';
        if (status == 'overdue') {
            $('ul.nav-tabs li').removeClass('active');
            $('#overdue').parent('li').addClass('active');
            $('#current_jobstatus').val(9999);
            $('#type').val(9999);
            $('#status').val('');
            $('#overdue').val('');
            getjob_bystatus(9999, '', '');
        }
        else {
            $('#type').val(0);
            $('#status').val('');
            getjob_bystatus(0, '', '');
        }

        $('input[type=checkbox]').click(function() {
            var status = 0;
            if ($('#current_jobstatus').val() != '') {
                var status = $('#current_jobstatus').val();
            }
            var userid = '';
            var servicetype = '';
            $.each($('input:checked'), function(index, value) {
                if ($(value).val() != 'selfjob') {
                    servicetype += $(value).val() + ',';
                }
                else {
                    userid = '<?php echo $user['user_id']; ?>';
                }
            });
            servicetype = servicetype.replace(/,\s*$/, "");

            $('#userid').val(userid);
            $('#type').val(status);
            $('#status').val(servicetype);
            getjob_bystatus(status, servicetype, userid);
        });
        $('a[role=tab]').click(function() {
            $('ul.nav-tabs li').removeClass('active');
            var status = $(this).attr('data-toggle');
            //alert(status);
            $(this).parent('li').addClass('active');
            var userid = '';
            var servicetype = '';
            $.each($('input:checked'), function(index, value) {
                if ($(value).val() != 'selfjob') {
                    servicetype += $(value).val() + ',';
                }
                else {
                    userid = '<?php echo $user['user_id']; ?>';
                }
            });
            servicetype = servicetype.replace(/,\s*$/, "");
            $('#current_jobstatus').val(status);
            $('#userid').val(userid);
            $('#type').val(status);
            $('#status').val(servicetype);
            getjob_bystatus(status, servicetype, userid);
        });
    });
    function getjob_bystatus(status, servicetype, userid) {
        $('#job_detail').html('');
        $('#loding_state').html('<img src="<?php echo base_url(); ?>public/images/loading.gif" />');
        $.ajax({
            url: "<?php echo base_url(); ?>" + "index.php/service/getjob_bystatus",
            type: "POST",
            data: {'status': status, 'servicetype': servicetype, 'offset': 0, 'limit': 30, 'userid': userid},
            dataType: "html",
            success: function(data) {
                $('#loding_state').html('');
                if (data != '') {
                    $('#btn_loadmore').show();
                    $('#job_detail').html(data);
                    $('#offset').val(30 - 1);
                }
                else {
                    $('#btn_loadmore').hide();
                }
            },
            error: function(XMLHttpRequest) {
            }
        });
    }

    function   loadmore() {
        $('#loding_state').html('<img src="<?php echo base_url(); ?>public/images/loading.gif" />');
        var status = $('#type').val();
        var servicetype = $('#status').val();
        var userid = $('#userid').val();
        var offset = parseInt($('#offset').val()) + 1;
        $.ajax({
            url: "<?php echo base_url(); ?>" + "index.php/service/getjob_bystatus",
            type: "POST",
            data: {'status': status, 'servicetype': servicetype, 'offset': offset, 'limit': 30, 'userid': userid},
            dataType: "html",
            success: function(data) {
                $('#loding_state').html('');
                if (data != '') {
                    $('#btn_loadmore').show();
                    $('#job_detail').append(data);
                    offset = parseInt($('#offset').val()) + 30;
                    $('#offset').val(offset);
                }
                else {
                    $('#btn_loadmore').hide();
                }
            },
            error: function(XMLHttpRequest) {
            }
        });
    }

    function openselectrangreport(type) {
        $('#service_rang_report').modal('show');
        $('#export_servicetype').val(type);

    }
    function getreport(type) {

        var status = $('#type').val();
        var servicetype = $('#status').val();
        var export_servicetype = $('#export_servicetype').val();
        var input_exportfrom = $('#input_exportfrom').val();
        var input_exportto = $('#input_exportto').val();


        switch (export_servicetype) {
            case 'CSV':
                location.href = '<?php echo base_url() ?>service/export_jobs/?status=' + status + '&servicetype=' + servicetype + '&userid=&from=' + input_exportfrom + '&to=' + input_exportto + '&format=CSV';
                break;
            case 'EXCEL':
                location.href = '<?php echo base_url() ?>service/export_jobs/?status=' + status + '&servicetype=' + servicetype + '&userid=&from=' + input_exportfrom + '&to=' + input_exportto + '&format=XLS';
                break;
        }
        $('#service_rang_report').modal('hide');
        return false;
    }

    function open_activity_detail(id) {
        $('#activity_id').val(id);
        $.ajax({
            url: "<?php echo base_url(); ?>" + "index.php/service/getactivity_byid",
            type: "POST",
            data: {'id': id},
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('#input_jobstatus').val(data.result.ACTIVITY_JOBSTATUS);
                if (data.result.ACTIVITY_DUEDATE != null) {
                    $('#input_duedate').val(data.result.ACTIVITY_DUEDATE.substr(0, 10));
                    $('#input_duetime').val(data.result.ACTIVITY_DUEDATE.substr(11, 5));
                }
                $('#input_note').val(data.result.ACTIVITY_NOTE);
                $('#input_howclosejob').val(data.result.ACTIVITY_HOWTOCLOSEJOB);
                $('#lbl_contactname').html(data.result.ACTIVITY_CONTACTNAME);
                $('#lbl_contactnumber').html(data.result.ACTIVITY_CONTACTNUMBER);
                $('#lbl_contactemail').html(data.result.ACTIVITY_CONTACTEMAIL);
                var customf = data.result.ACTIVITY_CUSTOMFIELD;
                if (customf == null) {
                    customf = "";
                }
                var customf = customf.split(";");
                $('#customfield_area').html('');
                $('#customfield_area').append('<hr><strong>รายละเพิ่มเติม</strong>');
                for (i = 0; i < customf.length - 1; i++) {
                    var html = "<br />" + customf[i].split(",")[1] + " : <label class='lblhilight'>" + customf[i].split(",")[2] + "</label>";
                    $('#customfield_area').append(html);
                }

                $('#service_detail_modal').modal('show');
            },
            error: function(XMLHttpRequest) {
                //$.growl(XMLHttpRequest.status, {type: 'danger'}); //danger , info , warning
            }
        });
    }
</script>