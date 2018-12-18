<section class="content-header">
      <h1>
        Medica
        <small>Vccination Schedule</small>
      </h1>
      <ol class="breadcrumb">
          <li><a href="<?php echo(base_url())?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Vaccine</li>
      </ol>
</section>
<section class="content">
   <div class="row">
       <div class="col-xs-12">
           <div class="box">
            <div class="box-header">
              <h3 class="box-title">Vaccine(s)</h3>
              <?php if($this->session->user_data['role']=='Admin') {?>
              <a href="<?php echo(base_url()); ?>vaccine/addedit" class="pull-right btn btn-primary" role="button">Add <i class="fa fa-plus"></i></a>
              
              <?php }?>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped medicadatatable">
                <thead>
                <tr>
                  <th>Vaccine</th>
                  <th>Dose Frequency (Days)</th>
                  <th>Previous</th>
                  <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>
                    <?php 
                    if($vaccines){ 
                       
                        
                            foreach ($vaccines as  $vaccine){
                    ?>
                    <tr>
                        <td><?php echo($vaccine->vaccine);?></td>
                        <td><?php echo($vaccine->frequency);?></td>
                        <td><?php echo($vaccine->parent);?></td>
                        
                        <td>
                             <?php if($this->session->user_data['role']=='Admin') {?>
                            <a href="<?php echo(base_url()); ?>vaccine/addedit/<?php echo($vaccine->id); ?>" class="btn btn-primary btn-xs" role="button">Edit
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


