<div class="col-xs-12 " >
    <div class="col-xs-2">
        <div class="panel" >
            <div class="panel-body">
                <a href="javascript:;" onclick="location.href = '<?php echo base_url('customer_service/index') ?>?cardid=<?php echo $cardid; ?>'"><span class="glyphicon glyphicon-backward"></span> ย้อนกลับ</a>
            </div>
        </div>
    </div>
    <div class="col-xs-5">
        <div class="panel"  style="background: #222">
            <div class="panel-body">
                <div class="priviledge-cardname"><span style="color:#fff;"><span class="glyphicon glyphicon-road"></span> Customer in line : </span> <?php echo $customer_detail->CARDNAME; ?></div>
            </div>
        </div>
    </div>
</div>

<!--<div class="col-xs-5" >
    <div class="col-xs-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">เลือกบริการที่ลูกค้าต้องการ</h3>
            </div>
            <div class="panel-body">
                <div class="select_service">
                    <ul>
                        <li><a href="#">ช่วยเหลือฉุกเฉินบนท้องถนน (Roadside Assistant)</a></li>
                        <li><a href="#">บริการรับส่งเอกสาร (Messenger Service)</a></li>
                        <li><a href="#">ช่วยเหลือฉุกเฉินภายในบ้าน (Home Assistant)</a></li>
                        <li><a href="#">ที่พัก</a></li>
                        <li><a href="#">รถเช่า</a></li>
                        <li><a href="#">ตั๋วเครื่องบิน</a></li>
                        <li><a href="#">ร้านอาหาร</a></li>
                        <li><a href="#">สั่งดอกไม้</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>-->

<div class="col-xs-12" >
    <?php foreach ($service as $each): ?>
        <div class="col-xs-2" >
            <div class="panel select_service">
                <div class="panel-body">

                    <a href="<?php echo base_url('customer_service/apply_service') ?>/<?php echo $each->SERVICE_ID ?>?cardid=<?php echo $cardid; ?>&recid=<?php echo $recid; ?>">  <span class="glyphicon glyphicon-user"></span> <?php echo $each->SERVICE_NAME ?></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>
