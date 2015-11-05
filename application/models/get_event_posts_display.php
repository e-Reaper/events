<?php	
	class Get_event_posts_display extends CI_Model{
		
		function insert_new_activity($data){
			$query=$this->db->insert("event_post_display",$data);
			$id=$this->db->insert_id();
			$query=$this->db->query('select * from `event_post_display` WHERE id='.$id);
			return $query->result();
		}
		
		function get_recent_activity($event_id){
			$query=$this->db->query("SELECT * FROM  `event_post_display` WHERE ( `table_name` =2 AND `activity_id` IN ( SELECT `id` FROM `event_posts` WHERE `Events_id` =".$event_id.")) or (`table_name`=1 and activity_id IN ( SELECT `id` FROM `event_edit` WHERE `event_id` =".$event_id.")) order by `time` desc");
			return $query->result();
		}
	}

?>