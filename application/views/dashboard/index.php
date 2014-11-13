<!--<div class="col-xs-12 fillter_slide" >
    <div class="col-xs-12 " style="padding: 20px;" >
        <?php foreach ($engchar as $each): ?>
            <div class="col-xs-1" >
                <div class="fillter engchar">
                    <p><a href="?prm=<?php echo $each; ?>&prefix=true"><?php echo $each; ?></a></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="col-xs-12 " style="margin-bottom: 20px;padding: 20px;" >
        <?php foreach ($thaichar as $each): ?>
            <div class="col-xs-1" >
                <div class="fillter thaichar">
                    <p><a href="?prm=<?php echo $each; ?>&prefix=true"><?php echo $each; ?></a></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="clearfix"></div>
</div>
<div class="fillter_toggle">กรองข้อมูล</div>



<div class="col-xs-12 " >
    <div class="col-xs-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">กรองประเภทบริการ</h3>
            </div>
            <div class="panel-body">


                <div class="form-inline  col-xs-2">
                    <input type="checkbox" /> BLACK CARD
                </div>
                <div class="form-inline  col-xs-2">
                    <input type="checkbox"  /> RED CARD
                </div>
                <div class="form-inline  col-xs-2">
                    <input type="checkbox" /> อิ่ม
                </div>
                <div class="form-inline  col-xs-2">
                    <input type="checkbox" /> ช้อป
                </div>
                <div class="form-inline  col-xs-2">
                    <input type="checkbox" /> เพลิน
                </div>

            </div>
        </div>
    </div>
</div>-->

<div class="col-xs-12">
    <div class="col-xs-12">
        <div class="panel" >
            <div class="panel-body">
                <form class="form-inline" role="form" method="post" action="<?php echo base_url(); ?>/dashboard/index">
                    <div class="form-group">
                        <div class="input-group col-xs-12">

                            <input class="form-control" id="input_search" name="input_search" type="text" placeholder="ค้นหา สถานที่ สิทธิประโยชน์" value="<?php echo $prm; ?>"><br>
                            <div id="switcher" style="float:right"></div>
                            <div class="input-group-addon" style="padding: 0px;"><button type="submit" id="input_btnsearch" name="input_btnsearch" class="btn btn-default" style="padding: 10px 30px 9px;"><span class="glyphicon glyphicon-search"></span></button></div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
<?php if (count($privilege) > 0): ?>
    <div class="col-xs-12">

        <div class="col-xs-12">
            <div class=" panel">
                <div class="panel-body">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 40px;">#</th>
                                <th style="width: 220px;">ชื่อร้านค้า</th>
                                <th>สิทธิพิเศษ</th>
                                <th>USSD</th>
                                <th>SMS</th>
                                <th>ที่ตั้ง</th>
                                <th style="width: 120px;">เบอร์โทรศัพท์</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1 + $page;
                            foreach ($privilege as $each):
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td style="color: red;"><?php echo read_clob($each->TITLE); ?></td>
                                    <td><?php echo $each->DEAL_OFFER; ?></td>
                                    <td><?php echo $each->DEAL_USSD; ?></td>
                                    <td><?php echo $each->DEAL_SMS; ?></td>
                                    <td><?php echo $each->ADDRESS; ?></td>
                                    <td style="width: 120px;"><?php echo $each->TEL; ?></td>
                                </tr>
                                <?php
                                $i++;
                            endforeach;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">  <?php echo $this->pagination->create_links(); ?></td>
                            </tr>

                        </tfoot>
                    </table> 


                </div>
            </div>
        </div>

    </div>
<?php else: ?>
    <h1 class="emptydata">EMPTY DATA</h1>
<?php endif; ?>

<script>
    $(document).ready(function() {
        $(".fillter_slide").hide();
        $('.fillter_toggle').click(function() {
            if ($(".fillter_slide:first").is(":hidden")) {
                $(".fillter_slide").slideDown("fast");
            } else {
                $(".fillter_slide").slideUp("fast");
            }
        });

        $("#input_search").combogrid({
            url: "<?php echo base_url(); ?>" + "index.php/service/getprivilege_data",
            debug: true,
            width: "80%",
            colModel: [{'columnName': 'title', 'label': 'TITLE'}
                , {'columnName': 'tel', 'label': 'TEL'}
                , {'columnName': 'address', 'label': 'ADDRESS'}],
            select: function(event, ui) {
                $("#input_search").val(ui.item.title);
                return false;
            }
        });
    });
</script>