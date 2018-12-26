<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Changedepartment extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("ChangeDepartment_model", "change_depertment");
        $this->load->model("commondatamodel", "commondatamodel");
    }
    public function index(){
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
            header("Access-Control-Allow-Origin: *");
            $this->load->helper('form');
            $this->load->library('form_validation');
             $data['departmentlist'] = $this->change_depertment->getAllDepartment($this->session->user_data['hospitalid']);
           
        $this->template->set('title', 'Change Department');
        $this->template->load('default_layout', 'contents', 'department/changedepartment', $data);
       }else{
           
           redirect('login');
       }
       
        // $this->template->load('default_layout', 'contents', 'department/changedepartment', $data);
        // $this->template->load('default_layout', 'contents', 'department/changedepartment');
        
    }

    public function onSelect()
    {
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
            header("Access-Control-Allow-Origin: *");
            $department_id = $this->input->post("department_id");
            $data['empview']=$this->change_depertment->GetEmplyee($department_id);           
            $this->load->view('user/partial_empl', $data);
        }else{           
            redirect('login');
        }
    }
    public function employeeDetails()
    {
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
            header("Access-Control-Allow-Origin: *");
           
            $employee_id = $this->input->post("employee_id");
            $data['employee_details']=array(
                'employee'=>$this->change_depertment->getEmployeeDetails($employee_id),
                'department'=>$this->change_depertment->getAllDepartment($this->session->user_data['hospitalid'])
            );           
            $this->load->view('department/partial_change', $data);
        }else{           
            redirect('login');
        }  
    }
    public function getVaccineSchedule()
    {
       if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid']))
       {
           $dot = $this->input->post("dot");
           $departmentId = $this->input->post("deptId");
           $old_dept = $this->input->post("old_dept");
           $data="";
           if($dot!="" && $departmentId!=""){
               $data["schedule"]= $this->change_depertment->getEmployeeVaccineSchedule($departmentId,$dot,$this->session->user_data['hospitalid'],$old_dept);
            //    print_r($data);
            //    exit();
               $page = "department/partial_vaccine";
               $this->load->view($page,$data);
   
           }else{
               return FALSE;
           }
           
           
       }else{
           redirect('login'); 
       }
    }

    public function employeeDataToStore()
    {
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
            header("Access-Control-Allow-Origin: *");

            $this->load->helper('form');
                  $this->load->library('form_validation');


                  $this->form_validation->set_rules('chose_department', 'Current Department', 'required');
                  $this->form_validation->set_rules('employee', 'Employee', 'required');
                  $this->form_validation->set_rules('new_department', 'Transfer to Department', 'required');
                  $this->form_validation->set_rules('dot', 'DOT', 'required');
                  
                  
                  $this->form_validation->set_error_delimiters('<div class="error-login">', '</div>');

                  $departmentlist = $this->change_depertment->getAllDepartment($this->session->user_data['hospitalid']);
            $old_department = $this->input->post("chose_department");
            $emp_dept_id = $this->input->post("emp_dept_id");
            $hdvaccineId = $this->input->post("hdvaccineId");
            $scheduledate = $this->input->post("scheduledate");

            $employee = $this->input->post("employee");
            $new_department = $this->input->post("new_department");
            $doj = $this->input->post("doj");
            $dot = date('Y-m-d',strtotime($this->input->post("dot")));
            if ($this->form_validation->run() == FALSE)
            {
                $data=[
                    "departmentlist"=>$departmentlist
                ];
                $this->template->set('title', 'Change Department');
        $this->template->load('default_layout', 'contents', 'department/changedepartment',$data);
            }else{
            $data=[
                "employee_id"=>$employee,
                "dept_id"=>$new_department,
                "date_of_join"=>$dot,
                "from_module"=>"DC",
                "isActive"=>"Y"
            ]; 
            
            $table="employee_department";
            $insert=$this->commondatamodel->insertSingleTableData($table,$data);  

            $updatedata=[
                "isActive"=>"N",
                //"from_module"=>"DC"
            ];
            $where=[
                "emp_dept_id"=>$emp_dept_id,
                "dept_id"=>$old_department,
                "employee_id"=>$employee,                
                "isActive"=>'Y'

            ];        
         
            if($insert > 0){
                $this->commondatamodel->updateSingleTableData($table,$updatedata,$where);
                
                for ($i=0; $i < count($hdvaccineId) ; $i++) { 
                    $vaccine_details=[
                        "employee_dept_id"=>$insert,
                        "employee_id"=>$employee,
                        "department_id"=>$new_department,
                        "vaccination_id"=>$hdvaccineId[$i],
                        "schedule_date"=>date('Y-m-d',strtotime($scheduledate[$i])),
                        "is_given"=>'N',
                        "hospital_id"=>$this->session->user_data['userid']
        
                    ];
                    $this->commondatamodel->insertSingleTableData("employee_vaccination_detail",$vaccine_details);//inserting vaccine details
                }
                
                

                
                
               
                $messge = array('message' => 'Department Updated successfully','class' => 'alert alert-success fade in');
                $this->session->set_flashdata('item', $messge);
                redirect('changedepartment');
                }else{
                $messge = array('message' => 'Somthing is Wrong!','class' => 'alert alert-danger fade in');
                $this->session->set_flashdata('item',$messge );
            }
        }

        }else{           
            redirect('login');
        }
     
    }
    
}
