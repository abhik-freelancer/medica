<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Department_model extends CI_Model{
    public function getDepartmentList($hospitalId)
    {
        $department="";
        $query = $this->db->select("department_master.*,hospital_master.hospital_name")
                ->from("department_master")
                ->join("hospital_master","department_master.hospital_id=hospital_master.hospital_id")
                ->where("department_master.hospital_id",$hospitalId)
                ->order_by("department_master.department_name")->get();
        if($query->num_rows()>0){
            foreach($query->result() as $rows)
				{
					$department[]=[                                          
                                            "department_id"=>$rows->department_id,
                                            "department_name" =>$rows->department_name,
                                            "hospital_name"=>$rows->hospital_name,
                                            "vaccinelist"=> $this->getVaccineListByDepartment($rows->department_id)["vaccines"]
                                        ] ;
				}
            
            
            
           // $department = $query->row();
        }
        return $department;
    }
    
    public function getVaccineListByDepartment($departmentId){
        
        $vaccineList = ["vaccines"=>"","associated_vacc"=>""];
        $sql = "SELECT GROUP_CONCAT(vaccine.vaccine)AS vaccines,GROUP_CONCAT(vaccine.id)AS associated_vacc
                FROM department_vaccine
                INNER JOIN department_master ON
                department_vaccine.department_id = department_master.department_id
                INNER JOIN vaccine ON department_vaccine.vaccine_id = vaccine.id
                WHERE department_vaccine.department_id = ".$departmentId.
                 " GROUP BY department_vaccine.department_id";
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            $row = $query->row();
            $vaccineList =[
                "vaccines"=>$row->vaccines,
                "associated_vacc" =>$row->associated_vacc
            ]; 
        }
        return $vaccineList;
    }
    
    public function getDepartmentById($departmentId)
    {
        $department="";
        
        $query = $this->db->select("department_master.*")->from("department_master")
                ->where("department_master.department_id",$departmentId)->get();
        if($query->num_rows()>0){
            $department = $query->row();
            
        }
    
    return $department;    
    }
    
    public function delete_department($department_id)
    {
        
    }
    
    public function getValidDepartmentByName($departmentName){
        $isValid="";
       
        $query = $this->db->select("department_master.*")->from("department_master")
                ->where("department_master.department_name",$departmentName)->get();
        if($query->num_rows()>0){
           
            $isValid =TRUE;
        }else{
            $isValid = FALSE;
        }
        return $isValid;
    }
    
    public function getDepartmentIdByName($departmentName){
        
         $departmentId="";   
         $query = $this->db->select("department_master.*")->from("department_master")
                ->where("department_master.department_name",$departmentName)->get();
         if($query->num_rows()>0){
                $row = $query->row();
                $departmentId = $row->department_id;
        }
        return $departmentId;
    }
}
