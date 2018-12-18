 <section class="content-header">
      <h1>
         Medica
        <small>Vccination Schedule</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Employee import</li>
      </ol>
    </section>

    <!-- Main content -->
 <section class="content">

    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-6">
        <div class="box box-primary formBlock">
              <div class="box-header with-border">
                <h3 class="box-title">Employee - Import </h3>
                 <a href="<?php echo base_url();?>employee" class="link_tab"><span class="glyphicon glyphicon-list"></span> List</a>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
            
<form role="form" id="fupForm"  enctype="multipart/form-data">
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <input type="file" id="employeeexcel" name="employeeexcel">
                        <p id="employeeimport_err_msg" class="form_error"></p>
                  </div>

                  <p id="investigation_errmsg" class="form_error"></p>
                  <div class="btnDiv">
                      <button type="submit" class="btn btn-primary formBtn" id="emp_import" style="display: inline-block;">
                          <?php echo $btnText; ?>
                      </button>
                      <a href="<?php echo(base_url()) ?>upload/employee_template/templateEmployee.xls" class="btn btn-success formBtn" 
                         style="display: inline-block;" download ><i class="fa fa-download"></i> Template</a>
                  </div>
                </div>
</form>

              
            <div class="custom_loader" style="display:none;" id="employee_upload_loader">
              <div class="loader_spinner"></div>
              <p class="loading-text">Please wait ...</p>
            </div>

            
            </div>
            <!-- /.box -->      
      </div>
        <div class="col-md-2"></div>
    </div>

    </section>
    <!-- /.content -->

    <!-- bootstrap time picker -->


    <!--- Success Modal---->
<div class="modal fade xlsinvModal" id="employee_proceess_modal">
         <div class="modal-dialog">
           <div class="modal-content">
              <div id="modal_employee_content"></div>
           </div>
           <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- end success modal-->

