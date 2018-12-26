$(document).ready(function(){
    var basePath= $("#basepath").val();
     $('.selectpicker').selectpicker();
     $('.datepicker').datepicker({
                     format: 'dd-mm-yyyy',
                     todayHighlight: true,
                     uiLibrary: 'bootstrap',
                     autoclose: true
                    });
    
// employee import
$("#fupForm").on('submit', function(e){
   
        e.preventDefault();
        var form = $('#fupForm')[0];
        var formData = new FormData(form);
        validateEmployeeImport(basePath,formData)
});

$("#departmentname").change(function(){
    var departId = $(this).val()||"";
    $.ajax({
        
        type: "GET",
        url: basePath + 'user/getEmployeeByDepartment/'+departId+'/1',
        dataType: "html",
        contentType:"application/x-www-form-urlencoded; charset=UTF-8",
        success: function(result) {
            $("#user_empl").html(result)
            $('.selectpicker').selectpicker({dropupAuto: false});
        },
        error: function(jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            // alert(msg);  
        }
    });
});

$("#parent_vaccine").change(function(){
    var value = $(this).val()||"";
    var msg="";
    if(value!=""){
        msg = "Day's of interval from previous vaccine";
    }else{
        msg = "Day's of interval from joining";
    }
    //alert(msg);
    $("#day_msg").text(msg);
});


$("body").on('change','#employee_doj',function(){
     var doj = $(this).val()||"";
     var department = $("#employeedepatrment").val();
     getVaccineSchedule(doj,department,basePath);
});

//$("#employee_doj").blur(
//        function(){
//            var doj = $(this).val()||"";
//            var department = $("#employeedepatrment").val();
//        getVaccineSchedule(doj,department,basePath);
// });
$("#employeedepatrment").change(function(){
    
    var doj = $("#employee_doj").val()||"";
    var department = $(this).val();
    getVaccineSchedule(doj,department,basePath);
});

// vaccination schedule detail //

$("body").on('click','.rdel',function(){
        var rowId = $(this).val();
       //alert(rowId);
       $("#row_"+rowId).remove();
       
    });
       $("body").on('change','.vaccine_taken_date',function(){
        var vacine_id = $(this).attr("id");
        //alert(vacine_id);
        var given_date = $(this).val()|| "";
        //console.log(given_date);
        $('.vaccineids').each(function(i){
            //console.log(i);
            console.log($(this).val());
        });
        
        if(given_date!=""){
            
            $.ajax({
         url: basePath+'employee/getChildVaccine',
         data: {
             vaccineId: vacine_id,givendate:given_date
         },
         type: "post",
         dataType: "json",
         success: function (data) {
            // $("#vacctbl tr:last").after(data);
               //$('.datepicker').datepicker();
               console.log(data);
               var flag=0;
                $('.vaccineids').each(function(i){
                    //console.log(i);
                    if(data.childVaccineId==$(this).val()){flag=1;}
                        
                        //console.log($(this).val());
                    });
               if(flag==1){
                   $("#row_"+data.parentId).remove();
               }     
               if(data.childVaccineId!=""){
                 var html_data ='';
		 html_data = '<tr id="row_'+data.parentId+'">';
                 html_data +='<td> <input type="hidden" id="hdvaccineId" name="hdvaccineId[]" value="'+data.childVaccineId+'" class="vaccineids"/> '+data.childVaccine+'</td>';
                 html_data +='<td><input type="hidden" name="scheduledate[]" id="scheduledate" value="'+data.childScheduleDate+'"/>'+data.childScheduleDate+'</td>';
                 html_data +='<td><input type="text" autocomplete="off"  id="'+data.childVaccineId+'" class="form-control datepicker vaccine_taken_date" name="givenDt[]" style="width: 100px;" placeholder=""></td>';
                 html_data +='<td><input type="hidden" name="hdParentId[]" id="hdParentId"  value="'+data.parentId+'"/><button type="button" value="'+data.parentId+'" class="btn btn-danger btn-xs rdel">Delete</button></td></tr>'; 
                 $("#vacctbl tr:last").after(html_data);
             }
              // else{
//                    console.log(data.givenDate);
//                    $(this).val(data.givenDate);
               // } 
               
               $('.datepicker').datepicker({
                     format: 'dd-mm-yyyy',
                     todayHighlight: true,
                     uiLibrary: 'bootstrap',
                     autoclose: true
                    });
               
         },
         error: function (xhr, status) {
             alert("Sorry, there was a problem!");
         },
         complete: function (xhr, status) {
             //$('#showresults').slideDown('slow')
         }
     });
    }
       
    }); 
// vaccination schedule detail end //

//vaccination shedule reminder//

$(document).on('click','#srch-sch',function(){
    var fromDate = $("#sch-from-date").val()||"";
    var toDate = $("#sch-to-date").val()||"";
    var vaccine =  $("#vaccine_reminder").val()||"";
    var department = $("#dept").val()||"";
    
    
    if(validateSearch())
    {
        $(".overlay").show();
        
        $.ajax({
        type: "POST",
        url: basePath + 'reminder/getVaccineSchedule',
        dataType: "html",
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        data:{"fromDate":fromDate,"toDate":toDate,"vaccine":vaccine,"department":department},
        success: function(result) {
            $(".overlay").hide();
            $("#schdl-view").html(result)
            $('.medicadatatable').DataTable();
            $('.datepicker').datepicker({
                     format: 'dd-mm-yyyy',
                     todayHighlight: true,
                     uiLibrary: 'bootstrap',
                     autoclose: true
                    });
        },
        error: function(jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            // alert(msg);  
        }
    });
    }
  
    
});

//update vaccine schedule
$(document).on('click',"#schd-okay",function(){
    $("#srch-sch").trigger("click");
});

$(document).on("click",".updt_vaccine",function(){
    let employee_vaccince_schid = $(this).val();
    let employee_id = $("#empid_"+employee_vaccince_schid).val()||"";
    let department_id = $("#empdept_"+employee_vaccince_schid).val()||"";
    let givendate = $("#vaccine_taken_date_"+employee_vaccince_schid).val()|| "";
    let vaccineid = $("#vaccineid_"+employee_vaccince_schid).val()||"";
    let employee_dept_id = $("#employee_dept_id_"+employee_vaccince_schid).val()||"";
    
    $.ajax({
        type: "POST",
        url: basePath + 'reminder/updateschdl',
        dataType: "JSON",
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        data:{employee_vaccince_schid:employee_vaccince_schid,employee_id:employee_id,department_id:department_id,givendate:givendate,vaccineid:vaccineid,employee_dept_id:employee_dept_id},
        success: function(result) {
            if(result.code==1){
//                alert("Update");
                
                $("#schdl-action-msg").modal("show");
                $("#shedule-update-message").text(result.msg);
                
            }else if(result.code==0){
                 alert("Error");
            }else{
                $(window).attr('location',basePath+'login');
            }
            
            
//            $(".overlay").hide();
//            $("#schdl-view").html(result)
//            $('.medicadatatable').DataTable();
//            $('.datepicker').datepicker({
//                     format: 'dd-mm-yyyy',
//                     todayHighlight: true,
//                     uiLibrary: 'bootstrap',
//                     autoclose: true
//                    });
        },
        error: function(jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            // alert(msg);  
        }
    });
    //alert(employee_vaccince_schid);
});
 
});
function validateSearch()
{
    var from_date = $("#sch-from-date").val()||"";
    var to_date = $("#sch-to-date").val()||"";
    var vaccine_reminder = $("#vaccine_reminder").val()||"";
    if(from_date==""){
        $("#error-message").text("From date can not be emplty.");
        $("#validation_err_model").modal('show');
        return false;
    }
    
    if(to_date==""){
        $("#error-message").text("To date can not be emplty.");
        $("#validation_err_model").modal('show');
        return false;
    }
    
    if(vaccine_reminder==""){
        $("#error-message").text("Please select a vaccine.");
        $("#validation_err_model").modal('show');
        return false;
    }
    
    //errormodal
    return true;
}

/*********************************************************************/
/********************************************************************/

function getVaccineSchedule(dateofjoin,departmentId,basepath)
{
    //alert("aaa");
    if(dateofjoin!="" && departmentId!=""){
        $.ajax({
         url: basepath+'employee/getVaccineSchedule',
         data: {
             doj: dateofjoin,deptId:departmentId
         },
         type: "post",
         dataType: "html",
         success: function (data) {
            // console.log("123"+data);
            // if(data==440){
            //     alert("440");
            //     window.location(basepath+"login");
            // }else{
             $("#vaccine-sdchl").html(data);
              //$('.datepicker').datepicker();
              $('.datepicker').datepicker({
                     format: 'dd-mm-yyyy',
                     todayHighlight: true,
                     uiLibrary: 'bootstrap',
                     autoclose: true
                    });
                //}
         },
         error: function (xhr, status) {
             alert("Sorry, there was a problem!");
         },
         complete: function (xhr, status) {
             //$('#showresults').slideDown('slow')
         }
     });
   }
}



function submitEmployee(basepath){
    $('#employee_proceess_modal').modal('hide');
    $("#emp_import").css("display", "none");
    $("#emp_import").addClass('nonclick');
    $("#employee_upload_loader").css("display", "block");

    var form = $('#fupForm')[0];
    var formData = new FormData(form);
    
    
    $.ajax({
        type: "POST",
        url: basepath + 'importemployee/importAction',
        dataType: "json",
        processData: false,
        contentType: false, // "application/x-www-form-urlencoded; charset=UTF-8",
        data: formData,
        success: function(result) {
            $("#custom_loader").css("display", "none");
            $("#emp_import").removeClass('nonclick');

            if (result.msg_status == 1) {

                $("#suceessmodal").modal({
                    "backdrop": "static",
                    "keyboard": true,
                    "show": true
                });
                var addurl =  basepath + "importemployee";
                var listurl = basepath + "employee";
                $("#responsemsg").text(result.msg_data);
                $("#response_add_more").attr("href", addurl);
                $("#response_list_view").attr("href", listurl);

            }

        },
        error: function(jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            // alert(msg);  
        }
    }); /*end ajax call*/
    
   
    //$("#updt_vaccine")
}



function validateEmployeeImport(basepath,formData)
{
    var employeeexcel = $("#employeeexcel").val()||"";
    
    if(employeeexcel==""){
         $("#employeeimport_err_msg").text("Select employee files for upload").css("display", "block");
        return false;
    }
    
    
     $.ajax({
            type: 'POST',
            url: basepath+"importemployee/validateEmployeeImport",
            data: formData,
             dataType: "json",
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.submitBtn').attr("disabled","disabled");
                
            },
            success: function(msg){
                if(msg.msg_status==1){
                    var count = msg.employee_name.length;
                    var dataDiv = '';
                dataDiv += '<div class="modal-header">';
                dataDiv += '<h4>Imported employee</h4>';
                dataDiv += '</div>';
                dataDiv += '<div class="modal-body" style="max-height:450px;overflow-y:scroll;">';
                dataDiv += '<table class="table table-bordered table-striped dataTables">';
                dataDiv += '<tr>';
                dataDiv += '<th>Code</th>';
                dataDiv += '<th>Name</th>';
                dataDiv += '<th>Department</th>';
                dataDiv += '<th>DOJ [DD/MM/YYYY]</th>';
                dataDiv += '<th>Mobile</th>';
                dataDiv += '<th>Email</th>';
                dataDiv += '<th>Mode</th>';
                
                dataDiv += '</tr>';
                var err_count = 0;
                //var update_tag =0;
                var tag_text = "";
                for (var i = 0; i < count; i++) {
                    var err_cls1 = "";
                    var err_cls2 = "";
                    var err_cls3="";
                    var err_cls4="";
                    var err_cls5="";

                    if (msg.employee_code[i].error >= 1) {
                        //err_cls1 = "err_xls_cell";
                                //err_count += 1;
                        //update_tag +=1;  
                        tag_text="Update";
                    } else { 
                        tag_text="New";
                        err_cls1 = ""; 
                    }
                    
                    if (msg.employee_department[i].error >= 1) {
                        err_cls2 = "err_xls_cell";
                        err_count += 1;
                    } else {
                        err_cls2 = "";
                    }
                    
                    if(msg.employee_doj[i].error >= 1){
                        err_cls3 = "err_xls_cell";
                        err_count += 1;
                    }else{
                        err_cls3="";
                    }
                    
                    if(msg.employee_mobile[i].error >= 1){
                        err_cls4 = "err_xls_cell";
                        err_count += 1;
                    }else{
                        err_cls4="";
                    }
                    
                    if(msg.employee_email[i].error >= 1){
                        err_cls5 = "err_xls_cell";
                        err_count += 1;
                    }else{
                        err_cls5="";
                    }
                    

                    dataDiv += '<tr>';
                    dataDiv += '<td class="' + err_cls1 + '" title="' + msg.employee_code[i].cell + '">' + msg.employee_code[i].value + '</td>';
                    dataDiv += '<td title="' + msg.employee_name[i].cell + '">' + msg.employee_name[i].value + '</td>';
                    dataDiv += '<td class="' + err_cls2 + '" title="' + msg.employee_department[i].cell + '">' + msg.employee_department[i].value + '</td>';
                    dataDiv += '<td class="'+ err_cls3 +'" title="' + msg.employee_doj[i].cell + '">' + msg.employee_doj[i].value + '</td>';
                    dataDiv += '<td class="'+ err_cls4 +'" title="' + msg.employee_mobile[i].cell + '">' + msg.employee_mobile[i].value + '</td>';
                    dataDiv += '<td class="'+ err_cls5 +'" title="' + msg.employee_email[i].cell + '">' + msg.employee_email[i].value + '</td>';
                    dataDiv += '<td>'+ tag_text +'</td>'
                    
                    dataDiv += '</tr>';
                }


                dataDiv += '</table>';
                dataDiv += '</div>';
                dataDiv += '<div class="modal-footer">';

                if (err_count > 0) {

                    dataDiv += '<p class="xls_cell_err_msg">Please check error with red coloured box';
                    dataDiv += '<button type="button" class="btn bg-maroon btn-flat margin " style="background:#f64537 !important;" data-dismiss="modal">Close</button>';
                } else {
                    dataDiv += '<button type="button" class="btn bg-maroon btn-flat margin " style="background:#f64537 !important;" data-dismiss="modal">Close</button>';
                    dataDiv += '<button type="button" class="btn bg-olive btn-flat margin pull-right" onclick="submitEmployee(' + "'" + basepath + "'" + ')">Save</button>';
                }

                dataDiv += '</div>';
                
                $("#modal_employee_content").html(dataDiv);
                $("#employee_proceess_modal").modal({
                    "backdrop": "static",
                    "keyboard": true,
                    "show": true
                });
                
                
                }
                
                
                
            }//success block
        });
}

