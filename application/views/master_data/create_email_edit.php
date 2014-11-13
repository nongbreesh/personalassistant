<?php if (!empty($_GET['status'])): ?>
    <div class="col-xs-12 " >
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <?php if ($_GET['type'] == 'update_email'): ?>
                <strong>Success!</strong> แก้ไขข้อมูล  สำเร็จ
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<div class="col-xs-12 " >
    <form method="post"  >
        <div class="col-xs-7" >

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">ตั้งค่ารูปแบบอีเมลล์</h3>


                </div>
                <div class="panel-body">
                    <div class="form-horizontal" style="padding: 10px;">
                        <input type="hidden" name="input_emailid" id="input_emailid" value="<?php echo $email->EMAIL_ID; ?>"/>
                        <div class="form-group">
                            <label for="input_subject" class="col-sm-2 control-label">Subject</label>
                            <div class="col-sm-10">
                                <input required="required" type="text" class="form-control" id="input_subject" name="input_subject" value="<?php echo $email->EMAIL_SUBJECT; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_sender" class="col-sm-2 control-label">Sender</label>
                            <div class="col-sm-10">
                                <input required="required" type="text" class="form-control" id="input_sender" name="input_sender"  value="<?php echo $email->EMAIL_SENDER; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_to" class="col-sm-2 control-label">to</label>
                            <div class="col-sm-10">
                                <input required="required" type="text" class="form-control" id="input_to" name="input_to"  value="<?php echo read_clob($email->EMAIL_TO); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_cc" class="col-sm-2 control-label">cc</label>
                            <div class="col-sm-10">
                                <input  type="text" class="form-control" id="input_cc" name="input_cc"  value="<?php echo read_clob($email->EMAIL_CC); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="ckeditor" id="input_body" name="input_body">
                                <?php echo read_clob($email->EMAIL_BODY); ?>
                            </textarea>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="col-xs-5" >
            <div class="panel panel-default" style="margin-top: 310px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Custom field</h3>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <button type="button" id="tag_field" class="btn btn-embossed" value="{cust_name}">{cust_name}</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" id="tag_field" class="btn btn-embossed" value="{truecard_no}">{truecard_no}</button>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <button type="button" id="tag_field" class="btn btn-embossed" value="{cust_tel}">{cust_tel}</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" id="tag_field" class="btn btn-embossed" value="{due_date}">{due_date}</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <button type="button" id="tag_field" class="btn btn-embossed" value="{cust_contactinfo}">{cust_contactinfo}</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" id="tag_field" class="btn btn-embossed" value="{datenow}">{datenow}</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <button type="button" id="tag_field" class="btn btn-embossed" value="{cust_email}">{cust_email}</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" id="tag_field" class="btn btn-embossed" value="{customfield}">{customfield}</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-0 col-sm-12">
                            <input type="submit" id="input_btnadd" name="input_btnadd" class="btn btn-default" style="width: 100%;" value="บันทึก" />
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
    CKEDITOR.replace('input_body',
            {
                height: '500',
                allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height]'
            });
//]]>

    $(document).ready(function() {
        $('button[id=tag_field]').click(function() {
            CKEDITOR.instances.input_body.insertText($(this).val());
        });
    });

</script>