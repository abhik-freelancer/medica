<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Employee_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->model("commondatamodel", "commondatamodel");
        $this->load->model("Department_model","department");
    }

    

    public function getEmployeeDataByEmployeeId($employeeId){
        $employee="";
        $where_arr =[
                        "employee_id"=>$employeeId,
            ];
       $query= $this->db->select("employee_master.*")
                ->where($where_arr)
                ->get("employee_master");
               
       if($query->num_rows()>0)
       {
           $employee = $query->row();
           
       }
       return $employee;
    }
    
    
    public function getEmployeeList($hospitalId)
    {
        $employeeList="";
        $where_arr =[
                        "employee_master.hospital_id"=>$hospitalId
            ];
        $query = $this->db->select("employee_master.*,hospital_master.hospital_name,department_master.department_name")
                ->from("employee_master")
                ->join("department_master","employee_master.department_id = department_master.department_id")
                ->join("hospital_master","employee_master.hospital_id = hospital_master.hospital_id")
                ->where($where_arr)
                ->order_by("employee_master.employee_name")->get();
$this->db->last_query();    
                 if($query->num_rows()>0){
            foreach($query->result() as $rows)
				{
					$employeeList[]=$rows;
				}
            
            
            
           // $department = $query->row();
        }
        return $employeeList;
        
        
    }
    
    
    public function insertEmployeeData($insertArray,$objReader,$session)
	{

        try {
            $this->db->trans_begin();
            $this->db->insert('employee_fileinfo', $insertArray);
       
            $filename ='./upload/employee/' . $insertArray['systemname'];
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($filename);
            $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel      	 
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

            $employee_master = array();
            for ($i = 2; $i <= $totalrows; $i++) {
                $employee_code = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue(); //Excel Column 1
                $employee_name = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue(); //Excel Column 2
                $department = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue(); //Excel Column 3
                $DOJ = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
                
                $mobile = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
                $email = $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
                $joiningDate= date('Y-m-d', strtotime(str_replace('/', '-', $DOJ)));
                $where = array("employee_master.employee_code" => $employee_code);
                $isExistEmpcode = $this->commondatamodel->duplicateValueCheck('employee_master', $where);

                if ($isExistEmpcode) {
                    $update = [
                        "hospital_id" => $session->user_data['hospitalid'],
                        "department_id" => $this->department->getDepartmentIdByName($department),
                        "employee_name" => $employee_name,
                        "employee_doj" =>$joiningDate,
                        "employee_email"=>$email,
                        "employee_mobile"=>$mobile
                    ];
                    $this->db->where("employee_master.employee_code",$employee_code);
                    $this->db->update("employee_master", $update);
                } else {
                    $employee_data = [
                        "employee_code" => $employee_code,
                        "hospital_id" => $session->user_data['hospitalid'],
                        "department_id" => $this->department->getDepartmentIdByName($department),
                        "employee_name" => $employee_name,
                        "employee_doj" => $joiningDate,
                        "employee_email"=>$email,
                        "employee_mobile"=>$mobile,
                        "employee_status" => 'Active'
                    ];
                   
                    $this->db->insert('employee_master', $employee_data);
                    $last_id=$this->db->insert_id();                     
                    $this->insertIntoEmployeeDepartment($last_id,$this->department->getDepartmentIdByName($department),$joiningDate,$session->user_data['hospitalid']);             

              

                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $err) {
            echo $err->getTraceAsString();
        }
    }
    
    public function getEmployeeVaccineSchedule($departmentId,$date_of_join,$hospitalId)
    {
        
     $employeeVaccine="";
        $whereClause = [
            "department_vaccine.department_id "=>$departmentId,
            "vaccine.hospital_id"=>$hospitalId,
            "vaccine.parent_vaccine"=>NULL
        ];
        
        $query = $this->db->select("vaccine.*")
                    ->from("vaccine")->join("department_vaccine","vaccine.id = department_vaccine.vaccine_id")
                    ->where($whereClause)->get();

                   
        $dateOfJoining = date("Y-m-d", strtotime($date_of_join));
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
                        "scheduleDate"=>$this->getSchedule($dateOfJoining,$rows->id),
                        "givenDate"=>""
                    ];
		}
                       
           // $department = $query->row();
        }
       
        return $employeeVaccine;
        
    }
    

    public function getSchedule($doj,$vaccineId)
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
            $parent_schedule = date('Y-m-d',strtotime (($frequency_parent)." day" , strtotime($doj)));
            $schedule = date('d-m-Y',strtotime (($frequency)." day" , strtotime($parent_schedule)));
        }else{
            $schedule = date('d-m-Y',strtotime ( ($frequency)." day" , strtotime ( $doj ) ));
        }
        
       return $schedule; 
    }
    
    public function getVaccineSchedule($employeeId)
    {
        $employeeVaccine ="";
        $query = $this->db->select("employee_vaccination_detail.*,vaccine.*")
                ->from("employee_vaccination_detail")
                ->join("vaccine","employee_vaccination_detail.vaccination_id = vaccine.id")
                ->where("employee_vaccination_detail.employee_id",$employeeId)->get();
       if($query->num_rows()>0)
       {
           foreach($query->result() as $rows)
           {    
            $employeeVaccine[] = $rows;
           }
           
       }
       return $employeeVaccine;
    }
    
    public function deletevaccinationSchdlByEmpId($employee_id)
    {
        $delClause = [
            "employee_id"=>$employee_id,
            "is_given"=>'N'
        ];
        $this->db->where($delClause);
        $this->db->delete("employee_vaccination_detail");
    }


// added by sandipan sarkar on 28/12/2018

    public function insertIntoEmployeeDepartment($last_id,$department_id,$doj,$hospitalid)
    {
        $employee_department=[
            "employee_id"=>$last_id,
            "dept_id" => $department_id,
            "date_of_join" => $doj,
            "from_module"=>'XL' ,// to identify the insertion module -XL:= importfile
            "isActive"=>'Y'
        ];
        $this->db->insert('employee_department', $employee_department);
        $employee_dept_id=$this->db->insert_id(); 
        $getEmployeeVaccineSchedule=$this->getEmployeeVaccineSchedule($department_id,$doj,$hospitalid);        
        if (!empty($getEmployeeVaccineSchedule)) {        
            foreach ($getEmployeeVaccineSchedule as $value) {                
                $employee_vaccination_detail=[
                    "employee_id"  =>$last_id,
                    "department_id"=>$department_id,
                    "employee_dept_id"=>$employee_dept_id,
                    "vaccination_id"=>$value['vaccineId'],
                    "schedule_date"=>($value['scheduleDate']==""?NULL:date('Y-m-d', strtotime($value['scheduleDate']))),
                    "actual_given_date"=>($value['givenDate']==""?NULL:date('Y-m-d', strtotime($value['givenDate']))) ,
                    "is_given" =>($value['givenDate']==""?"N":"Y") ,
                    "parent_vaccineId" =>($value['parent_vaccine']==""?NULL:$value['parent_vaccine']),
                    "hospital_id"=>$hospitalid,
                    
                ];
                $this->db->insert('employee_vaccination_detail', $employee_vaccination_detail);
            }
        }
        
       return true;

        
    }
    
}
