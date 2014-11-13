<!DOCTYPE html>
<html>
    <head>
        <title>Personal Assistant | Control panel</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta charset="UTF-8">

        <!--[if lt IE 9]>
    <script src="<?php echo base_url() ?>public/js/jquery-2.0.3.min.js" type="text/javascript"></script>
<![endif]-->
        <!--[if gte IE 9]><!-->
        <script src="<?php echo base_url() ?>public/js/jquery-2.0.0.min.js" type="text/javascript"></script>
        <!--<![endif]-->
        <script src="<?php echo base_url() ?>public/js/bootstrap.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url() ?>public/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>public/css/flat-ui.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>public/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>public/css/style.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url() ?>public/bootstrap/js/moment.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>public/bootstrap/js/bootstrap-datetimepicker.js" type="text/javascript"></script>

        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url() ?>public/resources/css/smoothness/jquery-ui-1.10.1.custom.css"/>
        <script type="text/javascript" src="<?php echo base_url() ?>public/resources/jquery/jquery-ui-1.10.1.custom.min.js"></script>
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url() ?>public/resources/css/smoothness/jquery.ui.combogrid.css"/>
        <script type="text/javascript" src="<?php echo base_url() ?>public/resources/plugin/jquery.ui.combogrid-1.6.3.js"></script>
        <script src="<?php echo base_url() ?>public/ckeditor/ckeditor.js"></script>

        <script>
            $(document).ready(function() {
                getnotification();

                $('input[type=selectdate]').datetimepicker({pickTime: false});
                $('input[type=datetime]').datetimepicker({use24hours: true, format: 'DD/MM/YYYY HH:mm'});
                $('input[type=selecttime]').datetimepicker({pickDate: false, use24hours: true, format: 'HH:mm'});
            });

            function getnotification() {
                $('#notification').html('...');
                $.ajax({
                    url: "<?php echo base_url(); ?>" + "index.php/service/getnotification",
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                        $('#notification').html(data.result);
                    },
                    error: function(XMLHttpRequest) {
                    }
                });
            }
        </script>
    </head>
    <body>

        <header class="col-xs-12 header ztop" >
            <div class="row ztop">
                <div class="col-xs-4 pull-left">
                    <h1 class="logo"><span style="color: #f00;">TrueYou</span> <span style="font-size: 18px;color: #AFAFAF;">Personal Assistant</span></h1>
                </div>
                <div class="col-xs-8 navbar-collapse pull-right ztop">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo base_url('pending_case') ?>?status=overdue"><span class="badge badge-white pull-right" id="notification"></span> Over due</a></li>
                        <li><a href="<?php echo base_url('user_data') ?>/userprofile?userid=<?php echo $user['user_id'] ?>"><?php echo $user['user_fullname'] ?></a></li>
                        <li><a href="<?php echo base_url('logout') ?>">LOGOUT</a></li>
                    </ul>
                </div>
            </div>


        </header>


        <div class="sidebar ztop">
            <div class="sidemenu">
                <ul>
                    <li><a href="<?php echo base_url('dashboard') ?>" <?php echo $menu == 'dashboard' ? 'class="active"' : '' ?>><span class="glyphicon glyphicon-dashboard"></span> ค้นหาสิทธิพิเศษ</a></li>
                    <li><a href="<?php echo base_url('report') ?>" <?php echo $menu == 'report' ? 'class="active"' : '' ?>><span class="glyphicon glyphicon-inbox"></span> รายงาน</a></li>
                    <li><a href="<?php echo base_url('pending_case') ?>" <?php echo $menu == 'pending_case' ? 'class="active"' : '' ?>><span class="glyphicon glyphicon-warning-sign"></span> ตรวจสอบสถานะงาน</a></li>
                    <li><a href="<?php echo base_url('customer_service') ?>" <?php echo $menu == 'customer_service' ? 'class="active"' : '' ?>><span class="glyphicon glyphicon-headphones"></span> การให้บริการลูกค้า</a></li>

                    <?php if ($user['isadmin'] == true): ?>
                        <li><a href="<?php echo base_url('setting') ?>" <?php echo $menu == 'setting' ? 'class="active"' : '' ?>><span class="glyphicon glyphicon-cog"></span> ตั้งค่า</a></li>
                        <li><a href="<?php echo base_url('master_data') ?>" <?php echo $menu == 'master_data' ? 'class="active"' : '' ?>><span class="glyphicon glyphicon-cog"></span> ข้อมูลมาสเตอร์</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo base_url('logout') ?>" <?php echo $menu == 'logout' ? 'class="active"' : '' ?>><span class="glyphicon glyphicon-log-out"></span> ออกจากระบบ</a></li>
                </ul>
            </div>
        </div>
        <div class="content">
            <div class="clearfix">
                <?php $this->load->view($body); ?>
            </div>
        </div>




    </body>
</html>
