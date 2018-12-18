<section class="content-header">
      <h1>
        Medica
        <small>vaccination schedule</small>
      </h1>
      <ol class="breadcrumb">
          <li><a href="<?php echo(base_url())?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">
              
              <a href="<?php echo(base_url())?>employee"><i class="fa fa-address-card-o"></i> User</a>
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
              <h3 class="box-title">User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo $this->session->flashdata('login_exist'); ?>
            <?php echo $this->session->flashdata('user_insert_error'); ?>
            <form role="form" name="frmuser" method="post" action="<?php echo(base_url()) ?>user/action">
              <div class="box-body">
                  <input type="hidden" name="hduserid"  value="<?php echo($user_id); ?>"/>
                  <input type="hidden" name="mode" value="<?php echo($mode); ?>"/>
                  
                
                <div class="form-group">
                  <label for="user_login_name">User *</label>
                  <input type="text" class="form-control" id="user_login_name" name="user_login_name" 
                         placeholder="Enter user" autocomplete="new-user"
                         value="<?php echo(($mode=="edit"?$user->username:set_value('user_login_name'))); ?>" >
                   <?php echo form_error('user_login_name'); ?>
                </div>
                
                <div class="form-group">
                  <label for="user_password">Password *</label>
                  <input type="password" class="form-control" id="user_password" name="user_password" autocomplete="new-password"
                         placeholder="Enter password" 
                         value="<?php echo(($mode=="edit"?$user->password:set_value('user_password'))); ?>">
                   <?php echo form_error('user_password'); ?>
                </div>
           
                <div class="form-group">
                  <label for="user_type">User Type *</label>
                 <select class="form-control selectpicker"  data-actions-box="true" id="user_type" name="user_type">
                     <option value="">--Select--</option>
                          <?php 
                          
                          if($usertype){
                                foreach($usertype as $key=>$val){
                                    if($mode=="edit"){
                                        $boolFlagStatus=($key==$user->user_type?TRUE:FALSE);
                              }else{
                                   $boolFlagStatus=FALSE;
                              }
                              ?>
                          <option value="<?php echo($key);?>" <?php echo  set_select('user_type', $key,$boolFlagStatus); ?>> <?php echo($val); ?></option>
                          <?php } 
                          }
                          ?>
               </select>
                   <?php echo form_error('user_type'); ?>
                </div>   
                  
                  
                <div class="form-group">
                  <label for="departmentname">Department *</label>
                 <select class="form-control selectpicker"  data-actions-box="true" id="departmentname" name="departmentname">
                          <option value="">--Select--</option>
                          <?php if($departmentList){
                             
                              foreach($departmentList as $val){
//                                   if($mode=="edit"){
//                                        $boolFlagDept=($val->department_id==$employee->department_id?TRUE:FALSE);
//                              }else{
//                                   $boolFlagDept=FALSE;
//                              }
                              ?>
                          <option value="<?php echo($val->department_id); ?>"
                                   <?php if($mode=='edit'){ if($user->department_id==$val->department_id){echo('selected');} }?> >
                            <?php echo($val->department_name); ?>
                          </option>
                          <?php } 
                          }
                          ?>
               </select>
                   <?php echo form_error('departmentname'); ?>
                </div>
                  
                  <div class="form-group">
                  <label for="employee">Employee *</label>
                  <div id="user_empl">
                  <select class="form-control selectpicker"  data-actions-box="true" id="employee" name="employee">
                      <option value="">-- Select Employee -- </option>
                      
                      <?php if($employeeList){ 
                            foreach($employeeList as $employee){
                          ?>
                      <option value="<?php  $employee->employee_id ?>" <?php if($employee->employee_id==$user->employee_id){echo('selected');} ?> > <?php echo ($employee->employee_name); ?> </option>
                      <?php } }?>
                      
                  </select>
                  </div>    
                  <?php echo form_error('employee'); ?>
                  </div>
                
                  </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
               <a href="<?php echo(base_url()); ?>user" class="btn btn-primary" role="button">Cancel</a>
              </div>
            </form>
          </div>
          
        </div>
        <div class="col-md-3"></div>
      </div>
</section>
