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
  
    
    
}
