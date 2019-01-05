<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reminder_model extends CI_Model{
    public function getScheduleVaccination($fromDate,$toDate,$vaccine_id,$department="",$hospital_id)
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
                employee_vaccination_detail.vaccination_id,
                employee_vaccination_detail.is_given,
                employee_vaccination_detail.employee_dept_id
                
                FROM 
                employee_master
                INNER JOIN 
                employee_vaccination_detail ON employee_master.employee_id = employee_vaccination_detail.employee_id
                INNER JOIN
                department_master ON employee_vaccination_detail.department_id = department_master.department_id
                
                WHERE 
                employee_vaccination_detail.schedule_date BETWEEN '".$fromDate."' AND '".$toDate."'
                AND employee_vaccination_detail.hospital_id=".$hospital_id."
                
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
        $isGiven='N';
        if($data["actual_given_date"]!=""){$isGiven='Y';}
         try {
            $this->db->trans_begin();
             $update_arr = [
            "actual_given_date" =>$data["actual_given_date"],
            "is_given"=>$isGiven
        ];
        $this->db->where("employe_vaccine_id",$employee_vaccine_id);
        $this->db->update("employee_vaccination_detail",$update_arr);
            
         $childVaccine = $this->getChildFrequencyAndId($data['vaccination_id']);
         $EmployeeDeptId=$this->getEmployeeDeptId($data['employee_id']);
        if($childVaccine!=""){
            //get next schedule date
            $childScheduleDate = $this->getScheduleDate($childVaccine->frequency, $data["actual_given_date"]);
            $insertArray=[
                'employee_id'=>$data['employee_id'],
                'department_id'=>$data['department_id'],
                'employee_dept_id'=>$EmployeeDeptId->emp_dept_id,
                'vaccination_id'=>$childVaccine->id,
                'schedule_date'=>$childScheduleDate,
                'actual_given_date'=>NULL,
                'is_given'=>'N',
                'parent_vaccineId'=>$data['vaccination_id'],
                'hospital_id'=>$data['hospitalId']
                
            ];
            // echo "<pre>";
            // print_r($insertArray);
            // echo "</pre>";
            // exit();
            $this->db->insert("employee_vaccination_detail",$insertArray);
            
            //create next vaccine schedule...
            
        }    
            
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
         } catch (Exception $ex){
             return false;
         }
        
    }
    
//    public function updateschdl($data){
//        
//        $employee_vaccine_id = $data["employe_vaccine_id"];
//        $isGiven='N';
//        if($data["actual_given_date"]!=""){$isGiven='Y';}
//        
//        $update_arr = [
//            "actual_given_date" =>$data["actual_given_date"],
//            "is_given"=>$isGiven
//        ];
//        $this->db->where("employe_vaccine_id",$employee_vaccine_id);
//        $this->db->update("employee_vaccination_detail",$update_arr);
//        
//        $childVaccine = $this->getChildFrequencyAndId($data['vaccination_id']);
//        if($childVaccine!=""){
//            //get next schedule date
//            $childScheduleDate = $this->getScheduleDate($childVaccine->frequency, $data["actual_given_date"]);
//            $insertArray=[
//                'employee_id'=>$data['employee_id'],
//                'department_id'=>$data['department_id'],
//                'vaccination_id'=>$childVaccine->id,
//                'schedule_date'=>$childScheduleDate,
//                'actual_given_date'=>NULL,
//                'is_given'=>'N',
//                'parent_vaccineId'=>$data['vaccination_id'],
//                'hospital_id'=>$data['hospitalId']
//                
//            ];
//            $this->db->insert("employee_vaccination_detail",$insertArray);
//            
//            //create next vaccine schedule...
//            
//        }
//        
//    }
    
    public function getChildFrequencyAndId($vaccineId){
        $childVaccine ="";
        $query = $this->db->select("vaccine.*")
                ->from("vaccine")
                ->where("vaccine.parent_vaccine",$vaccineId)->get();
                if($query->num_rows()>0){
                    $childVaccine = $query->row();
                }
        return $childVaccine;        
    }
    
    public function getScheduleDate($frequency,$givenDate){
        //Y-m-d;
//        $Date = "2010-09-17";
//echo date('Y-m-d', strtotime($Date. ' + 1 days'));
//echo date('Y-m-d', strtotime($Date. ' + 2 days'));
        
         $schedule = date('Y-m-d',strtotime($givenDate." +".($frequency)." days"));
        return $schedule;
    }

    public function getEmployeeDeptId($employeeID){
        $where="employee_id=".$employeeID." AND isActive='Y'";
        $query = $this->db->select("*")
        ->from("employee_department")
        ->where($where)
        ->get();
        if($query->num_rows()>0){
            $EmployeeDeptId = $query->row();
        }
    return $EmployeeDeptId;
    }
}
