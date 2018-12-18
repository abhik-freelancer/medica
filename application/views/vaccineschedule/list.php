<section class="content-header">
      <h1>
        Medica
        <small>Vccination Schedule</small>
      </h1>
      <ol class="breadcrumb">
          <li><a href="<?php echo(base_url())?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Employee wise vaccine schedule</li>
      </ol>
</section>
<section class="content">
   <div class="row">
       <div class="col-xs-12">
           <div class="box">
            <div class="box-header">
              <h3 class="box-title">Employee wise vaccine schedule</h3>
             </div>
               
               <div class="box box-danger">
            <div class="box-header with-border">
              
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-xs-3">
                    &nbsp;
                </div>
                <div class="col-xs-4">
                 <div class="form-group">
                  <label for="employee_name">Employee *</label>
                  <select class="form-control selectpicker"  data-actions-box="true" id="employee" name="employee">
                          <option value="">--Select--</option>
                          <?php if($employeeList){
                             
                              foreach($employeeList as $val){ ?>
                              
                          <option value="<?php echo($val->employee_id); ?>" >
                            <?php echo($val->employee_name); ?>
                          </option>
                          <?php } 
                          }
                          ?>
               </select>
                </div>
                </div>
                <div class="col-xs-5" style="margin-top: 14px;">
                    <button type="button" class="btn bg-maroon btn-flat margin" >Generate</button>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
                <!-- /.box-body -->
          </div>
       </div>
   </div>