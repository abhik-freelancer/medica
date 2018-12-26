<?php if($employee_details){ 
   //  echo "<pre>";
    // print_r($employee_details);
    // echo $employee_details['employee'][0]->department_id;
    // print_r($employee_details['department']);
    // echo "</pre>";
    // exit();
    $department_id=$employee_details['employee'][0]->dept_id;
    $emp_dept_id=$employee_details['employee'][0]->emp_dept_id;
    foreach($employee_details['employee'] as $val){
        $doj_date=$val->employee_doj;
        $explode=explode(" ",$doj_date);
        $doj=$explode[0];
        //print_r($val);
?>
    <div class="form-group col-md-6" > 
        <label for="employee_code">Employee Code </label>
        <input type="hidden" name="emp_dept_id" value="<?php echo $emp_dept_id; ?>">
        
        <input readonly type="text" class="form-control" value="<?php echo $val->employee_code; ?>" name="employee_code" id="employee_code">
    </div>
    <div class="form-group col-md-6" > 
        <label for="doj">DOJ </label>
        <input readonly type="text" class="form-control" name="doj" id="doj" value="<?php echo $doj; ?>">
    </div>        
<?php 
    }     
?>
<div class="form-group col-md-6" > 
    <label for="new_department">Transfer to Department *</label>                    
    <select id="new_department" name="new_department"  data-actions-box="true" class="form-control selectpicker">
        <option value="0" >-- Select Employee --</option>
        <?php foreach($employee_details['department'] as $val){ ?>

            <option value="<?php echo $val->department_id; ?>" <?php
            if($val->department_id==$department_id)
            {
                echo " disabled";
            }
            
            ?>><?php echo $val->department_name; ?></option>

        <?php
        }
        ?>
    </select>
</div>


<?php
    
}
?>
