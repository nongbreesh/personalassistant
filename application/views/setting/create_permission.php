
<div class="col-xs-4" >
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">สร้างกลุ่ม Permission</h3>
        </div>
        <div class="panel-body">
            <form role="form" id="form_add_cate" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input required="required" type="text" class="form-control" id="input_name" name="input_name" placeholder="Enter Permission name">
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" value="1" id="input_isview" name="input_isview"> View
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input  type="checkbox"  value="1" id="input_isedit" name="input_isedit"> Edit
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            <input  type="checkbox"  value="1" id="input_isreviewer" name="input_isreviewer"> Review Cross group
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input  type="checkbox"  value="1" id="input_isadmin" name="input_isadmin"> Administrator
                        </label>
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
            <h3 class="panel-title">Permission list</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover todo-list ">
                <thead>
                    <tr>
                        <th><strong>ID</strong></th>
                        <th><strong>Name</strong></th>
                        <th><strong>View</strong></th>
                        <th><strong>Edit</strong></th>
                        <th><strong>Reviewer</strong></th>
                        <th><strong>Administrator</strong></th>
                        <th><strong>#</strong></th>
                    </tr>
                </thead>
                <tbody id="cate_list">

                    <?php $x = 1;
                    foreach ($permissions as $each):
                        ?>
                        <tr>
                            <td><?php echo $x; ?></td>
                            <td><?php echo $each->PERMISSION_NAME; ?></td>
                            <td><?php echo $each->PERMISSION_ISVIEW == '1' ? 'YES' : 'NO'; ?></td>
                            <td><?php echo $each->PERMISSION_ISEDIT == '1' ? 'YES' : 'NO'; ?></td>
                             <td><?php echo $each->PERMISSION_ISREVIEWER == '1' ? 'YES' : 'NO'; ?></td>
                            <td><?php echo $each->PERMISSION_ISADMIN == '1' ? 'YES' : 'NO'; ?></td>
                            <td><a href="javascript:;" onclick="return remove_permission(<?php echo $each->PERMISSION_ID; ?>);"><span class="glyphicon glyphicon-remove"></span></a></td>
                        </tr>
                        <?php $x++;
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
    function remove_permission(id) {
        if (confirm('Are you sure?')) {
            location.href = "<?php echo base_url(); ?>index.php/service/remove_permission/" + id
        }
        else {
            return false;
        }
    }
</script>