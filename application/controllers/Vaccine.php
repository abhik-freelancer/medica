<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vaccine extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Login_model", "login");
        $this->load->model("Employee_model","employee");
        $this->load->model("Department_model","department");
        $this->load->model("commondatamodel","commondatamodel");
        $this->load->model("Vaccine_model","vaccine");

        //Vaccine_model
        
    }
    public function index(){
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
             header("Access-Control-Allow-Origin: *");
              $data = [
                "vaccines"=> $this->vaccine->getVaccineList($this->session->user_data['hospitalid']),
            ];
        $this->template->set('title', 'Vaccine');
        $this->template->load('default_layout', 'contents', 'vaccine/list', $data);
        }else{
            
            redirect('login');
        }
    }
    public function addedit($vaccineId=""){
       $this->load->helper('form');
       $this->load->library('form_validation');
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
            
            if($this->session->user_data['role']=='Admin'){
                
                $vaccineList = $this->commondatamodel->getAllDropdownData("vaccine");
                $vaccine_Doj = ["Y"=>"Y","N"=>"N"];
                
                if($vaccineId!=""){
                    $data=[
                        "mode"=>"edit",
                        "vaccineId"=>$vaccineId,
                        "parentVaccineList"=>$vaccineList,
                        "vaccine"=>$this->commondatamodel->getSingleRowByWhereCls("vaccine",$whrere=["vaccine.id"=>$vaccineId]),// $this->employee->getEmployeeDataByEmployeeId($employeeId)
                        "vacc_doj"=>$vaccine_Doj
                    ];
                    
                }else{
                    $data=[
                        "mode"=>"add",
                        "vaccineId"=>0,
                        "parentVaccineList"=>$vaccineList,
                        "vaccine"=> "",
                        "vacc_doj"=>$vaccine_Doj
                    ];
                }
                
                
                $this->template->set('title', 'Vaccine');
                $this->template->load('default_layout', 'contents', 'vaccine/add_edit', $data);
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
                  $this->form_validation->set_rules('vaccine', 'Vaccine', 'required');
                  $this->form_validation->set_error_delimiters('<div class="error-login">', '</div>');
                 // print_r($_POST);exit;
                  
                $vaccineList = $this->commondatamodel->getAllDropdownData("vaccine");
                $vaccine_Doj = ["Y"=>"Y","N"=>"N"];
                  
                $m_mode = $this->input->post("mode");
                $m_vaccineId = $this->input->post("hdvaccineId");
                $m_vaccine = $this->input->post("vaccine");
                $m_parentVaccine = ($this->input->post("parent_vaccine")==""?NULL:$this->input->post("parent_vaccine"));
                $m_frequenct = $this->input->post("frequency");
                $m_isdependent_doj = $this->input->post("is_depend_doj");
                
                
                
                   if ($this->form_validation->run() == FALSE)
                    {
                       $data=[
                            "mode"=>"add",
                            "vaccineId"=>$m_vaccineId,
                            "parentVaccineList"=>$vaccineList,
                            "vaccine"=>"",
                            "vacc_doj"=>$vaccine_Doj
                        ];
                        $this->template->set('title', 'Vaccine');
                        $this->template->load('default_layout', 'contents', 'vaccine/add_edit', $data);
                    } else {
                        
                        if($m_vaccineId==0){
                            //insert
                        $isExist = $this->commondatamodel
                                ->duplicateValueCheck("vaccine",$where=["vaccine.vaccine"=>$m_vaccine]);
                        
                        
                       if(!$isExist){
                           $insert_data=[
                               "vaccine"=>$m_vaccine,
                               "parent_vaccine"=>$m_parentVaccine,
                               "frequency"=>$m_frequenct,
                               "is_depend_doj"=>$m_isdependent_doj,
                               "hospital_id"=>$this->session->user_data['hospitalid']
                            ];
                            //var_dump($insert_data);
                          $vaccineInsertId=$this->commondatamodel->insertSingleTableData("vaccine",$insert_data);
                          
                           if($vaccineInsertId!=0){
                               redirect("vaccine");
                           }else{
                               $this->session->set_flashdata('vaccine_insert_error',INSRT_ERROR);
                               redirect('vaccine/add_edit');
                           }
                           
                       }else{
                             $data=[
                                    "mode"=>$m_vaccineId,
                                    "vaccineId"=>$m_vaccineId,
                                    "parentVaccineList"=>$vaccineList,
                                    "vaccine"=>"",
                                    "vacc_doj"=>$vaccine_Doj
                                     
                                    ];
                             
                         $this->session->set_flashdata('code_exist',VACCINE_DUPLICATE_MSG);
                         $this->template->set('title', 'Vaccine');
                         $this->template->load('default_layout', 'contents', 'vaccine/add_edit', $data);
                       } 
                        
                       
                       }
                       
                       else
                           {
                           
                             $UpdateArr = [
                               "vaccine"=>$m_vaccine,
                               "parent_vaccine"=>$m_parentVaccine,
                               "frequency"=>$m_frequenct,
                               "is_depend_doj"=>$m_isdependent_doj
                           ];
                           $update=$this->commondatamodel->updateSingleTableData("vaccine",$UpdateArr,array("id"=>$m_vaccineId));
                           if($update){
                               redirect("vaccine");
                           }else{
                               $this->session->set_flashdata('vaccine_insert_error',UPDATE_ERROR);
                               redirect("vaccine/add_edit/".$m_vaccineId);
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
