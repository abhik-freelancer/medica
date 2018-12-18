<form name="frm_vaccine_schedule" action="<?php echo(base_url()); ?>reminder/updateschdl"></form>
<table id="example1" class="table table-bordered table-striped medicadatatable">
                <thead>
                <tr>
                  <th>Employee</th>
                  <th>Code</th>
                  <th>DOJ</th>
                  <th>Department</th>
                  <th>Schedule</th>
                  <th>Given</th>
                  <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>
                  <?php if($vaccineschdl){
                      
                      foreach($vaccineschdl as $val)
                      {
                      ?>
                    
                    <tr>
                        <td>
                            <input type="hidden" value="<?php echo($val->employee_id); ?>" id="empid_<?php echo($val->employe_vaccine_id); ?>"/>
                            <input type="hidden" value="<?php echo($val->department_id); ?>" id="empdept_<?php echo($val->employe_vaccine_id); ?>" />
                            <?php echo($val->employee_name); ?>
                        </td>
                        <td><?php echo($val->employee_code); ?></td>
                        <td><?php echo($val->employee_doj); ?></td>
                        <td><?php echo($val->department_name); ?></td>
                        <td>
                            <input type="hidden" value="<?php echo($val->schedule_date); ?>" id="vaccineschdt_<?php echo($val->employe_vaccine_id); ?>"/>
                            <?php echo($val->schedule_date); ?>
                        
                        </td>
                        <td>
                             <input type="text" autocomplete="off" id="vaccine_taken_date_<?php echo($val->employe_vaccine_id); ?>" 
                                    value="<?php echo($val->actual_given_date) ?>"
                             class="form-control datepicker " name="givenDt[]" style="width: 100px;" placeholder="">
                        </td>
                        <td>
                            <?php if($val->is_given!='Y'){ ?>
                            <button type="submit" value="<?php echo($val->employe_vaccine_id); ?>" class="btn btn-primary updt_vaccine">Update</button>
                            <?php } ?>
                        </td>
                    </tr>
                  <?php
                  
                      }
                      } ?>  
                    
                </tbody>
               
</table>


