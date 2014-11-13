
<?php if (!empty($_GET['status'])): ?>
    <div class="col-xs-12 " >
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <?php if ($_GET['type'] == 'create_partner'): ?>
                <strong>Success!</strong> เพิ่ม Partner link  สำเร็จ
            <?php elseif ($_GET['type'] == 'remove_success'): ?>
                <strong>Success!</strong> ลบข้อมูล  สำเร็จ
            <?php elseif ($_GET['type'] == 'update_success'): ?>
                <strong>Success!</strong> แก้ไขข้อมูล  สำเร็จ
            <?php elseif ($_GET['type'] == 'create_service'): ?>
                <strong>Success!</strong> เพิ่มข้อมูล  สำเร็จ
            <?php elseif ($_GET['type'] == 'create_article'): ?>
                <strong>Success!</strong> เพิ่มข้อมูล  สำเร็จ
            <?php elseif ($_GET['type'] == 'create_success'): ?>
                <strong>Success!</strong> เพิ่มข้อมูล  สำเร็จ
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<div class="col-xs-12 " >
    <form method="post"  >
        <div class="col-xs-8" >

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">ข้อมูลเบื้องต้น</h3>


                </div>
                <div class="panel-body">
                    <div class="form-horizontal" style="padding: 10px;">
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">ชื่อบริการ</label>
                            <div class="col-sm-10">
                                <input required="required" type="text" class="form-control" id="input_service_name" name="input_service_name" value="<?php echo $service->SERVICE_NAME ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="service_id" name="service_id" value="<?php echo $service_id; ?>" />
                            <textarea class="ckeditor" id="service_script" name="service_script">
                                <?php echo read_clob($service->SERVICE_SCRIPT) ?>
                            </textarea>
                        </div>
                    </div>

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" style="position: relative;">
                    <h3 class="panel-title">Article list</h3>
                    <a href="javascript:;" onclick="open_articleform();"><span class="pull-right glyphicon glyphicon-plus" style="position: absolute;
                                                                               right: 15px;
                                                                               top: 10px; color: green"></span></a>
                </div>
                <div class="panel-body">
                    <ul>
                        <?php if (count($article) > 0): ?>
                            <?php foreach ($article as $each): ?>
                                <li><a href="javascript:;" onclick="return remove_article('<?php echo $each->ARTICLE_ID; ?>', '<?php echo $service_id; ?>');"><span class="pull-right glyphicon glyphicon-remove" style="color: red"></span></a><a href="javascript:;" onclick="open_articleform_edit('<?php echo $each->ARTICLE_ID ?>');" target="_blank"><?php echo $each->ARTICLE_TITLE ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" style="position: relative;">
                    <h3 class="panel-title">Custom field</h3>
                    <a href="javascript:;" onclick="create_custom_field();"><span class="pull-right glyphicon glyphicon-plus" style="position: absolute;
                                                                                  right: 15px;
                                                                                  top: 10px; color: green"></span></a>
                </div>
                <div class="panel-body">
                    <ul>
                        <?php if (count($customf) > 0): ?>
                            <?php foreach ($customf as $each): ?>
                                <li><a href="javascript:;" onclick="return remove_customf('<?php echo $each->CUSTOM_FIELD_ID; ?>', '<?php echo $service_id; ?>');"><span class="pull-right glyphicon glyphicon-remove" style="color: red"></span></a><a href="javascript:;" onclick="open_customfield_edit('<?php echo $each->CUSTOM_FIELD_ID ?>');" >name=<?php echo $each->CUSTOM_FIELD_NAME ?>,type=<?php echo $each->CUSTOM_FIELD_TYPE ?>,label=<?php echo $each->CUSTOM_FIELD_LABEL ?>,mandatory=<?php echo $each->CUSTOM_FIELD_ISMANDATORY ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xs-4" >

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">ตั้งค่าอีเมลล์</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="exampleInputFile">รูปแบบอีเมลล์</label>

                        <select  class="form-control"  id="input_email_template_id" name="input_email_template_id" >
                            <option value="">--- Select one ----</option>';
                            <?php foreach ($email as $each) : ?>
                                <option <?php echo $service->SERVICE_EMAIL_TEMPLATE_ID == $each->EMAIL_ID ? 'selected="selected"' : '' ?>  value="<?php echo $each->EMAIL_ID; ?>"><?php echo $each->EMAIL_SUBJECT; ?></option>';
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">ตั้งค่า SMS</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="input_sms_template_open">รูปแบบ SMS ขาเปิดงาน</label>

                        <select  class="form-control"  id="input_sms_template_open" name="input_sms_template_open" >
                            <option value="">--- Select one ----</option>';
                            <?php foreach ($sms as $each) : ?>
                                <option <?php echo $service->SMS_OPEN_TEMPLATE_ID == $each->SMS_ID ? 'selected="selected"' : '' ?>  value="<?php echo $each->SMS_ID; ?>"><?php echo $each->SMS_NAME; ?></option>';
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input_sms_template_close">รูปแบบ SMS ขาปิดงาน</label>

                        <select class="form-control"  id="input_sms_template_close" name="input_sms_template_close" >
                            <option value="">--- Select one ----</option>';
                            <?php foreach ($sms as $each) : ?>
                                <option <?php echo $service->SMS_CLOSE_TEMPLATE_ID == $each->SMS_ID ? 'selected="selected"' : '' ?>  value="<?php echo $each->SMS_ID; ?>"><?php echo $each->SMS_NAME; ?></option>';
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">ตั้งค่าบริการ</h3>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">จำนวนสิทธิ์</label>
                            <div class="col-sm-8">
                                <input required="required" type="number" class="form-control" id="input_pointquota" name="input_pointquota" value="<?php echo $service->SERVICE_POINTQUOTA; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">ประเภท</label>
                            <div class="col-sm-8">
                                <input <?php echo $service->SERVICE_TYPE == 1 ? 'checked="true"' : ''; ?>  type="radio" class="radio-inline" id="inputtype" name="inputtype" value="1">
                                <label for="inputtype_m">รายเดือน</label>
                                <input <?php echo $service->SERVICE_TYPE == 2 ? 'checked="true"' : ''; ?> type="radio" class="radio-inline" id="inputtype" name="inputtype" value="2">
                                <label for="inputtype_y">รายปี</label>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">สิทธิ์ต่อคน</label>
                            <div class="col-sm-8">
                                <input required="required" type="number" class="form-control" id="input_pointholder" name="input_pointholder" value="<?php echo $service->SERVICE_POINTHOLDER; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">ประเภท</label>
                            <div class="col-sm-8">
                                <input <?php echo $service->SERVICE_POINTTYPE == 1 ? 'checked="true"' : ''; ?>  type="radio" class="radio-inline" id="inputpointtype" name="inputpointtype" value="1">
                                <label for="inputtype_m">รายเดือน</label>
                                <input <?php echo $service->SERVICE_POINTTYPE == 2 ? 'checked="true"' : ''; ?> type="radio" class="radio-inline" id="inputpointtype" name="inputpointtype" value="2">
                                <label for="inputtype_y">รายปี</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">Deduct</label>
                            <div class="col-sm-8">
                                <input required="required" type="number" class="form-control" id="input_pointdeduct" name="input_pointdeduct" value="<?php echo $service->SERVICE_POINTDEDUCT; ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <input type="submit" id="input_btnaddscript" name="input_btnaddscript" class="btn btn-default" style="width: 100%;" value="บันทึก" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" style="position: relative;">
                    <h3 class="panel-title">Partner link</h3>
                    <a href="javascript:;" onclick="create_partner_link();"><span class="pull-right glyphicon glyphicon-plus" style="position: absolute;
                                                                                  right: 15px;
                                                                                  top: 10px; color: green"></span></a>
                </div>
                <div class="panel-body">
                    <ul>
                        <?php if (count($service_partner) > 0): ?>
                            <?php foreach ($service_partner as $each): ?>
                                <li><a href="javascript:;" onclick="return remove_partnerlink('<?php echo $each->PARTNER_ID; ?>', '<?php echo $service_id; ?>');"><span class="pull-right glyphicon glyphicon-remove" style="color: red"></span></a><a href="<?php echo read_clob($each->PARTNER_LINK) ?>" target="_blank"><?php echo $each->PARTNER_NAME ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>



        </div>
    </form>
</div>


<!-- Modal -->
<div class="modal fade" id="partner_link_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post"  >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">เพิ่ม Partner link</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="service_id" name="service_id" value="<?php echo $service_id; ?>" />

                    <div class="form-group">
                        <label for="input_note">ชื่อ Partner</label>
                        <input  required="required" type="text" class="form-control" id="input_partnername" name="input_partnername"  />
                    </div>
                    <div class="form-group">
                        <label for="input_dudate">External link</label>
                        <input  required="required" type="text" class="form-control" id="input_partnerlink" name="input_partnerlink" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" id="input_btnaddpartner" name="input_btnaddpartner" class="btn btn-primary" value="Save changes" />
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="article_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post"  >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">เพิ่ม Article list</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="service_id" name="service_id" value="<?php echo $service_id; ?>" />
                    <input type="hidden" id="input_article_id" name="input_article_id" />
                    <div class="form-group">
                        <label for="input_note">Title</label>
                        <input  required="required" type="text" class="form-control" id="input_article_title" name="input_article_title"  />
                    </div>
                    <div class="form-group">
                        <label for="input_dudate">Description</label>
                        <textarea class="form-control ckeditor" id="input_article_detail" name="input_article_detail"></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" id="input_btnaddarticle" name="input_btnaddarticle" class="btn btn-primary" value="Save changes" />
                    <input type="submit" id="input_btneditarticle" name="input_btneditarticle" class="btn btn-primary" value="Save changes" />
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="custom_field_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post"  >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Custom field</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="service_id" name="service_id" value="<?php echo $service_id; ?>" />
                    <input type="hidden" id="input_customf_id" name="input_customf_id" />
                    <div class="form-group">
                        <label for="input_ftype">Field Type</label>

                        <select required="required" class="form-control"  id="input_ftype" name="input_ftype" >
                            <option value="">--- Select one ----</option>
                            <option value="text">text</option>
                            <option value="textarea">textarea</option>
                            <option value="date">date</option>
                            <option value="number">number</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input_flabel">Field Label</label>
                        <input  required="required" type="text" class="form-control" id="input_flabel" name="input_flabel"  />
                    </div>
                    <div class="form-group">
                        <label for="input_fname">Field Name</label>
                        <input  required="required" type="text" class="form-control" id="input_fname" name="input_fname" />
                    </div>
                    <div class="form-group">
                        <label for="input_fvalue">Field Value</label>
                        <input  type="text" class="form-control" id="input_fvalue" name="input_fvalue" />
                    </div>
                    <div class="form-group">
                        <label for="input_fvalue">Field Placeholder</label>
                        <input  type="text" class="form-control" id="input_fplaceholder" name="input_fplaceholder" />
                    </div>
                    <div class="form-group">
                        <label for="input_fmandatory" class="col-sm-2 control-label">Mandatory?</label>
                        <div class="col-sm-10">
                            <input  type="radio" class="radio-inline" id="input_fmandatory_y" name="input_fmandatory" value="1">
                            <label for="inputtype_y">YES</label>
                            <input checked="true" type="radio" class="radio-inline" id="input_fmandatory_n" name="input_fmandatory" value="0">
                            <label for="inputtype_m">NO</label>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" id="input_btnaddcustomfield" name="input_btnaddcustomfield" class="btn btn-primary" value="Save changes" />
                    <input type="submit" id="input_btneditcustomfield" name="input_btneditcustomfield" class="btn btn-primary" value="Save changes" />
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
//<![CDATA[
    CKEDITOR.replace('service_script',
            {
                height: '300'
            });
    CKEDITOR.replace('input_article_detail',
            {
                height: '300'
            });
//]]>

    function create_partner_link() {
        $('#partner_link_modal').modal('show');
    }

    function create_custom_field() {
        $('#input_btnaddcustomfield').show();
        $('#input_btneditcustomfield').hide();
        $('#custom_field_modal').modal('show');
    }




    function remove_customf(customf_id, service_id) {
        if (confirm('Are you sure?')) {
            location.href = '<?php echo base_url(); ?>master_data/delete_customf/' + customf_id + '/' + service_id;
            return true;
        }
        return false;
    }


    function remove_partnerlink(PARTNER_ID, service_id) {
        if (confirm('Are you sure?')) {
            location.href = '<?php echo base_url(); ?>master_data/delete_partner/' + PARTNER_ID + '/' + service_id;
            return true;
        }
        return false;
    }
    function remove_article(ARTICLE_ID, service_id) {
        if (confirm('Are you sure?')) {
            location.href = '<?php echo base_url(); ?>master_data/delete_article/' + ARTICLE_ID + '/' + service_id;
            return true;
        }
        return false;
    }



    function open_articleform() {
        $('#input_btnaddarticle').show();
        $('#input_btneditarticle').hide();
        $('#input_ARTICLE_TITLE').val('');
        CKEDITOR.instances.input_article_detail.setData('');
        $('#article_modal').modal('show');

    }

    function open_articleform_edit(id) {
        if (id) {
            $.ajax({
                url: "<?php echo base_url(); ?>" + "index.php/service/getarticle_byid",
                type: "POST",
                data: {'id': id},
                dataType: "json",
                success: function(data) {
                    $('#input_btnaddarticle').hide();
                    $('#input_btneditarticle').show();
                    $('#input_ARTICLE_TITLE').val(data.result.ARTICLE_TITLE);
                    $('#input_ARTICLE_ID').val(data.result.ARTICLE_ID);

                    CKEDITOR.instances.input_article_detail.insertHtml(data.result.ARTICLE_DESCRIPTION);
                    $('#article_modal').modal('show');

                },
                error: function(XMLHttpRequest) {
                    //$.growl(XMLHttpRequest.status, {type: 'danger'}); //danger , info , warning
                }
            });

        }
    }

    function open_customfield_edit(id) {
        if (id) {
            $.ajax({
                url: "<?php echo base_url(); ?>" + "index.php/service/getcustomf_byid",
                type: "POST",
                data: {'id': id},
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('#input_btnaddcustomfield').hide();
                    $('#input_btneditcustomfield').show();

                    $('#input_customf_id').val(data.result.CUSTOM_FIELD_ID);
                    $('#input_ftype').val(data.result.CUSTOM_FIELD_TYPE);
                    $('#input_flabel').val(data.result.CUSTOM_FIELD_LABEL);
                    $('#input_fname').val(data.result.CUSTOM_FIELD_NAME);
                    $('#input_fvalue').val(data.result.CUSTOM_FIELD_VALUE);
                    $('#input_fplaceholder').val(data.result.CUSTOM_FIELD_PLACEHOLDER);


                    if (data.result.CUSTOM_FIELD_ISMANDATORY == 1) {
                        $('#input_fmandatory_y').prop('checked', true);
                    }
                    else {
                        $('#input_fmandatory_n').prop('checked', true);
                    }


                    $('#custom_field_modal').modal('show');

                },
                error: function(XMLHttpRequest) {
                    //$.growl(XMLHttpRequest.status, {type: 'danger'}); //danger , info , warning
                }
            });

        }
    }


</script>