
<div class="col-xs-4" >
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">สร้าง User</h3>
        </div>
        <div class="panel-body">
            <form role="form" id="form_add_cate" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="input_name">User</label>
                        <div class="input-group">
                            <input type="text" id="input_name" name="input_name" class="form-control" placeholder="Enter True Username">
                            <span class="input-group-btn">
                                <button onclick="search_customer();" class="btn btn-default" type="button">Search</button>
                            </span>
                        </div><!-- /input-group -->
                    </div>
                    <div id="cust_field">
                        <div class="form-group">
                            <label for="input_empid">Empid</label>
                            <input  required="required" type="text" id="input_empid" name="input_empid" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="input_fullname">Fullname</label>
                            <input  required="required" type="text" id="input_fullname" name="input_fullname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="input_email">Email</label>
                            <input required="required" type="text" id="input_email" name="input_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="input_tel">Tel</label>
                            <input type="text" id="input_tel" name="input_tel" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Group</label>

                        <select required="required" class="form-control"  id="input_groupid" name="input_groupid" >
                            <option value="">--- Select one ----</option>';
                            <?php foreach ($groups as $each) { ?>
                                <option value="<?php echo $each->USERGROUP_ID; ?>"><?php echo $each->USERGROUP_NAME; ?></option>';
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Permission Group</label>

                        <select required="required" class="form-control"  id="input_permisionid" name="input_permisionid" >
                            <option value="">--- Select one ----</option>';
                            <?php foreach ($permissions as $each) { ?>
                                <option value="<?php echo $each->PERMISSION_ID; ?>"><?php echo $each->PERMISSION_NAME; ?></option>';
                            <?php } ?>
                        </select>
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
            <h3 class="panel-title">User list</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover todo-list ">
                <thead>
                    <tr>
                        <th><strong>ID</strong></th>
                        <th><strong>User name</strong></th>
                        <th><strong>Full name</strong></th>
                        <th><strong>Email</strong></th>
                        <th><strong>Tel</strong></th>
                        <th><strong>Group Agent</strong></th>
                        <th><strong>Permission group</strong></th>
                        <th><strong>Create date</strong></th>
                        <th><strong>#</strong></th>
                    </tr>
                </thead>
                <tbody id="cate_list">
                    <?php
                    $x = 1;
                    foreach ($users as $each):
                        ?>
                        <tr>
                            <td><?php echo $each->USER_ID; ?></td>
                            <td><?php echo $each->USER_NAME; ?></td>
                            <td><?php echo $each->USER_FULLNAME; ?></td>
                            <td><?php echo $each->USER_EMAIL; ?></td>
                            <td><?php echo $each->USER_TEL; ?></td>

                            <td><?php echo $each->USERGROUP_NAME; ?></td>
                            <td><?php echo $each->PERMISSION_NAME; ?></td>
                            <td><?php echo $each->USER_CREATEDATE; ?></td>
                            <td><a href="javascript:;" onclick="return remove_user(<?php echo $each->USER_ID; ?>);"><span class="glyphicon glyphicon-remove"></span></a></td>
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
    $(document).ready(function() {
        $('#cust_field').hide();
    });
    function remove_user(id) {
        if (confirm('Are you sure?')) {
            location.href = "<?php echo base_url(); ?>index.php/service/remove_user/" + id
        }
        else {
            return false;
        }
    }

    function search_customer() {
        var input_name = $('#input_name').val();
        $.ajax({
            url: "<?php echo base_url(); ?>" + "index.php/service/getcustomer_data",
            type: "POST",
            data: {'input_name': input_name},
            dataType: "json",
            success: function(data) {
                console.log(data.result);

                if (data.result.empid == null) {
                    alert('ไม่มีชื่อนี้');
                    $('#cust_field').hide();
                    return false;
                } else {
                    $('#input_empid').val(data.result.empid);
                    $('#input_fullname').val(data.result.fullname);
                    $('#input_email').val(data.result.email);
                    $('#input_tel').val(data.result.tel);
                    $('#cust_field').show();
                }

            },
            error: function(XMLHttpRequest) {
                console.log(XMLHttpRequest);
            }
        });
    }
</script>