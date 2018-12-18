<section class="content-header">
      <h1>
        Medica
        <small>vaccination schedule</small>
      </h1>
      <ol class="breadcrumb">
          <li><a href="<?php echo(base_url())?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">
              
              <a href="<?php echo(base_url())?>employee"><i class="fa fa-address-card-o"></i> Vaccine</a>
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
              <h3 class="box-title">Vaccine</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo $this->session->flashdata('code_exist'); ?>
            <?php echo $this->session->flashdata('vaccine_insert_error'); ?>
            <form role="form" name="frmvaccine" method="post" action="<?php echo(base_url()) ?>vaccine/action">
              <div class="box-body">
                  <input type="hidden" name="hdvaccineId"  value="<?php echo($vaccineId); ?>"/>
                  <input type="hidden" name="mode" value="<?php echo($mode); ?>"/>
                  
                
                <div class="form-group">
                  <label for="employee_name">Vaccine *</label>
                  <input type="text" class="form-control" id="vaccine" name="vaccine" 
                         placeholder="Enter vaccine name" 
                         value="<?php echo(($mode=="edit"?$vaccine->vaccine:set_value('vaccine'))); ?>">
                   <?php echo form_error('vaccine'); ?>
                </div>
                
                <div class="form-group">
                  <label for="parent_vaccine">Previous </label>
                 <select class="form-control selectpicker"  data-actions-box="true" id="parent_vaccine" name="parent_vaccine">
                          
                     <option value="">--Select--</option>
                     <?php 
                          
                          if($parentVaccineList){
                                foreach($parentVaccineList as $val){
                                    if($mode=="edit"){
                                        $boolFlagStatus=($val->id==$vaccine->parent_vaccine?TRUE:FALSE);
                              }else{
                                   $boolFlagStatus=FALSE;
                              }
                              ?>
                          <option value="<?php echo($val->id);?>" <?php echo  set_select('parent_vaccine', $val->id,$boolFlagStatus); ?>>
                            <?php echo($val->vaccine); ?></option>
                          <?php } 
                          }
                          ?>
               </select>
               </div>  
                  
                  
                  
                
                <div class="form-group">
                  
                    
                  <label for="employee_code" id='day_msg'>
                      
                     <?php if($mode=='edit'){ 
                            if($vaccine->parent_vaccine=="" ){
                                echo("Day's of interval from joining");
                            }else{
                                echo("Day's of interval from previous vaccine");
                            }
                         
                         ?>
                            
                     <?php }else{ ?>
                       Day's of interval from joining
                     <?php } ?>
                      
                     
                  
                  </label>
                  
                  
                  
                  <input type="text" class="form-control" id="frequency" name="frequency" 
                         placeholder="Enter Interval days" 
                         value="<?php echo(($mode=="edit"?$vaccine->frequency:set_value('frequency'))); ?>">
                </div>  
                   
                <div class="form-group">
                 
                  <label for="is_depend_doj">Is DOJ Dependent </label>
                 <select class="form-control selectpicker"  data-actions-box="true" id="is_depend_doj" name="is_depend_doj">
                     
                      <?php 
                          if($vacc_doj){
                                foreach($vacc_doj as $key=>$val){
                                    if($mode=="edit"){
                                        $boolFlagStatus=($key==$vaccine->is_depend_doj?TRUE:FALSE);
                              }else{
                                   $boolFlagStatus=FALSE;
                              }
                              ?>
                          <option value="<?php echo($key);?>" <?php echo  set_select('is_depend_doj', $key,$boolFlagStatus); ?>> 
                              <?php echo($val); ?>
                          </option>
                          <?php } 
                          }
                      ?>
               </select>
                   
                </div>   
                  
                   <?php
//             vaccination_cert_given_date     echo('<pre>');
//                          print_r($employeeStatus);
//                          echo('</pre>');
                  ?>
                   
                

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
               <a href="<?php echo(base_url()); ?>vaccine" class="btn btn-primary" role="button">Cancel</a>
              </div>
            </form>
          </div>
          
        </div>
        <div class="col-md-3"></div>
      </div>
</section>
