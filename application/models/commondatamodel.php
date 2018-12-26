<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class commondatamodel extends CI_Model{
	
	public function insertSingleTableData($table,$data){
            $lastinsert_id = 0;
        try {
            $this->db->trans_begin();

            $this->db->insert($table, $data);
            $lastinsert_id = $this->db->insert_id();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $lastinsert_id=0;
                return $lastinsert_id;
            } else {
                $this->db->trans_commit();
                return $lastinsert_id;
            }
        } catch (Exception $err) {
            echo $err->getTraceAsString();
        }
    }
    
    public function updateSingleTableData($table,$data,$where){

        
        try {
            $this->db->trans_begin();
            //$this->db->where($where);
			$this->db->update($table, $data,$where);
			$this->db->last_query();
            //$affectedRow = $this->db->affected_rows();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                
                return FALSE;
            } else {
                $this->db->trans_commit();
                
                return TRUE;
            }
        } catch (Exception $exc) {
             return FALSE;
        }
    }
    
    public function deleteTableData($table,$where)
    {
        $this->db->delete($table, $where); 
    }

	/* 
		@insertMultiTableData('name of table array','insert value as array')
		@date 14.11.2017
		@By Mithilesh
	*/
	
	public function insertMultiTableData($tblnameArry,$insertArray){
		try{
            $this->db->trans_begin();
			
			for($i=0;$i<sizeof($insertArray);$i++)
			{
				 $this->db->insert($tblnameArry[$i], $insertArray[$i]);
				 
			}
			if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
		catch (Exception $err) {
            echo $err->getTraceAsString();
        }
	}
	
	
	public function checkExistanceData($table,$where)
	{
		
		$this->db->select('*')
				->from($table)
				->where($where);
		$query = $this->db->get();
	
		if($query->num_rows()>0){
			return 1;
		}
		else
		{
			return 0;
		}
		
	}
	
	public function getAllDropdownData($table)
	{
		$data = array();
		$this->db->select("*")
				->from($table);
		$query = $this->db->get();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
	}
	
	public function getSingleRowByWhereCls($table,$where)
	{
		$data = array();
		$this->db->select("*")
				->from($table)
				->where($where)
				->limit(1);
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row;
             
        }
		else
		{
            return $data;
        }
	}
	
	
	public function getAllRecordWhere($table,$where)
	{
		$data = array();
		$this->db->select("*")
				->from($table)
				->where($where);
		$query = $this->db->get();
		//echo $this->db->last_query();

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
	}

	public function getAllRecordWhereOrderBy($table,$where,$orderby)
	{
		$data = array();
		$this->db->select("*")
				->from($table)
				->where($where)
				->order_by($orderby);
		$query = $this->db->get();
		//echo $this->db->last_query();

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
	}

	public function getAllRecordOrderByLike($table,$likecolumn,$likeStr,$orderby,$ordertag)
	{
		$data = array();
		$this->db->select("*")
				->from($table)
				->like($likecolumn,$likeStr,'after')
				->order_by($orderby,$ordertag);
		$query = $this->db->get();
		//echo $this->db->last_query();

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
	}


	public function getAllRecordOrderByLikeWhere($table,$where,$likecolumn,$likeStr,$orderby,$ordertag)
	{
		$data = array();
		$this->db->select("*")
				->from($table)
				->where($where)
				->like($likecolumn,$likeStr,'after')
				->order_by($orderby,$ordertag);
		$query = $this->db->get();
		//echo $this->db->last_query();

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
	}

	public function getAllRecordOrderBy($table,$orderby,$orderTag)
	{
		$data = array();
		$this->db->select("*")
				->from($table)
				->order_by($orderby,$orderTag);
		$query = $this->db->get();
		//echo $this->db->last_query();

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
	}

	/*
	@updateData_WithUserActivity('update table name','update table data','update table where condition','user activity table name','user activity table data');
	*/
	public function updateData_WithUserActivity($upd_tbl_name,$upd_data,$upd_where,$user_actvty_tbl,$user_actvy_data)
	{
		 try {
            $this->db->trans_begin();
			$this->db->where($upd_where);
            $this->db->update($upd_tbl_name,$upd_data);
         //   echo $this->db->last_query();
			$this->db->insert($user_actvty_tbl, $user_actvy_data);
			
			
				
            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
		catch (Exception $err) {
            echo $err->getTraceAsString();
        }
	}


	/* fetching Data For All type of document from any module
	*  @getDocumentDetailData('where upload_from_module_id,upload_from_module');
	*  On 23.01.2018
	*  By Mithilesh
	*/

	public function getDocumentDetailData($where)
	{

		$data = array();
		$this->db->select("*")
				->from('document_upload_all')
				->join('document_type','document_type.id = document_upload_all.document_type_id','INNER')
				->where($where);
		$query = $this->db->get();
		//echo $this->db->last_query();

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }

	}


	public function rowcount($table)
	{
		
		$this->db->select('*')
				->from($table);

		$query = $this->db->get();
		$rowcount = $query->num_rows();
	
		if($query->num_rows()>0){
			return $rowcount;
		}
		else
		{
			return 0;
		}
		
	}
        /**
         * @author Abhik
         * @param type $table
         * @param type $column
         * @param type $dataType
         * @return boolean
         */
        
        public function duplicateValueCheck($table="",$where="")
        {
            
            $query = $this->db->select("*")->from($table)->where($where)->get();
            if($query->num_rows()>0){
			return TRUE;
		}
		else
		{
			return FALSE;
		}
            
            
        }
	

	
	
}