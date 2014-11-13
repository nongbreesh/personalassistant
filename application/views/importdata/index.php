
<div class="col-xs-12 " >
    <div class="col-xs-12" >
        <div class="panel" >
            <div class="panel-body">


                <form action="" method="POST" enctype="multipart/form-data" >
                    <div class="form-group">
                        <div class="input-group col-xs-12">
                            <input type="file"  class="form-control" name="userfile"  />
                            <div class="input-group-addon" style="padding: 0px;"><input type="submit" name="submit"  class="btn btn-default" style="padding: 10px 30px 9px;" value="นำเข้าข้อมูล" /></div>
                        </div>
                    </div>
                </form>

                <br>

                <?php if (isset($error)): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success') == TRUE): ?>
                    <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
