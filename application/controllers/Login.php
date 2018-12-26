<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Login_model", "login");
        $this->load->model("Employee_model","employee");
        
    }
    public function index(){
       $this->load->helper('form');
       $this->load->library('form_validation');
       $hospital_details['hospital_details']= $this->login->getAllHospital();
       $page="login/login";
       $this->load->view($page,$hospital_details);
    }
    
    public function check_login() 
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('hospital_id', 'Hospital', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('userpassword', 'Password', 'required');
        $this->form_validation->set_error_delimiters('<div class="error-login">', '</div>');
        
        if ($this->form_validation->run() == FALSE)
           {
                   //redirect('login');
                    $hospital_details['hospital_details']= $this->login->getAllHospital();
                    $page="login/login";
                    $this->load->view($page,$hospital_details);    
           }
           else
           {
                $username = $this->input->post('username');
                $hospital = $this->input->post('hospital_id');
                $password = $this->input->post('userpassword');
                $user_id = $this->login->checkLogin($username,$password,$hospital);
                if($user_id!=""){
                    $user = $this->login->get_user($user_id);
                    $employee = $this->employee->getEmployeeDataByEmployeeId($user->employee_id);
                    $user_session = [
                    "userid"=>$user->user_id,
                    "username"=>$user->username,
                    "employeeId"=>$employee->employee_id,
                    "employeename"=>$employee->employee_name,
                    "hospitalid"=>$employee->hospital_id,
                    "departmentid"=>$employee->department_id,
                        "role"=>$user->user_type
                    
                ];
                 $this->setSessionData($user_session);
                 redirect('dashboard');
                    
                }else{
                     $this->session->set_flashdata('msg','<div class="error-login">Invalid username or password</div>');
                     redirect('login');
                }
                       //echo('success');
           }
    }
    
    private function setSessionData($result = NULL) {

        if ($result) {
            $this->session->set_userdata("user_data", $result);
        }
    }
}
