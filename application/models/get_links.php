<?php
	class Get_links extends CI_Model{
		
		function add($new){
			$query = $this->db->insert_batch('event_other_links',$new);
			if($query)
			return true;
			else
			return false;
		}
		function delete($id){
			$query = $this->db->query("delete from event_other_links where event_Id = ".$id);
		}
		
		function get_by_event_id($id){
			$query = $this->db->query("select * from event_other_links where event_id = ".$id);
			return $query->result();
		}
		function number_of_links($id){
			$query = $this->db->query("select * from event_other_links where event_Id = ".$id);
			return $query->num_rows();
		}

	}
?>