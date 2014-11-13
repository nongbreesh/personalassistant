
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
                                <input required="required" type="text" class="form-control" id="input_service_name" name="input_service_name" >
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="ckeditor" id="service_script" name="service_script">
                     
                            </textarea>
                        </div>
                    </div>

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
                                <option value="<?php echo $each->EMAIL_ID; ?>"><?php echo $each->EMAIL_SUBJECT; ?></option>';
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
                                <input required="required" type="number" class="form-control" id="input_pointquota" name="input_pointquota" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">ประเภท</label>
                            <div class="col-sm-8">
                                <input  checked="checked" type="radio" class="radio-inline" id="inputtype" name="inputtype" value="1">
                                <label for="inputtype_m">รายเดือน</label>
                                <input  type="radio" class="radio-inline" id="inputtype" name="inputtype" value="2">
                                <label for="inputtype_y">รายปี</label>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">สิทธิ์ต่อคน</label>
                            <div class="col-sm-8">
                                <input required="required" type="number" class="form-control" id="input_pointholder" name="input_pointholder" value="1" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">ประเภท</label>
                            <div class="col-sm-8">
                                <input checked="checked" type="radio" class="radio-inline" id="inputpointtype" name="inputpointtype" value="1">
                                <label for="inputtype_m">รายเดือน</label>
                                <input type="radio" class="radio-inline" id="inputpointtype" name="inputpointtype" value="2">
                                <label for="inputtype_y">รายปี</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">Deduct</label>
                            <div class="col-sm-8">
                                <input required="required" type="number" class="form-control" id="input_pointdeduct" name="input_pointdeduct" value="1" >
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

        </div>
    </form>
</div>


<script type="text/javascript">
//<![CDATA[
    CKEDITOR.replace('service_script',
            {
                height: '500'
            });
//]]>


</script>