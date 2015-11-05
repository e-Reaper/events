<?php
	class Get_hash extends CI_Model{
		
		function get_hash_id($new){
			$query = $this->db->query("SELECT hashtag_id FROM hashtag_details WHERE hashtag = '".$new['hashtag']."' ");
			if($query->num_rows()>0)
			{
				$result=$query->result();
				return $result[0]->hashtag_id;
			}
			else
			{
				$query = $this->db->insert('hashtag_details',$new);
				return $this->db->insert_id();
			}
		}
		function get_by_event_id($id){
			$query = $this->db->query("select * from hashtag_details where hashtag_id in(select hashtag_id from event where event_id = ".$id.")");
			return $query->result();
		}
	}
?>