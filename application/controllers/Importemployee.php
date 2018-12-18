<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Importemployee extends CI_Controller {
   public function __construct()
	{
	    parent::__construct();
		$this->load->library('session');
		$this->load->library('excel');//load PHPExcel library 
		$this->load->model("Employee_model","employee");
                $this->load->model("commondatamodel","commondatamodel");
                $this->load->model("Department_model","department");
	}
    public function index(){
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid'])){
            if($this->session->user_data['role']=='Admin'){
              header("Access-Control-Allow-Origin: *");
                $data =[
                    "btnText"=>"Import"
                ];
                $this->template->set('title', 'Import');
                $this->template->load('default_layout', 'contents', 'utility/import', $data);
            }else{
                redirect('login');
            }
        }
        else{
            redirect('login');
        }
    }
    
    public function uploadTemplate()
    {
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid']))
        {
            if($this->session->user_data['role']=='Admin')
            {
               
                $config['upload_path']          = './upload/employee/';
                $config['allowed_types']        = 'xls|xlsx|csv';
                $config['max_size']             = '5000';
                $config['encrypt_name']         =TRUE;
                
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('employeeexcel'))
                {
                        
                        $upload_data = $this->upload->data(); 
		        $file_name = $upload_data['file_name']; 
		        $extension=$upload_data['file_ext']; 
                        //$error = array('error' => $this->upload->display_errors());
                       
                        // print_r($error);
                        //$this->load->view('upload_form', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
                        print_r($data);
                        //$this->load->view('upload_success', $data);
                }
                
                
            }else{
                redirect('login');
            }
            
        }else{
            redirect('login'); 
        }
        
    }
    
    public function validateEmployeeImport()
    {
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid']))
        {
            if($this->session->user_data['role']=='Admin')
            {
                        
                
                
                	if($_FILES['employeeexcel']['error']!=4)
                        {
                            $tempFile = $_FILES['employeeexcel']['tmp_name'];
                            $extension = ".xls";
                            $objReader = NULL;
                            if($extension==".xls")
                            {
                                $objReader= PHPExcel_IOFactory::createReader('Excel5');	// For excel 2007 	  
                            }
                            else
                            {           	
                                $objReader= PHPExcel_IOFactory::createReader('Excel2007');	// For excel 2007 	  
                            }
                            
                                $filename =  $tempFile;
				$objReader->setReadDataOnly(true); 		
				$objPHPExcel=$objReader->load($filename);		 
                                $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel      	 
                                $objWorksheet=$objPHPExcel->setActiveSheetIndex(0); 
                                $totalcolumn = $objPHPExcel->setActiveSheetIndex(0)->getHighestDataColumn();
                                
                                for($i=2;$i<=$totalrows;$i++)
                                {
                                                $employeeCode[] = array(
                                                                       "error" =>  $this->isValidEmpcode($objWorksheet->getCellByColumnAndRow(0,$i)->getValue()),
                                                                       "cell" =>  $objWorksheet->getCellByColumnAndRow(0,$i)->getColumn().$i,
                                                                       "value" => $objWorksheet->getCellByColumnAndRow(0,$i)->getValue()
                                                               );

                                                $employeeName[] = array(
                                                        "error" =>  0,
                                                        "cell" =>  $objWorksheet->getCellByColumnAndRow(1,$i)->getColumn().$i,
                                                        "value" => $objWorksheet->getCellByColumnAndRow(1,$i)->getValue()
                                                );

						$departName[] = array(
							"error" => $this->isValidDepartment($objWorksheet->getCellByColumnAndRow(2,$i)->getValue()),
							"cell" =>  $objWorksheet->getCellByColumnAndRow(2,$i)->getColumn().$i,
							"value" => $objWorksheet->getCellByColumnAndRow(2,$i)->getValue()
						);

						$dateOfJoin[]=array(
                                                        "error" => $this->isValidDateFormat($objWorksheet->getCellByColumnAndRow(3,$i)->getValue()),
							"cell" =>  $objWorksheet->getCellByColumnAndRow(3,$i)->getColumn().$i,
							"value" => $objWorksheet->getCellByColumnAndRow(3,$i)->getValue()
                                                );
                                                
                                                $mobile[]=array(
                                                   "error" => $this->isDuplicateMobile($objWorksheet->getCellByColumnAndRow(4,$i)->getValue()),
							"cell" =>  $objWorksheet->getCellByColumnAndRow(4,$i)->getColumn().$i,
							"value" => $objWorksheet->getCellByColumnAndRow(4,$i)->getValue()
                                                );
                                                $email[]=array(
                                                    "error" => $this->isDuplicateEmail($objWorksheet->getCellByColumnAndRow(5,$i)->getValue()),
                                                    "cell" =>  $objWorksheet->getCellByColumnAndRow(5,$i)->getColumn().$i,
                                                    "value" => $objWorksheet->getCellByColumnAndRow(5,$i)->getValue()
                                                );

					
                                    }
                        }
                        $json_response= array(
		       		"msg_status" => 1,
		       		"employee_code" => $employeeCode,
		        	"employee_name" => $employeeName,
		        	"employee_department" => $departName,
		        	"employee_doj" => $dateOfJoin,
                                "employee_mobile"=>$mobile,
                                "employee_email"=>$email
		        );

		  header('Content-Type: application/json');
		  echo json_encode( $json_response );
		  exit;
            }else{
                redirect('login');
            }
        }else{
            redirect('login');
        }
        
        
        
    }
    
    public function isValidDateFormat($strDate){
     $date_exact_format = str_replace('/', '-', $strDate);
     $date_array = explode("-",$date_exact_format);
     //print_r($date_array);
     //echo(count($date_array));
     $month="";
     $day="";
     $year="";
     if(is_array($date_array)&& count($date_array)==3){
         $day = (int)$date_array[0];
         $month = (int)$date_array[1];
         $year =(int) $date_array[2];
     }else{
         return 1;
     }
     $Isvalid = checkdate ( $month, $day, $year );
     if($Isvalid){
         return 0;
     } else {
         return 1;
     }
//     
//       $date_doj = date('d-m-Y', strtotime($date_exact_format));
//        $isDate= (bool)strtotime($strDate);
//        if($isDate){
//            return 0;
//        }else{
//            return 1;
//        }
        
    }


    public function importAction()
    {
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid']))
           {
                if($this->session->user_data['role']=='Admin')
                {
                    
                    $user_file_name = trim(htmlspecialchars($this->input->post('employeeexcel')));
                    
                    if($_FILES['employeeexcel']['error']!=4)
			{

                        
                         $dir ='./upload/employee/'; 
                         $configUpload['upload_path'] = $dir;
                         $configUpload['allowed_types'] = 'xls|xlsx|csv';
                         $configUpload['max_size'] = '5000';
                         $configUpload['encrypt_name'] = 'true';
                         $this->load->library('upload', $configUpload);
                         
                         //print_r($_FILES);
                         
			if ($this->upload->do_upload('employeeexcel'))
		           {
		                	$upload_data = $this->upload->data(); 
		                	$file_name = $upload_data['file_name']; 
		                	$extension=$upload_data['file_ext'];  
		                	
		 					
		                	$file_insert_arry = array(
		                		"systemname" => $file_name,
		                		"userfilename" => $user_file_name,
		                		"uploaded_by" => $this->session->user_data['userid'],
						
		                	);

		                	if($extension==".xls")
		                	{
		                		$objReader= PHPExcel_IOFactory::createReader('Excel5');	// For excel 2007 	  
		                	}
		                	else
		                	{
		                		$objReader= PHPExcel_IOFactory::createReader('Excel2007');	// For excel 2007 	  
		                	}

		                	$insert = $this->employee->insertEmployeeData($file_insert_arry,$objReader,$this->session);

		                	if($insert)
		                	{
		                		$json_response = array(
							 	"msg_status" => 1,
							 	"msg_data" => "Imported successfully"
								);
		                	}
		                	else
		                	{
		                		$json_response = array(
							 	"msg_status" => 0,
							 	"msg_data" => "There is some problem.Please try again."
								);
		                	}
		                }
		                else
		                {
						    $json_response = array(
							 	"msg_status" => 0,
							 	"msg_data" => "Please check File size and file type"
							);
		                }

		        }
	            else
				{
					$json_response = array(
					 	"msg_status" => 0,
					 	"msg_data" => "Please select file"
					);
			}

			header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;
                    
                    
                }else{
                    redirect('login');
                }
           }else{
               redirect('login');
           }
    }
    
    
    private function isValidEmpcode($empCode)
	{
            if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid']))
             {
                if($this->session->user_data['role']=='Admin')
                {
                    $where = array("employee_master.employee_code"=>$empCode);
                    $isexist = $this->commondatamodel->duplicateValueCheck('employee_master',$where);
                            if($isexist)
                            {
                                    return 1;
                            }
                            else
                            {
                                    return 0;
                            }
                    }
                    else
                    {
                             redirect('login');
                    }
             }else{
                  redirect('login');
             }
	}
    private function isValidDepartment($department)
     {
             if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid']))
             {
                if($this->session->user_data['role']=='Admin')
                {
                    $isValid = $this->department->getValidDepartmentByName($department);
                    if($isValid){
                        return 0;
                    }else{
                        return 1;
                    }
                    
                } else {
                    redirect('login');
                }
             } else {
                 redirect('login');
             }
     }
     /**
      * 
      * @param type $mobile
      * @return int
      */
    private function isDuplicateMobile($mobile)
    {
        if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid']))
             {
                if($this->session->user_data['role']=='Admin')
                {
                    $where = array("employee_master.employee_mobile"=>$mobile);
                    $isexist = $this->commondatamodel->duplicateValueCheck('employee_master',$where);
                            if($isexist)
                            {
                                    return 1;
                            }
                            else
                            {
                                    return 0;
                            }
                    }
                    else
                    {
                             redirect('login');
                    }
             }else{
                  redirect('login');
             }
    }
    /**
     * 
     * @param type $email
     * @return int
     */
    private function isDuplicateEmail($email){
           if($this->session->user_data['userid']!="" && !empty($this->session->user_data['userid']))
             {
                if($this->session->user_data['role']=='Admin')
                {
                    $where = array("employee_master.employee_email"=>$email);
                    $isexist = $this->commondatamodel->duplicateValueCheck('employee_master',$where);
                            if($isexist)
                            {
                                    return 1;
                            }
                            else
                            {
                                    return 0;
                            }
                    }
                    else
                    {
                             redirect('login');
                    }
             }else{
                  redirect('login');
             }
    }
}
