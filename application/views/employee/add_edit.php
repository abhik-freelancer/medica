<section class="content-header">
      <h1>
        Medica
        <small>Vaccine schedule</small>
      </h1>
      <ol class="breadcrumb">
          <li><a href="<?php echo(base_url())?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">
              
              <a href="<?php echo(base_url())?>employee"><i class="fa fa-address-card-o"></i> Employee</a>
          </li>
      </ol>
</section>
<section class="content">
    
    <div class="row">
        <!-- left column -->
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Employee</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo $this->session->flashdata('code_exist'); ?>
            <?php echo $this->session->flashdata('employee_insert_error'); ?>
            <form role="form" name="frmemployee" method="post" action="<?php echo(base_url()) ?>employee/action">
              <div class="box-body">
                  <div class="row">
                      <div class="col-md-6">
                          <input type="hidden" name="hddemployeeid"  value="<?php echo($employee_id); ?>"/>
                          <input type="hidden" name="mode" value="<?php echo($mode); ?>"/>
                          <div class="form-group">
                            <label for="employee_name">Employee *</label>
                            <input type="text" class="form-control" id="employee_name" name="employee_name" autocomplete="off"
                                   placeholder="Enter employee" 
                                   value="<?php echo(($mode=="edit"?$employee->employee_name:set_value('employee_name'))); ?>">
                             <?php echo form_error('employee_name'); ?>
                          </div>
                          <div class="form-group">
                            <label for="employee_code">Employee mobile</label>
                            <input type="text" class="form-control" id="employee_mobile" name="employee_mobile" autocomplete="off"
                                   placeholder="Enter employee mobile" 
                                   value="<?php echo(($mode=="edit"?$employee->employee_mobile:set_value('employee_mobile'))); ?>">

                          </div>
                          
                          <div class="form-group">
                  <label for="employee_status">Status *</label>
                 <select class="form-control selectpicker"  data-actions-box="true" id="employee_status" name="employee_status">
                          <?php 
                          
                          if($employeeStatus){
                                foreach($employeeStatus as $key=>$val){
                                    if($mode=="edit"){
                                        $boolFlagStatus=($key==$employee->employee_status?TRUE:FALSE);
                              }else{
                                   $boolFlagStatus=FALSE;
                              }
                              ?>
                          <option value="<?php echo($key);?>" <?php echo  set_select('employee_status', $key,$boolFlagStatus); ?>> <?php echo($val); ?></option>
                          <?php } 
                          }
                          ?>
               </select>
                   
                </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                  <label for="departmentname">DOJ *</label>
                  <input type="text" class="form-control datepicker" id="employee_doj" name="employee_doj" autocomplete="off"
                         placeholder="" 
                         value="<?php echo(($mode=="edit"?date('d-m-Y', strtotime($employee->employee_doj)):set_value('employee_doj'))); ?>" <?php 
                  if($mode=="edit"){
                      echo " disabled";
                  }
                 ?>>
                   <?php echo form_error('employee_doj'); ?>
                </div> 
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                  <label for="departmentname">Certification Date</label>
                  <?php 
                    if($mode=="edit"){
                        if($employee->vaccination_cert_given_date==""){
                            $cert_date = "";
                        }else{
                            $cert_date=date('d-m-Y', strtotime($employee->vaccination_cert_given_date));
                        }
                    }
                  
                  ?>
                    <input type="text" class="form-control datepicker" autocomplete="off" id="vaccination_cert_given_date" name="vaccination_cert_given_date" 
                         placeholder="" 
                         value="<?php echo(($mode=="edit"?
                                 $cert_date:set_value('vaccination_cert_given_date'))); ?>">
                   
                </div>  
                              </div>
                          </div>
                
                          
                          
                          
                          <!--first div-->
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="employee_code">Employee Code*</label>
                            <input type="text" class="form-control" id="employee_code" autocomplete="off" name="employee_code" <?php if($mode=="edit"){echo('readonly');} ?>
                                   placeholder="Enter employee code" 
                                   value="<?php echo(($mode=="edit"?$employee->employee_code:set_value('employee_code'))); ?>">
                             <?php echo form_error('employee_code'); ?>
                           </div>
                           <div class="form-group">
                            <label for="employee_code">Employee email</label>
                            <input type="email" class="form-control" id="employee_email" name="employee_email" autocomplete="off"
                                   placeholder="Enter employee email" 
                                   value="<?php echo(($mode=="edit"?$employee->employee_email:set_value('employee_email'))); ?>">

                          </div>  
                          <div class="form-group">
                  <label for="employeedepatrment">Department *</label>
                 <select class="form-control selectpicker"  data-actions-box="true" id="employeedepatrment" name="employeedepatrment" <?php 
                  if($mode=="edit"){
                      echo " disabled";
                  }
                 ?>>
                          <option value="">--Select--</option>
                          <?php if($departmentList){
                             
                              foreach($departmentList as $val){
                              if($mode=="edit"){
                                        $boolFlagDept=($val->department_id==$employee->department_id?TRUE:FALSE);
                              }else{
                                   $boolFlagDept=FALSE;
                              }
                              ?>
                          <option value="<?php echo($val->department_id); ?>" <?php echo  set_select('employeedepatrment', $val->department_id,$boolFlagDept); ?> >
                            <?php echo($val->department_name); ?>
                          </option>
                          <?php } 
                          }
                          ?>
               </select>
                   <?php echo form_error('employeedepatrment'); ?>
                </div>
                       
                          <!-- second-->
                      </div>
                      
                  </div> </div>
              <!-- /.box-body -->

              <div class="box-footer">
                  <div id="vaccine-sdchl">
                      <?php if($employeVaccineSchedule){?>
                          
                      <div class="box box-primary">
                        <div class="box-header with-border">
                            Vaccination schedule
                        </div>
                      </div>
                <table class="table table-condensed" id="vacctbl">
                <tbody>
                <tr>
                  <th>Vaccine</th>
                  <th>Schedule</th>
                  <th>Given</th>
<!--                  <th>Action</th>-->
                </tr>
                        <?php  
                        if ($employeVaccineSchedule) {
                        
                                foreach ($employeVaccineSchedule as $value){
                       ?>
                        
               
                <tr id="row_<?php echo($value->parent_vaccineId); ?>">
                  <td>
                      <input type="hidden" id="hdvaccineId" name="hdvaccineId[]" value="<?php echo($value->vaccination_id); ?>" class="vaccineids"/>
                      <?php echo($value->vaccine);?>
                  </td>
                  <td>
                      <?php echo($value->schedule_date==""?"":date('d-m-Y', strtotime($value->schedule_date)));?>
                      <input type="hidden" name="scheduledate[]" id="scheduledate" value="<?php echo($value->schedule_date==""?"":date('d-m-Y', strtotime($value->schedule_date)));?>"/>
                  </td>
                  <td>
                      <?php echo($value->actual_given_date==""?"":date('d-m-Y', strtotime($value->actual_given_date)));?>
<!--                      <input type="text" autocomplete="off" id="<?php echo($value->vaccination_id); ?>" 
                             class="form-control datepicker vaccine_taken_date" name="givenDt[]" style="width: 100px;" placeholder=""
                             value="<?php echo($value->actual_given_date==""?"":date('d-m-Y', strtotime($value->actual_given_date)));?>"
                             >-->
                  </td>
<!--                  <td>-->
<!--                      <input type="hidden" name="hdParentId[]" id="hdParentId"  value="<?php echo($value->parent_vaccineId); ?>"/>-->
                      <?php if($value->parent_vaccineId!=""){ ?>
<!--                      <button type="button" class="btn btn-danger btn-xs rdel" value="<?php echo($value->parent_vaccineId); ?>">Delete</button>-->
                      <?php } ?>
<!--                  </td>-->
                  
                </tr>
                     <?php 
                            } 
                          }
                            ?>
                   </tbody>
                   </table>
                    
                
            
                      
                      
                      <?php 
                            
                          } ?>
                  </div>
               <button type="submit" class="btn btn-primary">Submit</button>
               <a href="<?php echo(base_url()); ?>employee" class="btn btn-primary" role="button">Cancel</a>
              </div>
            </form>
          </div>
          
        </div>
        <div class="col-md-1"></div>
      </div>
</section>

