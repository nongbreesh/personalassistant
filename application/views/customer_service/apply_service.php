<div class="col-xs-12 " >
    <div class="col-xs-2">
        <div class="panel" >
            <div class="panel-body">
                <a href="javascript:;" onclick="history.back();"><span class="glyphicon glyphicon-backward"></span> ย้อนกลับ</a>
            </div>
        </div>
    </div>
    <div class="col-xs-5">
        <div class="panel"  style="background: #222">
            <div class="panel-body">
                <div class="priviledge-cardname"><span style="color:#fff;"><span class="glyphicon glyphicon-road"></span>  Customer in line : </span> <?php echo $customer_detail->CARDNAME; ?></div>
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 " >
    <!-- <?php if ($service->SERVICE_POINTQUOTA == 0 && $service->SERVICE_POINTHOLDER == 0): ?>
         <div class="col-xs-2">
             <div class="panel" >
                 <div class="panel-body">
                     <a  href="javascript:;" onclick="open_modal1('<?php echo $service->SERVICE_ID ?>');"><span class="glyphicon glyphicon-plus"></span> Apply service</a>
                 </div>
             </div>
         </div>
    <?php elseif ($totalpoint > 0 && $service_totalpoint > 0): ?>
                                     <div class="col-xs-2">
                                         <div class="panel" >
                                             <div class="panel-body">
                                                 <a  href="javascript:;" onclick="open_modal1('<?php echo $service->SERVICE_ID ?>');"><span class="glyphicon glyphicon-plus"></span> Apply service</a>
                                             </div>
                                         </div>
                                     </div>
    <?php endif; ?>-->
    <div class="col-xs-2">
        <div class="panel" >
            <div class="panel-body">
                <a  href="javascript:;" onclick="open_modal1('<?php echo $service->SERVICE_ID ?>');"><span class="glyphicon glyphicon-plus"></span> Apply service</a>
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="panel" >
            <div class="panel-body">
                <a href="<?php echo base_url() ?>dashboard" target="_blank"><span class="glyphicon glyphicon-search"></span> Search privilege</a>
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="panel" >
            <div class="panel-body" style="min-height:54px;
                 padding: 13px;
                 text-align: center;
                 ">
                     <?php
                     if ($service_totalpoint <= 0):
                         ?>
                    <div style="color: red;
                         font-size: 18px;
                         padding: 0px;
                         ">สิทธิ์ของบริการในเดือนนี้เต็มแล้ว</div>

                <?php elseif ($totalpoint <= 0 && $service->SERVICE_POINTHOLDER > 0): ?>
                    <div style="color: red;
                         font-size: 18px;
                         padding: 0px;
                         ">ลูกค้าท่านนี้ใช้สิทธิ์ของเดือนนี้ครบกำหนดแล้ว</div>
                     <?php else: ?>
                         <?php if ($service->SERVICE_POINTQUOTA == 0 && $service->SERVICE_POINTHOLDER == 0): ?>
                        <div style="color: green;
                             font-size: 18px;
                             padding: 0px;
                             ">บริการนี้ไม่จำกัดสิทธิ์</div>
                         <?php else: ?>
                        <div style="color: green;
                             font-size: 18px;
                             padding: 0px;
                             ">สิทธิ์เดือนปัจจุบันของเดือนนี้คงเหลือ <?php echo $totalpoint; ?>/<?php echo $service->SERVICE_POINTHOLDER; ?></div>
                         <?php endif; ?>
                     <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 " >
    <div class="col-xs-8" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><span style="color: #7A7A7A;">ข้อมูลเบื้องต้น</span> : <span style="color: #6D7DD1;"><?php echo $service->SERVICE_NAME; ?></span></h3>

            </div>
            <div class="panel-body">
                <div class="panel-group" id="accordion">
                    <?php if (count($article) > 0): ?>
                        <?php foreach ($article as $each):
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $each->ARTICLE_ID; ?>">
                                            <?php echo $each->ARTICLE_TITLE; ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse<?php echo $each->ARTICLE_ID; ?>" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php echo read_clob($each->ARTICLE_DESCRIPTION); ?>    
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?php echo read_clob($service->SERVICE_SCRIPT); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-4" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">จำนวนสิทธิ์รายเดือน</h3>
            </div>
            <div class="panel-body">
                <ul>

                    <?php foreach ($nextmonth as $each): ?>
                        <li><?php echo $method->mapmonth($each) ?>  <?php echo $method->get_userservice_totalpoint($service->SERVICE_ID, $each, $cardid) ?></li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Partner link</h3>
            </div>
            <div class="panel-body">
                <ul>
                    <?php if (count($service_partner) > 0): ?>
                        <?php foreach ($service_partner as $each): ?>
                            <li><a href="<?php echo read_clob($each->PARTNER_LINK) ?>" target="_blank"><?php echo $each->PARTNER_NAME ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Last transaction</h3>
            </div>
            <div class="panel-body">
                <ul style="list-style: none; margin: 0px;padding: 0px;">
                    <?php if (count($customer_activity) > 0): ?>
                        <?php foreach ($customer_activity as $each): ?>
                            <li><a href="javascript:;" onclick="open_activity_detail('<?php echo $each->ACTIVITY_ID; ?>');"><span class="glyphicon glyphicon-search"></span></a> <?php echo $each->ACTIVITY_CREATEDATE; ?> โดย <a href="<?php echo base_url(); ?>user_data/userdetail?userid=<?php echo $each->CREATEUSER_ID; ?>" style="color: #5D7CCC;text-decoration: underline;"><?php echo $each->CREATEUSER_FULLNAME; ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="service_detail_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="form_apply_job" onsubmit="return apply_service();" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">บันทึกงาน ของคุณ <span style="font-size: 16px;"><?php echo $customer_detail->CARDNAME; ?></span></h4>

                </div>
                <div class="modal-body col-xs-12">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="input_jobstatus">สถานะงาน</label><span style="color:red;font-size:16px;">*</span>
                            <select   required="required" class="form-control"  id="input_jobstatus" name="input_jobstatus" >
                                <option value="">--- Select one ----</option>
                                <?php foreach ($jobstatus as $each) { ?>
                                    <option value="<?php echo $each->JOBSTATUS_ID; ?>"><?php echo $each->JOBSTATUS_NAME; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-xs-6" id="main_detail">

                        <div class="form-group">
                            <label for="input_contactname">ชื่อ-สกุล ผู้ติดต่อ</label><span style="color:red;font-size:16px;">*</span>
                            <input  required="required" type="text" class="form-control" id="input_contactname" name="input_contactname" placeholder="ระบุชื่อ-นามสกุลผู้ที่จะติดต่อกลับ"  />
                        </div>
                        <div class="form-group">
                            <label for="input_contactnumber">เบอร์ติดต่อ</label><span style="color:red;font-size:16px;">*</span>
                            <input   required="required" type="text" class="form-control" id="input_contactnumber" name="input_contactnumber" placeholder="ระบุเบอร์โทรศัพท์" >
                        </div>
                        <div class="form-group">
                            <label for="input_contactemail">email</label>
                            <input type="email" class="form-control" id="input_contactemail" name="input_contactemail"  placeholder="ระบุอีเมลล์">
                        </div>
                    </div>

                    <div class="col-xs-6" id="more_question">
                        <div class="form-group">
                            <label for="input_note2">รายละเอียดเพิ่มเติม</label>
                            <textarea  type="text" class="form-control" id="input_note2" name="input_note2" placeholder="ระบุรายละเอียดเพิ่มเติม"></textarea>
                        </div>
                    </div>


                    <div class="col-xs-6" id="additional_detail">


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
                        <div class="form-group">
                            <label for="input_howclosejob">วิธีปิดงาน <span style="color:red;font-size:16px;">*</span></label>
                            <select  required="required" class="form-control"  id="input_howclosejob" name="input_howclosejob" >
                                <option value="">--- Select one ----</option>
                                <option value="NONE">NONE</option>
                                <option value="SMS">ส่ง SMS</option>
                                <option value="CALLBACK">โทรกลับ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="input_note">รายละเอียดเพิ่มเติม</label>
                            <textarea  type="text" class="form-control" id="input_note" name="input_note" placeholder="ระบุรายละเอียดเพิ่มเติม"></textarea>
                        </div>

                    </div>

                    <div class="col-xs-12" id="customfield_detail">
                        <?php if (count($customfields) > 0): ?>
                            <?php foreach ($customfields as $each): ?> 
                                <div class="form-group">
                                    <label for="<?php echo $each->CUSTOM_FIELD_NAME; ?>"><?php echo $each->CUSTOM_FIELD_LABEL; ?></label><?php echo $each->CUSTOM_FIELD_ISMANDATORY == 1 ? '<span style="color:red;font-size:16px;">*</span>' : ''; ?>
                                    <?php if ($each->CUSTOM_FIELD_TYPE == 'text') : ?>
                                        <input <?php echo $each->CUSTOM_FIELD_ISMANDATORY == 1 ? 'required="required"' : ''; ?> type="text" class="form-control" id="<?php echo $each->CUSTOM_FIELD_NAME; ?>" name="<?php echo $each->CUSTOM_FIELD_NAME; ?>" placeholder="<?php echo $each->CUSTOM_FIELD_PLACEHOLDER; ?>"/>
                                    <?php elseif ($each->CUSTOM_FIELD_TYPE == 'textarea') : ?>
                                        <textarea  <?php echo $each->CUSTOM_FIELD_ISMANDATORY == 1 ? 'required="required"' : ''; ?> type="text" class="form-control" id="<?php echo $each->CUSTOM_FIELD_NAME; ?>" name="<?php echo $each->CUSTOM_FIELD_NAME; ?>"  placeholder="<?php echo $each->CUSTOM_FIELD_PLACEHOLDER; ?>"></textarea>
                                    <?php elseif ($each->CUSTOM_FIELD_TYPE == 'date'): ?>
                                        <input <?php echo $each->CUSTOM_FIELD_ISMANDATORY == 1 ? 'required="required"' : ''; ?> type="datetime" class="form-control" id="<?php echo $each->CUSTOM_FIELD_NAME; ?>" name="<?php echo $each->CUSTOM_FIELD_NAME; ?>"  placeholder="<?php echo $each->CUSTOM_FIELD_PLACEHOLDER; ?>"/>
                                    <?php elseif ($each->CUSTOM_FIELD_TYPE == 'number'): ?>
                                        <input <?php echo $each->CUSTOM_FIELD_ISMANDATORY == 1 ? 'required="required"' : ''; ?> type="number" class="form-control" id="<?php echo $each->CUSTOM_FIELD_NAME; ?>" name="<?php echo $each->CUSTOM_FIELD_NAME; ?>"  placeholder="<?php echo $each->CUSTOM_FIELD_PLACEHOLDER; ?>"/>
                                    <?php endif; ?> 
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?> 
                    </div>

                </div>
                <div style="clear: both;"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn_act_save">Save changes</button> 
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    function apply_service() {
        $('#btn_act_save').attr('disabled', 'disabled');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "index.php/service/apply_service?cardid=" + <?php echo $cardid; ?> + "&serviceid=" + <?php echo $service->SERVICE_ID; ?>,
            data: $('#form_apply_job').serialize(),
            dataType: "json",
            success: function(data) {
                //console.log(data.result);
                if (data != null) {
                    if (data.result != false) {
                        location.href = '<?php echo base_url(); ?>' + 'index.php/customer_service/index?status=success&cardid=' + <?php echo $cardid; ?>;
                    }
                    else {
                        alert(data.msg);
                        $('#btn_act_save').removeAttr('disabled');
                    }
                }
            },
            error: function(XMLHttpRequest) {
                alert(XMLHttpRequest.status);
                //console.log(XMLHttpRequest.status);
                $('#btn_act_save').removeAttr('disabled');
            }
        });
        return false;
    }

    $(document).ready(function() {

        $('#more_question').hide();
        $('#input_jobstatus').change(function() {
            if ($(this).val() == '6') {
                //$('#main_detail').hide();
                $('#additional_detail').hide();
                $('#customfield_detail').hide();
                $('#more_question').show();


                /*  $("#main_detail :input").each(function() {
                 if ($(this).is("select")) {
                 $(this).prop("selectedIndex", 1);
                 }
                 else if ($(this).is("[type=email]")) {
                 $(this).val('customer@question.com');
                 }
                 else {
                 $(this).val('0');
                 }
                 });*/
                $("#additional_detail :input").each(function() {
                    if ($(this).is("select")) {
                        $(this).prop("selectedIndex", 1);
                    }
                    else if ($(this).is("[type=email]")) {
                        $(this).val('customer@question.com');
                    }
                    else {
                        $(this).val('0');
                    }
                });
                $("#customfield_detail :input").each(function() {
                    if ($(this).is("select")) {
                        $(this).prop("selectedIndex", 1);
                    }
                    else if ($(this).is("[type=email]")) {
                        $(this).val('customer@question.com');
                    }
                    else {
                        $(this).val('0');
                    }
                });

            }
            else {

                /* $("#main_detail :input").each(function() {
                 if ($(this).is("select")) {
                 $(this).prop("selectedIndex", 0);
                 }
                 else if ($(this).is("[type=email]")) {
                 $(this).val('');
                 }
                 else {
                 $(this).val('');
                 }
                 });*/
                $("#additional_detail :input").each(function() {
                    if ($(this).is("select")) {
                        $(this).prop("selectedIndex", 0);
                    }
                    else if ($(this).is("[type=email]")) {
                        $(this).val('');
                    }
                    else {
                        $(this).val('');
                    }
                });
                $("#customfield_detail :input").each(function() {
                    if ($(this).is("select")) {
                        $(this).prop("selectedIndex", 0);
                    }
                    else if ($(this).is("[type=email]")) {
                        $(this).val('');
                    }
                    else {
                        $(this).val('');
                    }
                });


                // $('#main_detail').show();
                $('#additional_detail').show();
                $('#customfield_detail').show();
                $('#more_question').hide();
            }
        });
    });


    function open_modal1(id) {
        $('#btn_act_save').show();
        //$('#form_apply_job').closest('form').find("input[type=text],input[type=email],input[type=number],input[type=datetime], textarea,select").val("");
        $('#service_detail_modal').modal('show');

    }

    function open_activity_detail(id) {
        $('#activity_id').val(id);
        $.ajax({
            url: "<?php echo base_url(); ?>" + "index.php/service/getactivity_byid?cardid=" + <?php echo $cardid; ?>,
            type: "POST",
            data: {'id': id},
            dataType: "json",
            success: function(data) {

                console.log(data);
                $('#btn_act_save').hide();
                if (data.result.ACTIVITY_JOBSTATUS == '6') {
                    //$('#main_detail').hide();
                    $('#additional_detail').hide();
                    $('#customfield_detail').hide();
                    $('#more_question').show();


                    /*  $("#main_detail :input").each(function() {
                     if ($(this).is("select")) {
                     $(this).prop("selectedIndex", 1);
                     }
                     else if ($(this).is("[type=email]")) {
                     $(this).val('customer@question.com');
                     }
                     else {
                     $(this).val('0');
                     }
                     });*/
                    $("#additional_detail :input").each(function() {
                        if ($(this).is("select")) {
                            $(this).prop("selectedIndex", 1);
                        }
                        else if ($(this).is("[type=email]")) {
                            $(this).val('customer@question.com');
                        }
                        else {
                            $(this).val('0');
                        }
                    });
                    $("#customfield_detail :input").each(function() {
                        if ($(this).is("select")) {
                            $(this).prop("selectedIndex", 1);
                        }
                        else if ($(this).is("[type=email]")) {
                            $(this).val('customer@question.com');
                        }
                        else {
                            $(this).val('0');
                        }
                    });

                }
                else {

                    /* $("#main_detail :input").each(function() {
                     if ($(this).is("select")) {
                     $(this).prop("selectedIndex", 0);
                     }
                     else if ($(this).is("[type=email]")) {
                     $(this).val('');
                     }
                     else {
                     $(this).val('');
                     }
                     });*/
                    $("#additional_detail :input").each(function() {
                        if ($(this).is("select")) {
                            $(this).prop("selectedIndex", 0);
                        }
                        else if ($(this).is("[type=email]")) {
                            $(this).val('');
                        }
                        else {
                            $(this).val('');
                        }
                    });
                    $("#customfield_detail :input").each(function() {
                        if ($(this).is("select")) {
                            $(this).prop("selectedIndex", 0);
                        }
                        else if ($(this).is("[type=email]")) {
                            $(this).val('');
                        }
                        else {
                            $(this).val('');
                        }
                    });


                    // $('#main_detail').show();
                    $('#additional_detail').show();
                    $('#customfield_detail').show();
                    $('#more_question').hide();
                }

                $('#input_jobstatus').val(data.result.ACTIVITY_JOBSTATUS);
                if (data.result.ACTIVITY_DUEDATE != null) {
                    $('#input_duedate').val(data.result.ACTIVITY_DUEDATE.substr(0, 10));
                    $('#input_duetime').val(data.result.ACTIVITY_DUEDATE.substr(11, 5));
                }
                $('#input_note').val(data.result.ACTIVITY_NOTE);
                $('#input_note2').val(data.result.ACTIVITY_NOTE);
                $('#input_contactname').val(data.result.ACTIVITY_CONTACTNAME);
                $('#input_contactnumber').val(data.result.ACTIVITY_CONTACTNUMBER);
                $('#input_contactemail').val(data.result.ACTIVITY_CONTACTEMAIL);

                if (data.result.ACTIVITY_CUSTOMFIELD != null) {
                    var customf = data.result.ACTIVITY_CUSTOMFIELD.split(";");
                    //console.log(customf);
                    for (i = 0; i < customf.length - 1; i++) {
                        try {
                            $('#' + customf[i].split(",")[0]).val(customf[i].split(",")[2]);
                        }
                        catch (e) {
                        }
                    }
                }


                $('#service_detail_modal').modal('show');

            },
            error: function(XMLHttpRequest) {
                //$.growl(XMLHttpRequest.status, {type: 'danger'}); //danger , info , warning
            }
        });


    }

</script>

