<section class="content-header">
      <h1>
        Medica
        <small>Vaccine schedule</small>
      </h1>
      <ol class="breadcrumb">
          <li><a href="<?php echo(base_url())?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User</li>
      </ol>
</section>
<section class="content">
   <div class="row">
       <div class="col-xs-12">
           <div class="box">
            <div class="box-header">
              <h3 class="box-title">Users(s)</h3>
              <?php if($this->session->user_data['role']=='Admin') {?>
              <a href="<?php echo(base_url()); ?>user/addedit" class="pull-right btn btn-primary" role="button">Add <i class="fa fa-plus"></i></a>
              
              <?php }?>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped medicadatatable">
                <thead>
                <tr>
                  <th>Login</th> 
                  <th>Email</th>
                  <th>Employee</th>
                  <th>Code</th>
                  <th>Department</th>
                  <th>Type</th>
                  <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>
                    <?php 
                    if($users){ 
                       
                        
                            foreach ($users as  $user){
                    ?>
                    <tr>
                        <td><?php echo($user->username);?></td>
                        <td><?php echo($user->employee_email);?></td>
                        <td><?php echo($user->employee_name);?></td>
                        <td><?php echo($user->employee_code);?></td>
                        <td><?php echo($user->department_name);?></td>
                         <td><?php echo($user->user_type);?></td>
                        <td>
                             <?php if($this->session->user_data['role']=='Admin') {?>
                            <a href="<?php echo(base_url()); ?>user/addedit/<?php echo($user->user_id); ?>" class="btn btn-primary btn-xs" role="button">Edit
                            <i class="fa fa-edit"></i></a>
                            
                            
<!--                            <button type="button" class="btn btn-primary btn-xs" id="addnew">Edit
                            <i class="fa fa-edit"></i></button>-->
                            <?php if($user->is_active=='Y'){ ?>
                            <a href="<?php echo(base_url()); ?>user/changeStatus/<?php echo($user->user_id); ?>/<?php echo($user->is_active); ?>" class="btn btn-success btn-xs" role="button">Active
                            <i class="fa fa-wrench"></i></a>
                            <?php } else{ ?>
                                <a href="<?php echo(base_url()); ?>user/changeStatus/<?php echo($user->user_id); ?>/<?php echo($user->is_active); ?>" class="btn btn-danger btn-xs" role="button">Inactive
                            <i class="fa fa-wrench"></i></a>
                            <?php } ?>
                             <?php }?>
                        </td>
                    </tr>
                    <?php 
                            }
                         } 
                    ?>
                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
       </div>
   </div>
    <!-- DataTables -->

  </section>


