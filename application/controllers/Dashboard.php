<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Login_model", "login");
        $this->load->model("Employee_model","employee");
        $this->load->model("commondatamodel", "commondatamodel");
        $this->load->model("Vaccine_model", "vaccinemodel");
        
    }

    public function index(){
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid']))
        {
        header("Access-Control-Allow-Origin: *");
        $currentmonth=date('Y-m');
            $totalEmployeeWhere=[
                "hospital_id"=>$this->session->user_data['hospitalid'],
                "employee_status"=>"Active"
            ];
            $pendingVaccination=[
                "hospital_id"=>$this->session->user_data['hospitalid'],
                "is_given"=>'N'
            ];
            $data['dashboadData']= [
                    "personalinfo"=>["name"=>"abhik","Age"=>37],
                    "official"=>["add"=>'asasada'],
                    "totalEmployee"=>$this->commondatamodel->getRowCountWithWhereCaulse('employee_master',$totalEmployeeWhere),
                    "pendingVaccination"=>$this->vaccinemodel->getTotalPendingVaccineByScheduleMonth('employee_vaccination_detail',$pendingVaccination,$currentmonth)
                    
                ];
            $this->template->set('title', 'Medica-Staff Vaccination');
            $this->template->load('default_layout', 'contents', 'dashboard/dashboard', $data);
        }else{
            redirect('login'); 
        }
    }

    public function groupByList()
    {
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid']))
        {
            header("Access-Control-Allow-Origin: *");
            $view=$this->input->post("viewname");
            if($view=="employeeindepartmentList")
            {
                $data['groupbylist']=[
                    "list"=>$this->employee->getEmployeeCountGroupByDept($this->session->user_data['hospitalid']),
                    "listname"=>"Total Employees"
                ];
            }elseif ($view=="pendingvaccinationthisMonth") {
                $data['groupbylist']=[
                    "list"=>$this->vaccinemodel->pendingVaccineListGroupByVaccineName($this->session->user_data['hospitalid']),
                    "listname"=>"This month's pending vaccination"
                ];
            }
            $this->load->view('dashboard/list_partial_view', $data);    
                  
        }else{
            //redirect('login'); 
        }
    }

  
}
