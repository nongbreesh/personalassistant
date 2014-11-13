
<div class="col-xs-12 " >
    <form method="post"  >
        <div class="col-xs-7" >

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">ตั้งค่ารูปแบบอีเมลล์</h3>


                </div>
                <div class="panel-body">
                    <div class="form-horizontal" style="padding: 10px;">
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Subject</label>
                            <div class="col-sm-10">
                                <input required="required" type="text" class="form-control" id="input_subject" name="input_subject" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Sender</label>
                            <div class="col-sm-10">
                                <input required="required" type="text" class="form-control" id="input_sender" name="input_sender" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">to</label>
                            <div class="col-sm-10">
                                <input required="required" type="text" class="form-control" id="input_to" name="input_to" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">cc</label>
                            <div class="col-sm-10">
                                <input  type="text" class="form-control" id="input_cc" name="input_cc" >
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="ckeditor" id="email_body" name="email_body">
                     
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
                                <button type="button" id="tag_field" class="btn btn-embossed" value="{cust_address}">{cust_address}</button>
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
                                <button type="button" id="tag_field" class="btn btn-embossed" value="{truecard_no}">{truecard_no}</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" id="tag_field" class="btn btn-embossed" value="{truecard_expired}">{truecard_expired}</button>
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
    CKEDITOR.replace('email_body',
            {
                height: '500',
                allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height]'
            });
//]]>

    $(document).ready(function() {
        $('button[id=tag_field]').click(function() {
            CKEDITOR.instances.email_body.insertText($(this).val());
        });
    })

</script>