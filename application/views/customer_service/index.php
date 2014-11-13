<?php if (!empty($status) && empty($input_search)): ?>
    <div class="col-xs-12 " >
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong>Success!</strong> สร้างงานเรียบร้อย
        </div>
    </div>
<?php endif; ?>
<div class="col-xs-12 " >
    <div class="col-xs-12" >
        <div class="panel" >
            <div class="panel-body">
                <form class="form-inline" role="form" method="post">
                    <div class="form-group">
                        <div class="input-group col-xs-12">

                            <input required="required" class="form-control" id="input_search" name="input_search" type="text" placeholder="หมายเลขบัตรประชาชน , ชื่อ-สกุล , หมายเลขบัตรทรูการ์ด" value="<?php echo $input_search; ?>">
                            <div class="input-group-addon" style="padding: 0px;"><input type="submit" id="input_btnsearch" name="input_btnsearch" class="btn btn-default" style="padding: 10px 30px 9px;" value="ค้นหา"></input></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (count($customer_detail) > 0): ?>
    <?php if (count($customer_detail) == 1): ?>
        <?php foreach ($customer_detail as $row): ?>

            <div class="col-xs-12 " >
                <div class="col-xs-2">
                    <div class="panel" >
                        <div class="panel-body">
                            <?php if ($row->STATUS_NAME == 'A' && ( $row->CARDTYPE_NAME == 'BLACK' || $row->CARDTYPE_NAME == 'BLACK CARD')): ?>
                                <a href="<?php echo base_url('customer_service/select_service') ?>?cardid=<?php echo $row->CARDID; ?>&recid=<?php echo $row->ID; ?>"><span class="glyphicon glyphicon-plus"></span> สร้างงานใหม่</a>
                            <?php else: ?>
                                <a href="javascript:;" onclick="denied_jobmodal();"><span class="glyphicon glyphicon-plus"></span> สร้างงานใหม่</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12" >
                <div class="col-xs-6 ">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">ข้อมูลลูกค้าเบื้องต้น</h3>
                            <div class="pull-right" style="position: absolute;
                                 right: 19px;
                                 top: 0px;
                                 padding: 8px;
                                 color: #6D6D6D;">ข้อมูลอัพเดทเมื่อ : <?php echo $dataupdate; ?></div>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Column</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>ชื่อ - นามสกุล</td>
                                        <td><?php echo $row->CARDNAME; ?></td>
                                    </tr>
                                    <tr>
                                        <td>หมายเลขบัตรประชาชน</td>
                                        <td><?php echo $row->THAIID; ?></td>
                                    </tr>
                                    <tr>
                                        <td>ประเภทบัตรทรูการ์ด</td>
                                        <td><?php echo $row->CARDTYPE_NAME; ?></td>
                                    </tr>
                                    <tr>
                                        <td>หมายเลขบัตรทรูการ์ด</td>
                                        <td><?php echo $row->CARDID; ?></td>
                                    </tr>
                                    <tr>
                                        <td>วันหมดอายุบัตรทรูการ์ด</td>
                                        <td><?php echo $row->ENDDATE; ?></td>
                                    </tr>
                                    <tr>
                                        <td>สถานะ</td>
                                        <td><?php echo $row->STATUS_NAME != 'A' ? '<span style="color:red">' . $row->STATUS_DESCRIPTION . '<span>' : '<span style="color:green">' . $row->STATUS_DESCRIPTION . '<span>'; ?></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="col-xs-6"style="padding-left: 0px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">บริการทั้งหมดของลูกค้า</h3>
                        </div>
                        <div class="panel-body" style="height: 308px;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ประเภทสินค้า</th>
                                        <th>หมายเลขสินค้า</th>
                                    </tr>
                                </thead>
                                <tbody id="t_prodinfo">

                                </tbody>

                            </table>

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
                            <input type="hidden" id="offset" value="<?php echo count($customer_activity) + 1 ?>" />
                            <input type="hidden" id="cardid" value="<?php echo $cardid ?>" />
                            <table class="table" style="width:1500px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>#</th>
                                        <th>สถานะ</th>
                                        <th>ประเภทการใช้บริการ</th>
                                        <th>รายละเอียดเพิ่มเติม</th>
                                        <th>ผู้ให้บริการ</th>
                                        <th>วันที่ทำรายการ</th>
                                        <th>วันที่ขอรับบริการ</th>
                                        <th>ผู้แก้ไข</th>
                                        <th>วันที่แก้ไข</th>
                                    </tr>
                                </thead>
                                <tbody id="cust_activity">
                                    <?php if (count($customer_activity) > 0): ?>
                                        <?php
                                        $i = 1;
                                        foreach ($customer_activity as $each):
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><a href="javascript:;" onclick="open_activity_detail('<?php echo $each->ACTIVITY_ID; ?>');">แก้ไข</a></td>

                                                <?php if ($each->JOBSTATUS_ID != 1 && $each->JOBSTATUS_ID != 5 && $each->JOBSTATUS_ID != 6): ?>
                                                    <td style="color:green;"><?php echo $each->JOBSTATUS_NAME; ?></td>
                                                <?php else: ?>
                                                    <td style="color:#C4C4C4;"><?php echo $each->JOBSTATUS_NAME; ?></td>
                                                <?php endif; ?>

                                                <td><?php echo $each->SERVICE_NAME; ?></td>
                                                <td><?php echo $each->ACTIVITY_NOTE == null ? '' : read_clob($each->ACTIVITY_NOTE); ?></td>
                                                <td><a href="<?php echo base_url(); ?>user_data/userdetail?userid=<?php echo $each->CREATEUSER_ID; ?>" style="color: #5D7CCC;text-decoration: underline;"><?php echo $each->CREATEUSER_FULLNAME; ?></a></td>
                                                <td><?php echo $each->ACTIVITY_CREATEDATE; ?></td>
                                                <td><?php echo $each->ACTIVITY_DUEDATE; ?></td>
                                                <td><?php echo $each->UPDATEUSER_FULLNAME == '' ? '-' : $each->UPDATEUSER_FULLNAME; ?></td>
                                                <td><?php echo $each->ACTIVITY_UPDATEDATE == null ? '-' : $each->ACTIVITY_UPDATEDATE; ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                            <center><div id="loding_state"></div><button class="btn btn-primary" id="btn_loadmore" onclick="loadmore()">LOAD MORE...</button></center>
                        </div>

                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-xs-12" >
            <div class="col-xs-12" >
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">ผลการค้นหา</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>หมายเลขบัตรประชาชน</th>
                                    <th>ชื่อ - สกุล</th>
                                    <th>หมายเลขบัตรทรูการ์ด</th>
                                    <th>วันหมดอายุบัตร</th>
                                    <th>สถานะบัตร</th>
                                </tr>
                            </thead>
                            <?php foreach ($customer_detail as $row): ?>
                                <tr>
                                    <?php if ($row->status_name == 'A'): ?>
                                        <td><a href="?cardid=<?php echo $row->cardid; ?>&recid=<?php echo $row->recid; ?>"><span class="glyphicon glyphicon-search"></span></a></td>
                                    <?php else: ?>
                                        <td></td>
                                    <?php endif; ?>
                                    <td> <?php echo $row->thaiid; ?></td>
                                    <td> <?php echo $row->cardname; ?></td>
                                    <td> <?php echo $row->cardid; ?></td>
                                    <td> <?php echo date('d/m/Y', strtotime($row->enddate)); ?></td>
                                    <td> <?php echo $row->status_name != 'A' ? '<span style="color:red">' . $row->status_description . '<span>' : '<span style="color:green">' . $row->status_description . '<span>'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" id="offset" />

                </div>
            </div>
        </div>

    <?php endif; ?>
<?php else: ?>

    <?php if ($datanotfound): ?>
        <div class="notruecard_popup">ไม่มีข้อมูลทรูการ์ดของลูกค้าท่านนี้</div>
    <?php else: ?>
        <h1 class="emptydata">EMPTY DATA</h1>
    <?php endif; ?>
<?php endif; ?>


<!-- Modal -->
<div class="modal fade" id="service_detail_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="form_apply_job"  >
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
                    <input type="button"  onclick="apply_job();" id="input_btneditstatus" name="input_btneditstatus" class="btn btn-primary" value="Save changes" />
                </div>
            </form>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="denied_job_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="form_apply_job" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">แจ้งเตือน !</h4>
                </div>
                <div class="modal-body">
                    <h1 style="font-size: 18px;
                        text-align: center;
                        color: red;">สถานะบัตรทรูการ์ดนี้ไม่สามารถทำรายการได้</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
            dataType: "json",
            success: function(data) {
                console.log(data);
                if (data != null) {
                    if (data.result == true) {
                        location.href = '<?php echo base_url(); ?>' + 'index.php/customer_service/index?status=editsuccess&cardid=<?php echo $cardid; ?>';
                    }
                }
            },
            error: function(XMLHttpRequest) {
                alert(XMLHttpRequest.status);
                console.log(XMLHttpRequest.status);
            }
        });

    }
    $(document).ready(function() {
        $('#btn_loadmore').show();
        foo();
        foorepair_cust();
        $("#input_search").combogrid({
            url: "<?php echo base_url(); ?>" + "index.php/service/getcustomer",
            debug: false,
            sord: false,
            width: "80%",
            //replaceNull: true,
            colModel: [{'columnName': 'CUSTOMER_THAIID', 'label': 'THAI ID'}
                , {'columnName': 'CUSTOMER_TRUECARDID', 'label': 'TRUE CARD NO.'}
                , {'columnName': 'CUSTOMER_NAME', 'label': 'CUSTOMER NAME'}
                , {'columnName': 'CARDTYPE_NAME', 'label': 'CARD TYPE'}
                , {'columnName': 'STATUS', 'label': 'STATUS'}
                , {'columnName': 'CARDTYPE_EXPIRED', 'label': 'EXPIRED DATE'}],
            select: function(event, ui) {
                $("#input_search").val(ui.item.CUSTOMER_TRUECARDID + ' - ' + ui.item.CUSTOMER_NAME);
                // alert(ui.item.customername);
                return false;
            }
        });
    });

    foorepair_cust = function repair_cust() {
        $.ajax({
            url: "<?php echo base_url(); ?>" + "index.php/service/repair_customercard",
            type: "POST",
            dataType: "json",
            success: function(data) {
                //console.log(data.result);
            },
            error: function(XMLHttpRequest) {
                foorepair_cust();
            }
        });
    };

    function denied_jobmodal() {
        $('#denied_job_modal').modal('show');
    }

    function open_activity_detail(id) {
        $('#activity_id').val(id);

        $.ajax({
            url: "<?php echo base_url(); ?>" + "index.php/service/getactivity_byid?cardid=" + <?php echo $cardid; ?>,
            type: "POST",
            data: {'id': id},
            dataType: "json",
            success: function(data) {
                //console.log(data);
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

    foo = function  loaduser_service() {
        $('#t_prodinfo').html('<tr><td  colspan="3"><center><img src="<?php echo base_url(); ?>public/images/loading.gif" /></center></td></tr>');
        $.ajax({
            url: "<?php echo base_url(); ?>" + "index.php/service/getcustomer_product",
            data: {'thaiid': '<?php echo $customer_detail[0]->THAIID; ?>'},
            type: "POST",
            dataType: "html",
            success: function(data) {
                $('#t_prodinfo').html(data);
            },
            error: function(XMLHttpRequest) {
                foo();
            }
        });
    };

    function   loadmore() {
        $('#loding_state').html('<img src="<?php echo base_url(); ?>public/images/loading.gif" />');
        var offset = parseInt($('#offset').val());
        var cardid = $('#cardid').val();
        $.ajax({
            url: "<?php echo base_url(); ?>" + "index.php/service/getactivity",
            type: "POST",
            data: {'cardid': cardid, 'offset': offset, 'limit': 20},
            dataType: "html",
            success: function(data) {
                $('#loding_state').html('');
                if (data != '') {
                    $('#btn_loadmore').show();
                    $('#cust_activity').append(data);
                    offset = parseInt($('#offset').val()) + 20;
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

</script>

