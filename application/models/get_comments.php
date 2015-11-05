<?php
	class Get_comments extends CI_Model{
			
			function get_by_id($id,$type){
			$query=$this->db->query("SELECT comments.id as comment_id,comments.Unique_user_id,comments.parent_id,comments.comment,comments.comment_type,comments.`time`,users.name,users.id as uid,users.image FROM  `comments` JOIN  `users` ON comments.Unique_user_id = users.id where comments.parent_id=".$id." and comment_type=".$type);
			return $query->result();
		}
		function comment($data){
			$this->db->insert('comments',$data);
		}
	}
?>