<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vaccine_model extends CI_Model{
   public function getVaccineList($hospitalId)
    {
        $vaccine ="";
        
        $sql ="SELECT
                vaccine.id,
                vaccine.vaccine ,
                (SELECT  vc.vaccine AS parent FROM vaccine vc WHERE vc.id=vaccine.parent_vaccine )AS parent,
                vaccine.parent_vaccine,
                vaccine.frequency,
                vaccine.is_depend_doj 
              FROM medica_data.vaccine ORDER BY vaccine.id";
        
        
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                $vaccine[]=$row;
            }
        }
        return $vaccine;
    }

    public function getTotalPendingVaccineByScheduleMonth($table,$where,$date)
		{            
			$this->db->select('*')
				->from($table)
                ->where($where)
                ->like('schedule_date',$date);

			$query = $this->db->get();
			$rowcount = $query->num_rows();
		//echo $this->db->last_query();exit();
			if($query->num_rows()>0){
				return $rowcount;
			}
			else
			{
				return 0;
			}
		

        }
    
        public function pendingVaccineListGroupByVaccineName($hospitalId)
        {
            $pendingVaccineList="";
            $currentMonth=date('Y-m');
            $firstDayThisMonth=date('Y-m-01');
            $lastDayThisMonth = date("Y-m-t");
            $where=[
               "employee_vaccination_detail.is_given" => 'N',
               "employee_vaccination_detail.hospital_id" =>$hospitalId
            ];
            $query= $this->db->select("COUNT(`employee_vaccination_detail`.`employe_vaccine_id`) AS no_of_employee,`vaccine`.`vaccine` AS name,`vaccine`.`id` AS id")
                     ->from("employee_vaccination_detail")
                     ->join("vaccine","`employee_vaccination_detail`.`vaccination_id` = `vaccine`.`id`")
                     ->where($where)
                     ->where("employee_vaccination_detail.`schedule_date` BETWEEN '$firstDayThisMonth' AND '$lastDayThisMonth'")
                     //->like("employee_vaccination_detail.`schedule_date`",$currentMonth)
                     ->group_by("`employee_vaccination_detail`.`vaccination_id`")->get();
                  //  echo $this->db->last_query();exit;
            if($query->num_rows()>0){
                foreach($query->result() as $rows)
                    {
                        $pendingVaccineList[]=$rows;
                    }               
            }
            return $pendingVaccineList;
        }

    
    
    
}
