<section class="content-header">
      <h1>
        Medica
        <small>vaccination schedule</small>
      </h1>
      <ol class="breadcrumb">
          <li><a href="<?php echo(base_url())?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Department</li>
      </ol>
</section>
<section class="content">
   <div class="row">
       <div class="col-xs-12">
           <div class="box">
            <div class="box-header">
              <h3 class="box-title">Department(s)</h3>
              <?php if($this->session->user_data['role']=='Admin') {?>
              <a href="<?php echo(base_url()); ?>department/addedit" class="pull-right btn btn-primary" role="button">Add <i class="fa fa-plus"></i></a>
              
              <?php }?>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped medicadatatable">
                <thead>
                <tr>
                  <th>Department</th>
                  <th>Hospital</th>
                  <th>Associated Vaccine</th>
                  <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>
                    <?php 
                    if($departments){ 
                       
                        
                            foreach ($departments as  $department){
                    ?>
                    <tr>
                        <td><?php echo($department["department_name"]);?></td>
                        <td><?php echo($department["hospital_name"]);?></td>
                        <td><?php echo($department["vaccinelist"]);?></td>
                        <td>
                             <?php if($this->session->user_data['role']=='Admin') {?>
                            <a href="<?php echo(base_url()); ?>department/addedit/<?php echo($department["department_id"]); ?>" class="btn btn-primary btn-xs" role="button">Edit
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


