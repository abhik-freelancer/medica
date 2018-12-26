<section class="content-header">
      <h1>
        Medica
        <small>Change Department</small>
      </h1>
      <ol class="breadcrumb">
          <li><a href="<?php echo(base_url())?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">
              
              <a href="<?php echo(base_url())?>changedepartment"><i class="fa fa-address-card-o"></i>Change Department</a>
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
              <h3 class="box-title">Change Department</h3>
            </div>
            <?php

            if($this->session->flashdata('item')) {
             $message = $this->session->flashdata('item');
            ?>
              <script>
                window.setTimeout(function() {
                    $("#alertMessage").fadeTo(500, 0).slideUp(500, function(){
                        $(this).remove(); 
                    });
                }, 1000);
              </script>

              <div id="alertMessage" class="<?php echo $message['class'] ?>" role="alert">
                <strong><?php echo $message['message'];  ?></strong>.
              </div>
            <?php
            }
            ?>
            <div class="box-body">
            
            <form name="change_department_form" id="change_department_form" method="post" action="<?php echo(base_url())?>changedepartment/employeeDataToStore">
                <div class="form-row">
                  <div class="form-group col-md-6">  
                    <label for="chose_department">Current Department *</label>                  
                    <select name="chose_department" id="chose_department" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                      <option value="0">-- Select Department --</option>
                      <?php
                      foreach ($departmentlist as $department) {
                        //echo $employee->employee_code ."  " .$employee->employee_name;
                        //data-subtext=""                      
                      ?>
                      <option value="<?php echo $department->department_id; ?>" ><?php echo $department->department_name; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                    <?php echo form_error('chose_department'); ?>
                  </div>

                  <div class="form-group col-md-6" > 
                    <label for="employee">Employee *</label>
                    <div id="user_empl">
                      <select id="employee" class="form-control selectpicker">
                        <option value="0">-- Select Employee --</option>
                      </select>
                    </div>
                    <?php echo form_error('employee'); ?>
                  </div>
                </div> 
                <div class="form-row">
                  <div id="replace">
                    <div class="form-group col-md-6" > 
                      <label for="employee_code">Employee Code </label>
                      <input readonly type="text" class="form-control" name="employee_code" id="employee_code">
                    </div>  
                    <div class="form-group col-md-6" > 
                      <label for="doj">DOJ </label>
                      <input readonly type="text" class="form-control" name="doj" id="doj">                    
                    </div> 
                    <div class="form-group col-md-6" > 
                      <label for="new_department">Transfer to Department *</label>                    
                      <select id="new_department" class="form-control selectpicker">
                        <option value="0" >-- Select Employee --</option>

                      </select>
                    <?php echo form_error('new_department'); ?>                      
                    </div>
                  </div>
                  <div class="form-group col-md-6" > 
                    <label for="dot">DOT *</label>
                    <input  type="text" class="form-control datepicker" autocomplete="off" name="dot" id="dot">
                    <?php echo form_error('dot'); ?>                
                  </div>                               
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <div id="vaccineshedule"></div>
                  </div>
                </div>     
                <div class="form-group col-md-12" >           
                <button style="margin-left: 46%;" type="submit" class="btn btn-primary ">Submit</button>
                </div>
                
              </form>
            </div>
          </div> 
        </div>
        <div class="col-md-1"></div>
      </div>
</section>
