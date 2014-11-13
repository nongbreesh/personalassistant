
<?php if (!empty($_GET['status'])): ?>
    <div class="col-xs-12 " >
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <?php if ($_GET['type'] == 'remove_email'): ?>
                <strong>Success!</strong> ลบข้อมูล  สำเร็จ
            <?php elseif ($_GET['type'] == 'create_email'): ?>
                <strong>Success!</strong> เพิ่มข้อมูล  สำเร็จ
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<div class="col-xs-12 " >
    <div class="col-xs-3">
        <div class="panel" >
            <div class="panel-body">
                <a href="<?php echo base_url(); ?>master_data/create_email_new" ><span class="glyphicon glyphicon-plus"></span> เพิ่มรูปแบบอีเมลล์</a>

            </div>
        </div>
    </div>
</div>
<div class="col-xs-12" >
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">รูปแบบทั้งหมด</h3>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>#</th>
                            <th>ชื่อรูปแบบ</th>
                            <th>Email list</th>
                            <th>วันที่สร้าง</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($email as $each):
                            ?> 
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><a href="<?php echo base_url() ?>master_data/create_email_edit/<?php echo $each->EMAIL_ID; ?>" >แก้ไข</a></td>
                                <td><?php echo $each->EMAIL_SUBJECT; ?></td>
                                <td><?php echo read_clob($each->EMAIL_TO); ?></td>
                                <td><?php echo $each->EMAIL_CREATEDATE; ?></td> 
                                <td><a href="javascript:;" onclick="return remove_email('<?php echo $each->EMAIL_ID; ?>');" ><span class="glyphicon glyphicon-remove"></span></a></td>
                            </tr>
                            <?php
                            $i++;
                        endforeach;
                        ?>
                    </tbody>

                </table>
            </div>
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



    function remove_email(EMAIL_ID) {
        if (confirm('Are you sure?')) {
            location.href = '<?php echo base_url(); ?>master_data/delete_email_template/' + EMAIL_ID;
            return true;
        }
        return false;
    }

</script>

