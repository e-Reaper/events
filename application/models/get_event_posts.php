<?php	
	class Get_event_posts extends CI_Model{
		
		function insert_new_post($data){
			$query=$this->db->insert("event_posts",$data);
			return $this->db->insert_id();
		}
		function get_post_by_id($id){
			$query=$this->db->query("SELECT event_posts.id as post_id,event_posts.Unique_user_id,event_posts.Events_id,event_posts.Content,event_posts.type,event_posts.`Date`,users.name,users.id as uid,users.image FROM  `event_posts` JOIN  `users` ON event_posts.Unique_user_id = users.id where event_posts.id=".$id);
			return $query->result();
		}
	}

?>