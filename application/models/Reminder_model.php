<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reminder_model extends CI_Model{
    public function getScheduleVaccination($fromDate,$toDate,$vaccine_id,$department="")
    {
       $deptClause = "";
       $vaccineSchedule =[];
       
       if($department!=""){
           $deptClause = " AND employee_vaccination_detail.department_id = ".$department;
       }
        
        $sql = "SELECT 
                employee_vaccination_detail.employe_vaccine_id,
                employee_master.employee_code,
                employee_master.employee_name,
                employee_master.employee_mobile,
                DATE_FORMAT(employee_master.employee_doj,'%d-%m-%Y') as employee_doj,
                employee_vaccination_detail.employee_id,
                DATE_FORMAT(employee_vaccination_detail.schedule_date,'%d-%m-%Y')AS schedule_date,
                DATE_FORMAT(employee_vaccination_detail.actual_given_date,'%d-%m-%Y') AS actual_given_date,
                department_master.department_name,
                employee_vaccination_detail.employee_id,employee_vaccination_detail.department_id,
                employee_vaccination_detail.is_given
                
                FROM 
                employee_master
                INNER JOIN 
                employee_vaccination_detail ON employee_master.employee_id = employee_vaccination_detail.employee_id
                INNER JOIN
                department_master ON employee_vaccination_detail.department_id = department_master.department_id
                WHERE 
                employee_vaccination_detail.schedule_date BETWEEN '".$fromDate."' AND '".$toDate."'
                AND employee_vaccination_detail.vaccination_id =".$vaccine_id." "
               . " ".$deptClause;
       $query = $this->db->query($sql);
       if($query->num_rows()>0){
           foreach($query->result() as $rows){
               $vaccineSchedule[]=$rows;
           }
           
       }
       return $vaccineSchedule;
                
    }
    
    public function updateschdl($data){
        
        $employee_vaccine_id = $data["employe_vaccine_id"];
        $update_arr = [
            "actual_given_date" =>$data["actual_given_date"]
        ];
        $this->db->where("employe_vaccine_id",$employee_vaccine_id);
        $this->db->update("");
    }
}
