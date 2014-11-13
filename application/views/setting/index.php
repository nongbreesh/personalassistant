<div class="col-xs-12 " >
    <div class="col-xs-2">
        <div class="panel" >
            <div class="panel-body">
                <a href="<?php echo base_url('setting/create_group') ?>"><span class="glyphicon glyphicon-plus"></span> สร้างกลุ่ม Agent</a>
            </div>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="panel" >
            <div class="panel-body">
                <a href="<?php echo base_url('setting/create_user') ?>"><span class="glyphicon glyphicon-plus"></span> สร้าง User</a>
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="panel" >
            <div class="panel-body">
                <a href="<?php echo base_url('setting/create_permission') ?>"><span class="glyphicon glyphicon-plus"></span> สร้างกล่ม Permission</a>
            </div>
        </div>
    </div>

</div>
<div class="col-xs-12 " >
    <div class="panel" >
        <div class="panel-body">
            <table class="table table-hover" cellspacing="0">
                <thead>
                    <tr>
                        <th>ชื่อผู้ใช้</th>
                        <th>ชื่อ</th>
                        <th>กลุ่ม</th>
                        <th>บทบาท</th>
                        <th>หมายเลขติดต่อ</th>
                        <th>อีเมลลล์</th>
                        <th>เข้าสู่ระบบล่าสุด</th>
                        <th>วันที่สร้าง</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $each): ?>
                        <tr>
                            <td><?php echo $each->USER_NAME; ?></td>
                            <td><?php echo $each->USER_FULLNAME; ?></td>
                            <td><?php echo $each->USERGROUP_NAME; ?></td>
                            <td><?php echo $each->PERMISSION_NAME; ?></td>
                            <td><?php echo $each->USER_TEL; ?></td>
                            <td><?php echo $each->USER_EMAIL; ?></td>
                            <td><?php echo $each->USER_LASTLOGIN; ?></td>
                            <td><?php echo $each->USER_CREATEDATE; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>