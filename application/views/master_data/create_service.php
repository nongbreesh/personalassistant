
<?php if (!empty($_GET['status'])): ?>
    <div class="col-xs-12 " >
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <?php if ($_GET['type'] == 'remove_service'): ?>
                <strong>Success!</strong> ลบข้อมูล  สำเร็จ
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<div class="col-xs-12 " >
    <div class="col-xs-2">
        <div class="panel" >
            <div class="panel-body">
                <a href="<?php echo base_url(); ?>master_data/create_service_new" ><span class="glyphicon glyphicon-plus"></span> เพิ่มบริการ</a>

            </div>
        </div>
    </div>
</div>
<div class="col-xs-12" >
    <form method="post">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">บริการทั้งหมด</h3>
                    <select id="nextmonth"  name="nextmonth" onchange="submit();" style="width: 250px;
                            position: absolute;
                            left: 150px;
                            top: 5px;
                            padding: 5px;">
                        <option value="" >=== ดูสิทธิ์คงเหลือของเดือนถัดไป ===</option>
                        <?php foreach ($nextmonth as $each): ?>
                            <option <?php echo $monthsval == $each ? 'selected="selected"' : ''; ?> value="<?php echo $each; ?>" ><?php echo $each; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>#</th>
                                <th>ชื่อบริการ</th>
                                <th>จำนวนสิทธิ์</th>
                                <th>จำนวนสิทธิ์คงเหลือ</th>
                                <th>ประเภทการตัดสิทธิ์</th>
                                <th>วันที่สร้าง</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($service as $each):
                                ?> 
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><a href="<?php echo base_url() ?>master_data/create_service_edit/<?php echo $each->SERVICE_ID; ?>" >แก้ไข</a></td>
                                    <td><?php echo $each->SERVICE_NAME; ?></td>
                                    <td><?php echo $each->SERVICE_POINTQUOTA == 0 ? 'ไม่จำกัด' : $each->SERVICE_POINTQUOTA; ?></td>
                                    <td style="color:green;"><?php echo $method->get_service_totalpoint($each->SERVICE_ID, $monthsval); ?></td>
                                    <td><?php echo $each->SERVICE_TYPE == 2 ? 'รายปี' : 'รายเดือน'; ?></td>
                                    <td><?php echo $each->SERVICE_CREATEDATE; ?></td> 
                                    <td><a href="javascript:;" onclick="return remove_service('<?php echo $each->SERVICE_ID; ?>');" ><span class="glyphicon glyphicon-remove"></span></a></td>
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
    </form>
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



    function remove_service(SERVICE_ID) {
        if (confirm('Are you sure?')) {
            location.href = '<?php echo base_url(); ?>master_data/delete_service/' + SERVICE_ID;
            return true;
        }
        return false;
    }

</script>

