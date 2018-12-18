<div class="box box-primary">
            <div class="box-header with-border">
                Vaccination schedule
            </div>
                
</div>
<table class="table table-condensed" id="vacctbl">
                <tbody>
                <tr>
                  <th>Vaccine</th>
                  <th>Schedule</th>
                  <th>Given</th>
                  <th>Action</th>
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
                  <td>
                      <input type="text" autocomplete="off" id="<?php echo($value["vaccineId"]); ?>" 
                             class="form-control datepicker vaccine_taken_date" name="givenDt[]" style="width: 100px;" placeholder="">
                  </td>
                  <td>
                      <input type="hidden" name="hdParentId[]" id="hdParentId"  value="<?php echo($value["parent_vaccine"]); ?>"/>
                      <?php if($value["parent_vaccine"]!=""){ ?>
                      <button type="button" class="btn btn-danger btn-xs" id="<?php echo($value["parent_vaccine"]); ?>">Delete</button>
                      <?php } ?>
                  </td>
                  
                </tr>
                    <?php } } ?> 
                
              </tbody>
</table>
<script>
//$(document).ready(function(){
//    var basePath= $("#basepath").val();
////    $('.datepicker').datepicker({
////                     format: 'dd-mm-yyyy',
////                     todayHighlight: true,
////                     uiLibrary: 'bootstrap'
////                    });
//                    
//            $("body").on("click", ".datepicker", function(){
//            $(this).datepicker({
//                 format: 'dd-mm-yyyy',
//                    todayHighlight: true,
//                     uiLibrary: 'bootstrap',
//                      autoclose: true
//            });
//            $(this).datepicker("show");
//    });  
//    
//    $("body").on('click','.rdel',function(){
//        var rowId = $(this).val();
//       //alert(rowId);
//       $("#row_"+rowId).remove();
//       
//    });
//       $("body").on('change','.vaccine_taken_date',function(){
//        var vacine_id = $(this).attr("id");
//        //alert(vacine_id);
//        var given_date = $(this).val()|| "";
//        //console.log(given_date);
//        $('.vaccineids').each(function(i){
//            //console.log(i);
//            console.log($(this).val());
//        });
//        
//        if(given_date!=""){
//            
//            $.ajax({
//         url: basePath+'employee/getChildVaccine',
//         data: {
//             vaccineId: vacine_id,givendate:given_date
//         },
//         type: "post",
//         dataType: "json",
//         success: function (data) {
//            // $("#vacctbl tr:last").after(data);
//               //$('.datepicker').datepicker();
//               console.log(data);
//               var flag=0;
//                $('.vaccineids').each(function(i){
//                    //console.log(i);
//                    if(data.childVaccineId==$(this).val()){flag=1;}
//                        
//                        //console.log($(this).val());
//                    });
//               if(flag==1){
//                   $("#row_"+data.parentId).remove();
//               }     
//               if(data.childVaccineId!=""){
//                 var html_data ='';
//		 html_data = '<tr id="row_'+data.parentId+'">';
//                 html_data +='<td> <input type="hidden" id="hdvaccineId" name="hdvaccineId[]" value="'+data.childVaccineId+'" class="vaccineids"/> '+data.childVaccine+'</td>';
//                 html_data +='<td><input type="hidden" name="scheduledate[]" id="scheduledate" value="'+data.childScheduleDate+'"/>'+data.childScheduleDate+'</td>';
//                 html_data +='<td><input type="text" autocomplete="off"  id="'+data.childVaccineId+'" class="form-control datepicker vaccine_taken_date" name="givenDt[]" style="width: 100px;" placeholder=""></td>';
//                 html_data +='<td><input type="hidden" name="hdParentId[]" id="hdParentId"  value="'+data.parentId+'"/><button type="button" value="'+data.parentId+'" class="btn btn-danger btn-xs rdel">Delete</button></td></tr>'; 
//                 $("#vacctbl tr:last").after(html_data);
//             }
//              // else{
////                    console.log(data.givenDate);
////                    $(this).val(data.givenDate);
//               // }     
//               
//         },
//         error: function (xhr, status) {
//             alert("Sorry, there was a problem!");
//         },
//         complete: function (xhr, status) {
//             //$('#showresults').slideDown('slow')
//         }
//     });
//    }
//       
//    });                    
//});
</script>
