<?php
 if($groupbylist)
 {
 
?>
<div  id="Div_close">             
<section>
    <div class="box box-widget widget-user-2">
    <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-green">
        <div class="widget-user-image">
          <img class="img-circle" src="<?php base_url(); ?>assets/dist/img/list.png" alt="User Avatar">          
        </div>
        <!-- /.widget-user-image -->
        <div class="row">
            <h3 style="margin-left: 93px;"><?php echo $groupbylist['listname']; ?>           
            <button style="margin-right: 28px;" type="button" onclick=" $('#Div_close').hide();" class="close" >Close</button>
            </h3>
        </div>
        
      </div>
      <div class="box-footer no-padding ">
        <ul class="nav nav-stacked">

        <?php
               $firstDayThisMonth=date('01-m-Y');
               $lastDayThisMonth = date("t-m-Y");
                    foreach ($groupbylist['list'] as  $key=>$value) {                   
                     if(isset($value->id))
                     {
                    ?>
                     

                     <li><a  href="<?php base_url(); ?>reminder/index/<?php echo $value->id; ?>/<?php echo  $firstDayThisMonth;?>/<?php echo  $lastDayThisMonth; ?>"><?php echo $value->name; ?><span class="pull-right badge bg-aqua"><?php echo $value->no_of_employee; ?></span></a></li>                
                    <?php 
                     }else{
                     ?>
                     <li><a  href="#"><?php echo $value->name; ?><span class="pull-right badge bg-aqua"><?php echo $value->no_of_employee; ?></span></a></li>
                     <?php 
                     }
                    }                
        ?> 
         
        </ul>
      </div>
  </div>
</section>
</div>
<?php } ?>