<section class="content-header">
      <h1>
        Medica
        <small>Vaccine schedule</small>
      </h1>
      <ol class="breadcrumb">
          <li><a href="<?php echo(base_url())?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Employee</li>
      </ol>
</section>
<section class="content">
   <div class="row">
       <div class="col-xs-12">
           <div class="box">
            <div class="box-header">
              <h3 class="box-title">Employee(s)</h3>
              <?php if($this->session->user_data['role']=='Admin') {?>
              <a href="<?php echo(base_url()); ?>employee/addedit" class="pull-right btn btn-primary" role="button">Add <i class="fa fa-plus"></i></a>
              
              <?php }?>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped medicadatatable">
                <thead>
                <tr>
                  <th>Employee</th>
                  <th>Code</th>
                  <th>DOJ</th>
                  <th>Department</th>
                  <th>Status</th>
                  <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>
                    <?php 
                    if($employees){ 
                       
                        
                            foreach ($employees as  $employee){
                    ?>
                    <tr>
                        <td><?php echo($employee->employee_name);?></td>
                        <td><?php echo($employee->employee_code);?></td>
                        <td><?php echo(date('d-m-Y', strtotime($employee->employee_doj)));?></td>
                        <td><?php echo($employee->department_name);?></td>
                         <td><?php echo($employee->employee_status);?></td>
                        <td>
                             <?php if($this->session->user_data['role']=='Admin') {?>
                            <a href="<?php echo(base_url()); ?>employee/addedit/<?php echo($employee->employee_id); ?>" class="btn btn-primary btn-xs" role="button">Edit
                            <i class="fa fa-edit"></i></a>
                            
                            
<!--                            <button type="button" class="btn btn-primary btn-xs" id="addnew">Edit
                            <i class="fa fa-edit"></i></button>-->
                            <button type="button" class="btn btn-danger btn-xs" id="addnew">Delete
                            <i class="fa fa-remove"></i></button>
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


