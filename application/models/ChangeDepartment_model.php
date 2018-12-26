<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ChangeDepartment_model extends CI_Model{


    public function GetEmplyee($department_id)
    {
        $employee=array();
        //$where="employee_status='Active' AND hospital_id=".$hospital_id." AND department_id=".$department_id;   
        $where=[
            "employee_master.employee_status"=>'Active',
            // "hospital_id"=>$hospital_id,
            "employee_department.isActive"=>'Y',
            "employee_department.dept_id"=>$department_id
        ];
        $query = $this->db->select("employee_department.date_of_join,employee_department.employee_id,employee_master.employee_code,employee_master.employee_name")
                ->from("employee_department")
                ->join('employee_master', 'employee_department.employee_id=employee_master.employee_id')
                ->where($where)
                ->get();
       
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                $employee[]=$row;
            }
        }
        return $employee;
    }

    public function getAllDepartment($hospital_id)
    {
        $department=array();
        $where="hospital_id=".$hospital_id;   
        $query = $this->db->select("*")
                ->from("department_master")
                ->where($where)
                ->get();
       
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                $department[]=$row;
            }
        }
        return $department;
    }
    public function getEmployeeDetails($employee_id)
    {
        $employee_details=array();
        $where=[
            "employee_master.employee_status"=>'Active',
            "employee_department.isActive"=>'Y', 
            "employee_department.employee_id"=>$employee_id
        ];   
        $query = $this->db->select("employee_department.*,employee_master.*")
                ->from("employee_department")
                ->join("employee_master","employee_department.employee_id=employee_master.employee_id")
                ->where($where)
                ->get();
       
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                $employee_details[]=$row;
            }
        }
        return $employee_details;
    }

    public function getEmployeeVaccineSchedule($departmentId,$date_of_transfer,$hospitalId,$old_dept)
    {
        $old_vaccineID=$this->getVaccineByDepartment($old_dept);


        // print_r($old_vaccineID);
        // exit();
     $employeeVaccine="";
        $whereClause = [
            "department_vaccine.department_id "=>$departmentId,
            "vaccine.hospital_id"=>$hospitalId,
            "vaccine.parent_vaccine"=>NULL
        ];
        
        $query = $this->db->select("vaccine.*,department_vaccine.*")
                    ->from("department_vaccine")->join("vaccine","department_vaccine.vaccine_id=vaccine.id")
                    ->where($whereClause)
                    ->where_not_in("department_vaccine.`vaccine_id`",$old_vaccineID)
                    ->get();

                    // echo $this->db->last_query();
                    // exit();
        $dateOfTransfer = date("Y-m-d", strtotime($date_of_transfer));
        if($query->num_rows()>0){
            foreach($query->result() as $rows)
		{
                    
                    $employeeVaccine[]=[
                        "vaccineId"=>$rows->id,
                        "vaccine"=> $rows->vaccine,
                        "parent_vaccine"=>$rows->parent_vaccine,
                        "frequency"=>$rows->frequency,
                        "is_depend_doj"=>$rows->is_depend_doj,
                        "hospital_id"=>$rows->hospital_id,
                        "frequency"=>($rows->frequency==""?0:$rows->frequency),
                        "scheduleDate"=>$this->getSchedule($dateOfTransfer,$rows->id),
                        "givenDate"=>""
                    ];
		}
            
            
            
           // $department = $query->row();
        }
        return $employeeVaccine;
        
    }
    public function getSchedule($dot,$vaccineId)
    {
        $schedule ="";
        $query = $this->db->select("vaccine.*")
                ->from("vaccine")->where("vaccine.id",$vaccineId)->get();
        
        $result =  $query->row();
        $parentId = $result->parent_vaccine;
        $frequency = $result->frequency;
        
        ///echo $this->db->last_query();
        if($parentId!=""){
            $query2= $this->db->select("vaccine.*")
                ->from("vaccine")->where("vaccine.id",$parentId)->get();
            $frequency_parent = $query2->row()->frequency;
            $parent_schedule = date('Y-m-d',strtotime (($frequency_parent)." day" , strtotime($dot)));
            $schedule = date('d-m-Y',strtotime (($frequency)." day" , strtotime($parent_schedule)));
        }else{
            $schedule = date('d-m-Y',strtotime ( ($frequency)." day" , strtotime ( $dot ) ));
        }
        
       return $schedule; 
    }


 public function getVaccineByDepartment($department_id)
 {
    
    $query=$this->db->select("vaccine_id")
                    ->from("department_vaccine")
                    ->where("department_id=".$department_id)
                    ->get();
    if($query->num_rows()>0)
    {
        $vaccine=[];
        foreach ($query->result() as $row) {           
           $vaccine []=$row->vaccine_id;
        }     
    }
    return $vaccine;
 }
    
}