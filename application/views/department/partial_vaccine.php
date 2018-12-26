<!-- <div class="box box-primary"></div>  -->
<div class="box-header with-border"></div>
            <div class="box-header with-border">
                <h3>Vaccination schedule</h3>
            </div>
                

<table class="table table-condensed" id="vacctbl">
                <tbody>
                <tr>
                  <th>Vaccine</th>
                  <th>Schedule</th>                 
                </tr>
               <?php 
                    if($schedule){
                        foreach ($schedule as $value) {
                  ?> 
                <tr id="row_<?php echo($value["parent_vaccine"]); ?>">
                  <td>
                      <input type="hidden" id="hdvaccineId" name="hdvaccineId[]" value="<?php echo($value["vaccineId"]); ?>" class="vaccineids"/>
                      <?php echo($value['vaccine']);?>
                  </td>
                  <td>
                      <?php echo($value['scheduleDate']);?>
                      <input type="hidden" name="scheduledate[]" id="scheduledate" value="<?php echo($value['scheduleDate']);?>"/>
                  </td>
                  
                  
                </tr>
                    <?php } } ?> 
                
              </tbody>
</table>
