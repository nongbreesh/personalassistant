<div class="col-xs-12 " >
    <div class="col-xs-2">
        <div class="panel" >
            <div class="panel-body">
                <a href="javascript:;" onclick="history.back();"><span class="glyphicon glyphicon-backward"></span> ย้อนกลับ</a>
            </div>
        </div>
    </div>
</div>
</div>
<div class="col-xs-12 " >
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">กลุ่ม <?php echo $group_detail->usergroup_name; ?></h3>
        </div>
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
                            <td><a href="userdetail?userid=<?php echo $each->USER_ID; ?>" style="color: #5D7CCC;text-decoration: underline;"><?php echo $each->USER_FULLNAME; ?></a></td>
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
            <div style="clear: both;"></div>
        </div>
    </div>
</div>  <div style="clear: both;"></div>