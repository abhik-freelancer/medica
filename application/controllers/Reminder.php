<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reminder extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Login_model", "login");
        $this->load->model("Employee_model","employee");
        $this->load->model("Department_model","department");
        $this->load->model("commondatamodel","commondatamodel");
        $this->load->model("Vaccine_model","vaccine");
        $this->load->model("Reminder_model","remindermodel");
        
    }
    public function index(){
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
             header("Access-Control-Allow-Origin: *");
              $data = [
                "department"=> $this->department->getDepartmentList($this->session->user_data['hospitalid']),
                "vaccines"=> $this->vaccine->getVaccineList($this->session->user_data['hospitalid'])
            ];
        $this->template->set('title', 'Reminder');
        $this->template->load('default_layout', 'contents', 'reminder/reminder_data', $data);
        }else{
            
            redirect('login');
        }
    }
    
    public function getVaccineSchedule()
    {
        //print_r($_POST);
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
            
            $fromDate = ($this->input->post("fromDate")!=""?date('Y-m-d', strtotime($this->input->post("fromDate"))):NULL);
            $toDate = ($this->input->post("toDate")!=""?date('Y-m-d', strtotime($this->input->post("toDate"))):NULL);;
            $vaccine = $this->input->post("vaccine");
            $department = $this->input->post("department");
            
            $data =[
                "vaccineschdl"=>$this->remindermodel->getScheduleVaccination($fromDate,$toDate,$vaccine,$department)
            ];
            $page = "reminder/partial_view_schedule";
            $this->load->view($page,$data);
            
        }else{
            redirect('login');
        }
        
    }
    
    public function updateschdl(){
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
            $employe_vaccine_id  = $this->input->post("employee_vaccince_schid");
            $employee_id = $this->input->post("employee_id");
            $department_id= $this->input->post("department_id");
            $actual_given_date = $this->input->post("givendate");
            
            $data =[
                "employee_id"=>$employee_id,
                "is_given"=>$actual_given_date,
                "department_id"=>$department_id,
                "employe_vaccine_id"=>$employe_vaccine_id,
                "actual_given_date"=>$actual_given_date
                    
            ];
            $this->remindermodel->updateschdl($data);
            
            
        }else{
          redirect('login');  
        }
        
    }
  
    
}
