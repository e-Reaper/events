<?php
	class Get_organisers extends CI_Model{
		
		function add($new)
		{
			print_r($new);
			$query = $this->db->insert_batch('event_organiser_details',$new);
			if($query)
			{
			return true;
			}
			else{
			return false;
			}
		}
		function delete($id){
			$query = $this->db->query("delete from event_organiser_details where Event_Id = ".$id);
		}
		function get_by_event_id($id){
			$query = $this->db->query("select * from event_organiser_details where Event_Id = ".$id);
			return $query->result();
		}
		function number_of_organiser($id){
			$query = $this->db->query("select * from event_organiser_details where Event_Id = ".$id);
			return $query->num_rows();
		}
				
		function is_organiser($user,$event){
			$query = $this->db->query("select Name from event_organiser_details where User_Id =".$user." and Event_Id = ".$event."");
			if($query->num_rows()>0)
			return true;
			else
			return false;
		}

	}
?>