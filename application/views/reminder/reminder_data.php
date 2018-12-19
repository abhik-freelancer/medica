<section class="content-header">
      <h1>
        Medica
        <small>vaccination schedule</small>
      </h1>
      <ol class="breadcrumb">
          <li><a href="<?php echo(base_url())?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Vaccination Reminder</li>
      </ol>
</section>

<section class="content">
    <div class="row">
        
        <div class="col-xs-12">
            <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Vaccination Schedule Reminder</h3>
            </div>
           <div class="box box-danger">
            <div class="box-body">
              <div class="row">
                <div class="col-xs-3">
                  <input type="text" class="form-control datepicker" id="sch-from-date" placeholder="From date">
                </div>
                <div class="col-xs-3">
                  <input type="text" class="form-control datepicker" placeholder="To date" id="sch-to-date">
                </div>
               <div class="col-xs-2">
  <select class="form-control selectpicker"  data-actions-box="true" id="vaccine_reminder" name="vaccine_reminder">
                          <option value="">--Select vaccine--</option>
                          <?php if($vaccines){
                            
                              foreach($vaccines as $val){
                            
                              ?>
                          <option value="<?php echo($val->id); ?>" >
                            <?php echo($val->vaccine); ?>
                          </option>
                          <?php } 
                          }
                          ?>
                </select>
                  
                </div>
                <div class="col-xs-3">
                 <select class="form-control selectpicker"  data-actions-box="true" id="dept" name="dept">
                          <option value="">--All--</option>
                          <?php if($department){
                            
                              foreach($department as $val){
                            
                              ?>
                          <option value="<?php echo($val["department_id"]); ?>" >
                            <?php echo($val["department_name"]); ?>
                          </option>
                          <?php } 
                          }
                          ?>
                </select>
                </div>
                  <div class="col-xs-1">
                      <button class="btn btn-sm btn-secondary" id="srch-sch"><i class="fa fa-search-plus"></i></button>
                  </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
            
          </div>
        </div>
        
        
        
    </div>
    <div class="row">
        <div class="col-md-12">
            
            <div class="box box-danger">
             <!-- /.box-body -->
            <!-- Loading (remove the following to stop the loading)-->
            <div class="box-header">
              <h3 class="box-title"></h3>
            </div>
            <div class="box-body">
               
            <div class="overlay" style="display: none;">
              <i class="fa fa-refresh fa-spin"> </i>
            </div>
                <div id="schdl-view">

                </div>
            </div>
            
            <!-- end loading -->
          </div>
           
        </div>
    </div>
    
<!-- error modal -->

    
    
    
</section>
<div class="modal fade modal-success" id="schdl-action-msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Schedule update </h4>
      </div>
      <div class="modal-body " id="shedule-update-message">
       
      </div>
      <div class="modal-footer">
        <button type="button" id="schd-okay" class="btn btn-outline pull-left" data-dismiss="modal">Okay</button>
       
      </div>
    </div>
  </div>
</div>


