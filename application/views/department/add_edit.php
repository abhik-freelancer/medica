<section class="content-header">
      <h1>
        Medica
        <small>Vaccine schedule</small>
      </h1>
      <ol class="breadcrumb">
          <li><a href="<?php echo(base_url())?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">
              
              <a href="<?php echo(base_url())?>department"><i class="fa fa-address-card-o"></i> Department</a>
          </li>
      </ol>
</section>
<section class="content">
    
    <div class="row">
        <!-- left column -->
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Department</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo $this->session->flashdata('department_exist'); ?>
            <?php echo $this->session->flashdata('department_insert_error'); ?>
            <form role="form" name="frmdept" method="post" action="<?php echo(base_url()) ?>department/action">
              <div class="box-body">
                  <input type="hidden" name="hddepartmentId"  value="<?php echo($department_id); ?>"/>
                  <input type="hidden" name="mode" value="<?php echo($mode); ?>"/>
                <div class="form-group">
                  <label for="departmentname">Department *</label>
                  <input type="text" class="form-control" id="departmentname" name="departmentname" placeholder="Enter department" 
                         value="<?php  echo(($mode=="edit"?$department->department_name:"")); ?>">
                   <?php echo form_error('departmentname'); ?>
                </div>
                  
                  <div class="form-group">
                      <?php
//                      $selected =explode(",", $selected_vaccine); 
//                              echo '<pre>';
//                              print_r($selected);
//                              echo '</pre>';
                      
                      ?>
                      <label for="vaccinelst">Vaccine</label>
                      <select class="form-control selectpicker" multiple data-actions-box="true" id="vaccinelst" name="vaccinelst[]">
                          <option value="">--Select--</option>
                          <?php if($vaccinelist){
                                $selected = explode(",", $selected_vaccine); 
                              
                              foreach($vaccinelist as $val){
                              ?>
                          <option value="<?php echo($val->id); ?>"  <?php if(in_array($val->id, $selected)){echo 'selected';}?>  > <?php echo($val->vaccine); ?></option>
                          <?php } 
                          }
                          ?>
                       </select>

                  </div>
                
<!--                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" id="exampleInputFile">

                  <p class="help-block">Example block-level help text here.</p>
                </div>-->
<!--                <div class="checkbox">
                  <label>
                    <input type="checkbox"> Check me out
                  </label>
                </div>-->
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
               <a href="<?php echo(base_url()); ?>department" class="btn btn-primary" role="button">Cancel</a>
              </div>
            </form>
          </div>
          
        </div>
        <div class="col-md-3"></div>
      </div>
</section>
