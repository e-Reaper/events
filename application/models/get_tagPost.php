<?php
	class Get_tagPost extends CI_Model{
		function insert($row){
			$query = $this->db->insert('tag-post',$row);
		}
		function update($hash,$event,$type){
			echo "update `tag-post` set tags_id =".$hash." where type = ".$type." and parent_id = ".$event;
			$query=$this->db->query("update `tag-post` set tags_id =".$hash." where type = ".$type." and parent_id = ".$event);
		}
		function get_by_event_id($event){
			$query=$this->db->query("SELECT `hashtag` FROM  `hashtag_details` where `hashtag_id` in (select `tags_id` from `tag-post` where `type`= 3 and `parent_id`=".$event.") and hashtag_id!=0 ");
			return $query->result();
		}
	}
?>