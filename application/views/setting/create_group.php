
<div class="col-xs-4" >
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">สร้างกลุ่ม Agent</h3>
        </div>
        <div class="panel-body">
            <form role="form" id="form_add_cate" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Group Name</label>
                        <input type="text" required="required" class="form-control" id="input_groupname" name="input_groupname" placeholder="Enter group name">
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="input_addcate">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-lg-8"> 
    <!-- Box (with bar chart) -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Group list</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover todo-list ">
                <thead>
                    <tr>
                        <th><strong>ID</strong></th>
                        <th><strong>Group Name</strong></th>
                        <th><strong>Member(s)</strong></th>
                        <th><strong>#</strong></th>
                    </tr>
                </thead>
                <tbody id="cate_list">

                    <?php
                    $x = 1;
                    foreach ($groups as $each):
                        ?>
                        <tr>
                            <td><?php echo $x; ?></td>
                            <td><?php echo $each->USERGROUP_NAME; ?></td>
                            <td><?php echo $x; ?></td>
                            <td><a href="javascript:;" onclick="return remove_group(<?php echo $each->USERGROUP_ID; ?>);"><span class="glyphicon glyphicon-remove"></span></a></td>
                        </tr>
                        <?php
                        $x++;
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- /.box-footer -->
    </div><!-- /.box -->        




</div><!-- /.Left col -->

<script>
    function remove_group(id) {
        if (confirm('Are you sure?')) {
            location.href = "<?php echo base_url(); ?>index.php/service/remove_group/" + id
        }
        else {
            return false;
        }
    }
</script>