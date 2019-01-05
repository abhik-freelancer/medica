<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<!-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

<form name="frm_vaccine_schedule" action="<?php echo(base_url()); ?>reminder/updateschdl"></form>
<table id="example1" class="table table-bordered table-striped medicadatatable ">
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
                            <input type="hidden" value="<?php echo($val->vaccination_id); ?>" id="vaccineid_<?php echo($val->employe_vaccine_id);?>"/>
                            <input type="hidden" value="<?php echo($val->employee_dept_id); ?>" id="employee_dept_id_<?php echo($val->employe_vaccine_id);?>"/>
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

<script type="text/javascript">
    	$(document).ready(function() {
    $('#example1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend:'copy', attr: { id: 'allan' } }, 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
    </script>
