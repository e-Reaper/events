<?php	
	class Get_event_edit_history extends CI_Model{
	
	function get_post_by_id($id){
		$query=$this->db->query("SELECT event_edit.id as post_id,event_edit.user_id,event_edit.event_id,event_edit.field,event_edit.old_value,event_edit.`time`,users.name,users.id as uid,users.image FROM  `event_edit` JOIN  `users` ON event_edit.user_id = users.id where event_edit.id=".$id);
		return $query->result();
	}
	function insert_new_activity($data){
		$query=$this->db->insert("event_edit",$data);
		$id=$this->db->insert_id();
		return $id;
	}
}