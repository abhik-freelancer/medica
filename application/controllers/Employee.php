<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Employee extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Login_model", "login");
        $this->load->model("Employee_model","employee");
        $this->load->model("Department_model","department");
        $this->load->model("commondatamodel","commondatamodel");
        
    }
    public function index(){
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
             header("Access-Control-Allow-Origin: *");
              $data = [
                "employees"=> $this->employee->getEmployeeList($this->session->user_data['hospitalid']),
            ];
        $this->template->set('title', 'Employee');
        $this->template->load('default_layout', 'contents', 'employee/list', $data);
        }else{
            
            redirect('login');
        }
    }
    public function addedit($employeeId=""){
       $this->load->helper('form');
       $this->load->library('form_validation');
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
            
            if($this->session->user_data['role']=='Admin'){
                
                $departmentList = $this->commondatamodel->getAllDropdownData("department_master");
                $employeeStatus =unserialize(EMPLOYEE_STATUS);
                if($employeeId!=""){
                    $data=[
                        "mode"=>"edit",
                        "employee_id"=>$employeeId,
                        "departmentList"=>$departmentList,
                        "employeeStatus"=>$employeeStatus,
                        "employee"=> $this->employee->getEmployeeDataByEmployeeId($employeeId),
                        "employeVaccineSchedule"=> $this->employee->getVaccineSchedule($employeeId)
                    ];
                }else{
                    $data=[
                        "mode"=>"add",
                        "employee_id"=>0,
                        "departmentList"=>$departmentList,
                        "employeeStatus"=>$employeeStatus,
                        "employeVaccineSchedule"=>""
                       
                    ];
                }
                
                
                $this->template->set('title', 'Employee');
                $this->template->load('default_layout', 'contents', 'employee/add_edit', $data);
            }else{
                redirect('login'); 
            }
            
            
        }else{
            redirect('login');
        }
    }
    
    public function action(){
         if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
              if($this->session->user_data['role']=='Admin'){
                  
                  $this->load->helper('form');
                  $this->load->library('form_validation');
                  $this->form_validation->set_rules('employee_name', 'Name', 'required');
                  $this->form_validation->set_rules('employee_code', 'Code', 'required');
                  $this->form_validation->set_rules('employeedepatrment', 'Department', 'required');
                  $this->form_validation->set_rules('employee_doj', 'DOJ', 'required');
                  
                  
                  $this->form_validation->set_error_delimiters('<div class="error-login">', '</div>');
                 // print_r($_POST);exit;
                  
                $departmentList = $this->commondatamodel->getAllDropdownData("department_master");
                $employeeStatus =unserialize(EMPLOYEE_STATUS);
                  
                $m_mode = $this->input->post("mode");
                $m_employeeId = $this->input->post("hddemployeeid");
                $m_employeeName = $this->input->post("employee_name");
                $m_employeeCode = $this->input->post("employee_code");
                $m_department = $this->input->post("employeedepatrment");
                $m_doj = $this->input->post("employee_doj");
                $m_certifc = $this->input->post("vaccination_cert_given_date");
                $m_empStatus = $this->input->post("employee_status");
                $m_empMobile = $this->input->post("employee_mobile");
                $m_empEmail = $this->input->post("employee_email");
                
                $m_dtlvaccineId = $this->input->post('hdvaccineId');
                $m_dtlscheduledate = $this->input->post('scheduledate');
                $m_dtlgivenDt = $this->input->post('givenDt');
                $m_dtlparent = $this->input->post('hdParentId');
                
//                echo('<pre>');
//                print_r($_POST);
//                echo('</pre>');exit;
                
                   if ($this->form_validation->run() == FALSE)
                    {
                       $data=[
                        "mode"=>$m_mode,
                        "employee_id"=>(int)$m_employeeId,
                        "departmentList"=>$departmentList,
                        "employeeStatus"=>$employeeStatus,
                       
                        ];
                        $this->template->set('title', 'Employee');
                        $this->template->load('default_layout', 'contents', 'employee/add_edit', $data);
                    } else {
                        
                        
                       
                        
                        if($m_employeeId==0){
                            //insert
                        $isExist = $this->commondatamodel
                                ->duplicateValueCheck("employee_master",$where=["employee_master.employee_code"=>$m_employeeCode]);
                        
                        
                       if(!$isExist){
                           $insert_data=[
                               "employee_code"=>$m_employeeCode,
                               "hospital_id"=>$this->session->user_data['hospitalid'],
                               "department_id"=>$m_department,
                               "employee_name"=>$m_employeeName,
                               "employee_doj"=>date('Y-m-d', strtotime($m_doj)),
                               "employee_status"=> $m_empStatus,
                               "vaccination_cert_given_date"=>($m_certifc==""? NULL:date('Y-m-d', strtotime($m_certifc))),
                               "employee_mobile"=> $m_empMobile,
                               "employee_email"=>$m_empEmail
                            ];
                            //var_dump($insert_data);
                          $employeeId=$this->commondatamodel->insertSingleTableData("employee_master",$insert_data);
                          if(count($m_dtlvaccineId)>0){
                              for($i=0;$i<count($m_dtlvaccineId);$i++)
                              {
                                  $employee_vaccination_detail=[
                                    "employee_id"  => $employeeId,
                                    "department_id"=>$m_department,
                                    "vaccination_id"=>$m_dtlvaccineId[$i],
                                    "schedule_date"=>($m_dtlscheduledate[$i]==""?NULL:date('Y-m-d', strtotime($m_dtlscheduledate[$i]))),
                                    "actual_given_date"=>($m_dtlgivenDt[$i]==""?NULL:date('Y-m-d', strtotime($m_dtlgivenDt[$i]))) ,
                                    "is_given" =>($m_dtlgivenDt[$i]==""?"N":"Y") ,
                                    "parent_vaccineId" =>($m_dtlparent[$i]==""?NULL:$m_dtlparent[$i]),
                                    "hospital_id"=>$this->session->user_data['hospitalid']
                                  ];
                                 $this->commondatamodel->insertSingleTableData("employee_vaccination_detail",$employee_vaccination_detail);   
                              }
                          }
                          
                          
                          
                           if($employeeId!=0){
                               redirect("employee");
                           }else{
                               $this->session->set_flashdata('employee_insert_error',INSRT_ERROR);
                               redirect('employee/add_edit');
                           }
                           
                       }else{
                             $data=[
                                     "mode"=>$m_mode,
                                    "employee_id"=>(int)$m_employeeId,
                                    "departmentList"=>$departmentList,
                                    "employeeStatus"=>$employeeStatus,
                                ];
                             
                         $this->session->set_flashdata('code_exist',EMPCODE_DUPLICATE_MSG);
                         $this->template->set('title', 'Employee');
                         $this->template->load('default_layout', 'contents', 'employee/add_edit', $data);
                       } 
                        
                       
                       }else{
                             $UpdateArr = [
                               "employee_code"=>$m_employeeCode,
                               "hospital_id"=>$this->session->user_data['hospitalid'],
                               "department_id"=>$m_department,
                               "employee_name"=>$m_employeeName,
                               "employee_doj"=>date('Y-m-d', strtotime($m_doj)),
                               "employee_status"=> $m_empStatus,
                               "vaccination_cert_given_date"=>($m_certifc==""? NULL:date('Y-m-d', strtotime($m_certifc))),
                               "employee_mobile"=> $m_empMobile,
                               "employee_email"=>$m_empEmail
                           ];
                           $update=$this->commondatamodel->updateSingleTableData("employee_master",$UpdateArr,array("employee_id"=>$m_employeeId));
                           //vaccination schedule update
                           
                           
                           
                           
                           if($update){
                               redirect("employee");
                           }else{
                               $this->session->set_flashdata('employee_insert_error',UPDATE_ERROR);
                               redirect("employee/add_edit/".$m_employeeId);
                           }
                        }
                    }
                  
                  
              }else{
                  redirect('login'); 
              }
         }
         else{
            redirect('login');
        }
    }
    
public function delete($departmentId){
        try 
        {
            $this->db->delete("department_vaccine",array("department_vaccine.department_id"=>$departmentId));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
 }
 
 public function getVaccineSchedule()
 {
    if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid']))
    {
        $doj = $this->input->post("doj");
        $departmentId = $this->input->post("deptId");
        $data="";
        if($doj!="" && $departmentId!=""){
            $data["schedule"]= $this->employee->getEmployeeVaccineSchedule($departmentId,$doj,$this->session->user_data['hospitalid']);
            $page = "employee/schedule_partial_view";
            $this->load->view($page,$data);

        }else{
            return FALSE;
        }
        
        
    }else{
        redirect('login'); 
    }
 }

 public function getChildVaccine(){

    $vaccineId = $this->input->post("vaccineId");
    $givenDate = $this->input->post("givendate");
    $json_response=[];
    if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid']))
    {
     if($vaccineId!="" && $givenDate!=""){
         
         $where = [
                    "vaccine.parent_vaccine"=>$vaccineId
         ];
         $childVaccineData = $this->commondatamodel->getSingleRowByWhereCls("vaccine",$where);
         ///print_r($childVaccineData);
         if(!empty($childVaccineData)){
         $childVaccineId = $childVaccineData->id;
         $childVaccine = $childVaccineData->vaccine;
         $freequency = $childVaccineData->frequency;
         $m_givenDate = date('Y-m-d', strtotime($givenDate));
         $childScheduleDate = date('d-m-Y',strtotime (($freequency)." day" , strtotime($m_givenDate)));
        
         $json_response =[
             "childVaccineId"=>$childVaccineId,
             "childVaccine"=>$childVaccine,
             "freequency"=>$freequency,
             "childScheduleDate"=>$childScheduleDate,
             "parentId"=>$vaccineId,
             "givenDate"=>$givenDate
         ];
         }else{
            $json_response =[
             "childVaccineId"=>"",
             "childVaccine"=>"",
             "freequency"=>"",
             "childScheduleDate"=>"",
             "parentId"=>"",
             "givenDate"=>""
            ]; 
         }
        header('Content-Type: application/json');
        echo json_encode( $json_response );
        exit(); 
     }else{
         return false;
     }
    } else {
        redirect('login'); 
    }
     
}
 
    
}
