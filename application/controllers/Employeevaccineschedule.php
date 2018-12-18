<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Employeevaccineschedule extends CI_Controller{
   public function __construct() {
       parent::__construct();
        $this->load->library('session');
        $this->load->model("Login_model", "login");
        $this->load->model("Employee_model","employee");
        $this->load->model("Department_model","department");
        $this->load->model("commondatamodel","commondatamodel");
        $this->load->model("Vaccine_model","vaccine");
   }
   public function index()
   {
       if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
           
           $data=[
               "employeeList"=> $this->commondatamodel->getAllDropdownData("employee_master")
           ];
           
        $this->template->set('title', 'Vaccine-Schedule');
        $this->template->load('default_layout', 'contents', 'vaccineschedule/list', $data);
           
       }else{
           redirect('login');
       }
   }
}
