<div class="col-xs-12" >
    <div class="col-xs-2" >
        <div class="panel select_service">
            <div class="panel-body">

                <a href="<?php echo base_url() ?>master_data/create_service">  <span class="glyphicon glyphicon-edit"></span>บริการ</a>
            </div>
        </div>
    </div>
    <div class="col-xs-2" >
        <div class="panel select_service">
            <div class="panel-body">
                <a href="<?php echo base_url() ?>master_data/create_email">  <span class="glyphicon glyphicon-edit"></span>รูปแบบอีเมลล์</a>
            </div>
        </div>
    </div>

    <div class="col-xs-2" >
        <div class="panel select_service">
            <div class="panel-body">

                <a href="<?php echo base_url() ?>master_data/create_sms">  <span class="glyphicon glyphicon-edit"></span>SMS</a>
            </div>
        </div>
    </div>
    <div class="col-xs-2" >
        <div class="panel select_service">
            <div class="panel-body">

                <a href="javascript:;" onclick="foo();">  <span class="glyphicon glyphicon-cog"></span>REPAIR CUSTOMER CARD<br><span style="color:red;" id="row_progess">rows error : 2</span></a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        foo();
    });
    foo = function repair_cust() {
        $('#row_progess').html('<img src="<?php echo base_url(); ?>public/images/loading.gif" />');
        $.ajax({
            url: "<?php echo base_url(); ?>" + "index.php/service/repair_customercard",
            type: "POST",
            dataType: "json",
            success: function(data) {
                $('#row_progess').html('rows error : ' + data.result);
            },
            error: function(XMLHttpRequest) {
                foo();
            }
        });


    };
</script>