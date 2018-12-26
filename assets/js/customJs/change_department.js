$(document).ready(function(){
	var basePath= $("#basepath").val();
	
      $('#chose_department').on('change', function(e){
		e.preventDefault(); 
		var department_id=$('#chose_department').val();
		  $.ajax({
			  url: basePath +"changedepartment/onSelect",
			  type: "post",
			  contentType:"application/x-www-form-urlencoded; charset=UTF-8",
			  data: {department_id:department_id},
			  success: function(d) {
				  //alert(d);
				 $("#user_empl").html(d)
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
	
	$(document).on('change',"#employee",function(ev){
		ev.preventDefault();
		
		var employee_id=$('#employee').val();
		$.ajax({
			url: basePath +"changedepartment/employeeDetails",
			type: "post",
			contentType:"application/x-www-form-urlencoded; charset=UTF-8",
			dataType:'html',
			data: {
				employee_id:employee_id
			},
			success: function(d) {			
			$("#replace").html(d)
			$('.selectpicker').selectpicker({dropupAuto: false});
			
			
			}
		});

	});

	$('#dot').on('change', function(e){
		e.preventDefault(); 
		var department_id=$('#new_department').val();
		var dot=$('#dot').val();
	
		getVaccineScheduleDetails(dot,department_id,basePath);
	});

});


function getVaccineScheduleDetails(dot,departmentId,path)
{
    //alert(dot+" "+departmentId+" "+basepath);
    if(dot!="" && departmentId!=""){
        $.ajax({
         url: path+'changedepartment/getVaccineSchedule',
         data: {
             dot: dot,deptId:departmentId
         },
         type: "post",
         dataType: "html",
		 success: function (data) 
		 {
			//$("#vaccineshedule").html("");
             $("#vaccineshedule").html(data);
           
            //   $('.datepicker').datepicker({
            //          format: 'dd-mm-yyyy',
            //          todayHighlight: true,
            //          uiLibrary: 'bootstrap',
            //          autoclose: true
            //         });
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
