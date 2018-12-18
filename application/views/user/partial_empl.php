<select class="form-control selectpicker"  data-actions-box="true" id="employee" name="employee">
    <option value="">-- Select Employee -- </option>
    <?php if($empview){ 
            foreach($empview as $val){
        ?>
    <option value="<?php echo($val->employee_id); ?>">
    <?php echo($val->employee_name); ?>
    </option>
        
    <?php } 
    }
    ?>
</select>
