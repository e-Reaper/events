<?php	
	class Get_poll_options extends CI_Model{
		
		function insert_new_option($data){
			$query=$this->db->insert_batch("poll_option",$data);
		}
		
		function get_poll_option($id){
			$query=$this->db->query("select * from poll_option where parent_id = ".$id);
			return $query->result();
		}
		function get_new_option($data){
			$query=$this->db->insert("poll_option",$data);
			return $this->db->insert_id();		
		}
		
	}
?>