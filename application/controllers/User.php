<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller{

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
                "users"=> $this->login->getUserList($this->session->user_data['hospitalid']),
            ];
        $this->template->set('title', 'User');
        $this->template->load('default_layout', 'contents', 'user/list', $data);
        }else{
            
            redirect('login');
        }
    }
    public function addedit($userId=""){
       $this->load->helper('form');
       $this->load->library('form_validation');
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
            
            if($this->session->user_data['role']=='Admin'){
                
                $departmentList = $this->commondatamodel->getAllDropdownData("department_master");
                $UserType =unserialize(USER_TYPE);
                
                if($userId!=""){
                    $where =["users.user_id"=>$userId];
                    $userdata = $this->commondatamodel->getSingleRowByWhereCls("users",$where);
                    //echo($userdata->department_id);
                    $data=[
                        "mode"=>"edit",
                        "user_id"=>$userId,
                        "user"=>$userdata,
                        "departmentList"=>$departmentList,
                        "employeeList"=> $this->getEmployeeByDepartment($userdata->department_id,0),
                        "usertype"=>$UserType
                        
                        
                    ];
                }else{
                    $data=[
                        "mode"=>"add",
                        "user_id"=>0,
                         "user"=>"",
                        "departmentList"=>$departmentList,
                        "employeeList"=>"",
                        "usertype"=>$UserType
                       
                    ];
                }
                
                
                $this->template->set('title', 'User');
                $this->template->load('default_layout', 'contents', 'user/add_edit', $data);
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
                  $this->form_validation->set_rules('user_login_name', 'Login', 'required');
                  $this->form_validation->set_rules('user_password', 'Password', 'required');
                  $this->form_validation->set_rules('departmentname', 'Department', 'required');
                  $this->form_validation->set_rules('employee', 'Employee', 'required');
                  $this->form_validation->set_rules('user_type', 'Type', 'required');
                  //user_type
                 
                  $this->form_validation->set_error_delimiters('<div class="error-login">', '</div>');
                 
                  
                  $departmentList = $this->commondatamodel->getAllDropdownData("department_master");
                  $UserType =unserialize(USER_TYPE);
                  
                $m_mode = $this->input->post("mode");
                $m_userId = $this->input->post("hduserid");
                $m_username = $this->input->post("user_login_name");
                $m_password = $this->input->post("user_password");
                $m_department = $this->input->post("departmentname");
                $m_employee = $this->input->post("employee");
                $m_userType = $this->input->post("user_type");
               
                   if ($this->form_validation->run() == FALSE)
                    {
                      $data=[
                        "mode"=>$m_mode,
                        "user_id"=>$m_userId,
                        "user"=>"",
                        "departmentList"=>$departmentList,
                        "employeeList"=>"",
                        "usertype"=>$UserType
                       
                    ];
                        $this->template->set('title', 'User');
                        $this->template->load('default_layout', 'contents', 'user/add_edit', $data);
                    } else {
                        
                        
                       
                        
                        if($m_userId==0){
                            //insert
                        $isExist = $this->commondatamodel
                                ->duplicateValueCheck("users",$where=["users.username"=>$m_username]);
                        
                       if(!$isExist){
                           $insert_data=[
                               "username"=>$m_username,
                               "password"=>$m_password,
                               "department_id"=>$m_department,
                               "employee_id"=>$m_employee,
                                "user_type"=>$m_userType,
                               "hospital_id"=>$this->session->user_data['hospitalid']
                            ];
                            //var_dump($insert_data);
                          $userId=$this->commondatamodel->insertSingleTableData("users",$insert_data);
                          
                           if($userId!=0){
                               redirect("user");
                           }else{
                               $this->session->set_flashdata('user_insert_error',INSRT_ERROR);
                               redirect('user/add_edit');
                           }
                           
                       }else{
                             $data=[
                                    "mode"=>$m_mode,
                                    "user_id"=>$m_userId,
                                    "user"=>"",
                                    "departmentList"=>$departmentList,
                                    "employeeList"=>"",
                       
                                    ];
                             
                         $this->session->set_flashdata('login_exist',LOGIN_DUPLICATE_MSG);
                         $this->template->set('title', 'User');
                         $this->template->load('default_layout', 'contents', 'user/add_edit', $data);
                       } 
                        
                       
                       }else{
                             $UpdateArr=[
                               "password"=>$m_password,
                               "department_id"=>$m_department,
                               "employee_id"=>$m_employee,
                               "user_type"=>$m_userType,
                               "hospital_id"=>$this->session->user_data['hospitalid']
                            ];
                           $update=$this->commondatamodel->updateSingleTableData("users",$UpdateArr,array("user_id"=>$m_userId));
                           if($update){
                               redirect("user");
                           }else{
                               $this->session->set_flashdata('user_insert_error',UPDATE_ERROR);
                               redirect("user/add_edit/".$m_employeeId);
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
    
    public function changeStatus(){
         if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
            
            if($this->session->user_data['role']=='Admin'){
                $userId = $this->uri->segment(3);
                $userStatus = $this->uri->segment(4);
                $update_status_flag = ($userStatus=="Y"?"N":"Y");
                $this->login->updateStatus($userId,$update_status_flag);
                redirect('user');
                
            }else{
                redirect('login');
            }
         }else{
             redirect('login');
         }
    }
    
    public function getEmployeeByDepartment($departmentId,$isAjax=0){
        if($departmentId!=""){
            $table = "employee_master";
            $where =[
                        "employee_master.department_id"=>$departmentId
                    ];
            if($isAjax==1){        
            $data=[
                    "empview"=> $this->commondatamodel->getAllRecordWhere($table,$where)
                ];
             $this->load->view('user/partial_empl', $data);
            }else{
                $employee = $this->commondatamodel->getAllRecordWhere($table,$where);
                return $employee;   
            }
          
        }
    }
    
    
    
    public function delete($departmentId){
        try {
            $this->db->delete("department_vaccine",array("department_vaccine.department_id"=>$departmentId));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        }
        
        
        
    
    
    
    
}
