<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Department extends CI_Controller{
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
                "departments"=> $this->department->getDepartmentList($this->session->user_data['hospitalid']),
            ];
        $this->template->set('title', 'Department');
        $this->template->load('default_layout', 'contents', 'department/list', $data);
        }else{
            
            redirect('login');
        }
    }
    public function addedit($departmentId=""){
       $this->load->helper('form');
       $this->load->library('form_validation');
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
            
            if($this->session->user_data['role']=='Admin'){
                
                $vaccineList = $this->commondatamodel->getAllDropdownData("vaccine");
                if($departmentId!=""){
                    $data=[
                        "mode"=>"edit",
                        "department_id"=>$departmentId,
                        "vaccinelist"=>$vaccineList,
                        "department"=> $this->department->getDepartmentById($departmentId),
                        "selected_vaccine"=>$this->department->getVaccineListByDepartment($departmentId)["associated_vacc"]
                    ];
                }else{
                    $data=[
                        "mode"=>"add",
                        "department_id"=>0,
                        "vaccinelist"=>$vaccineList
                    ];
                }
                
                
                $this->template->set('title', 'Department');
                $this->template->load('default_layout', 'contents', 'department/add_edit', $data);
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
                  $this->form_validation->set_rules('departmentname', 'Department', 'required');
                  $this->form_validation->set_error_delimiters('<div class="error-login">', '</div>');
                 // print_r($_POST);exit;
                  $p_departmentId = $this->input->post("hddepartmentId");
                  $m_mode = $this->input->post("mode");
                  $departmentname= $this->input->post("departmentname");
                  $vaccineList = $this->input->post("vaccinelst");
                  
                  if ($this->form_validation->run() == FALSE)
                    {
                        $data=[
                        "mode"=>$m_mode,
                        "department_id"=>$p_departmentId
                        ];
                        $this->template->set('title', 'Department');
                        $this->template->load('default_layout', 'contents', 'department/add_edit', $data);
                    } else {
                        
                        if($p_departmentId==0){
                            //insert
                        $isExistDepartmentName = $this->commondatamodel
                                ->duplicateValueCheck("department_master",$where=["department_master.department_name"=>$departmentname]);
                        
                       if(!$isExistDepartmentName){
                           $insert_data=[
                               "hospital_id"=>$this->session->user_data['hospitalid'],
                               "department_name"=>$departmentname,
                            ];
                            //var_dump($insert_data);
                          $departmentId=$this->commondatamodel->insertSingleTableData("department_master",$insert_data);
                          foreach($vaccineList as $val){
                            $department_vaccine=[
                                "department_id"=>$departmentId,
                                "vaccine_id"=>$val
                            ];
                            $this->commondatamodel->insertSingleTableData("department_vaccine",$department_vaccine);
                          }
                           if($departmentId!=0){
                               redirect("department");
                           }else{
                               $this->session->set_flashdata('department_insert_error',INSRT_ERROR);
                               $this->template->set('title', 'Department');
                               $this->template->load('default_layout', 'contents', 'department/add_edit', $data);
                           }
                           
                       }else{
                             $data=[
                                "mode"=>"add",
                                "department_id"=>0,
                                ];
                             
                         $this->session->set_flashdata('department_exist',DEPARTMENT_DUPLICATE_MSG);
                         $this->template->set('title', 'Department');
                         $this->template->load('default_layout', 'contents', 'department/add_edit', $data);
                       } 
                        
                       
                       }else{
                            //update
                           
//                           $data=[
//                        "mode"=>"edit",
//                        "department_id"=>$p_departmentId,
//                        "vaccinelist"=>$vaccineList,
//                        "department"=> $this->department->getDepartmentById($p_departmentId),
//                        "selected_vaccine"=>$this->department->getVaccineListByDepartment($p_departmentId)["associated_vacc"]
//                    ];
                           
                           $this->commondatamodel->deleteTableData("department_vaccine",array("department_id"=>$p_departmentId));
                           foreach($vaccineList as $val){
                            $department_vaccine=[
                                "department_id"=>$p_departmentId,
                                "vaccine_id"=>$val
                            ];
                            $this->commondatamodel->insertSingleTableData("department_vaccine",$department_vaccine);
                          }
                           //update department 
                           $departmentUpdateArr = [
                               "department_name"=>$departmentname,
                           ];
                           $update=$this->commondatamodel->updateSingleTableData("department_master",$departmentUpdateArr,array("department_id"=>$p_departmentId));
                           if($update){
                               redirect("department");
                           }else{
                               $this->session->set_flashdata('department_insert_error',UPDATE_ERROR);
                               redirect("department/add_edit/".$p_departmentId);
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
        try {
            $this->db->delete("department_vaccine",array("department_vaccine.department_id"=>$departmentId));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        }
    
}
