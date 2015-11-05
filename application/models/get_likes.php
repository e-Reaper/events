<?php
	class Get_likes extends CI_Model{
		function like($data){
			$query=$this->db->query("select id from likes where parent_id=".$data['parent_id']." and like_type = ".$data['like_type']." and  unique_user_id = ".$data['unique_user_id']);
			if($query->num_rows()==0)
			$this->db->insert('likes',$data);
		}
		function get_num_of_likes($parent,$type){
			$query=$this->db->query("select count(id) as likes from likes where parent_id=".$parent." and like_type = ".$type);
			$likes=$query->result();
			$like_num=0;
			foreach($likes as $l)
			{
				$like_num=$l->likes;
			}
			$query=$this->db->query("select count(id) as likes from likes where parent_id=".$parent." and like_type = ".$type." and unique_user_id=".$this->session->userdata('user_id'));
			if($query->num_rows()>0)
			{
				$you=1;
			}
			$str="";
			if($like_num!=0)
			{
				if($you==1)
				{
					$str=$str." You";
					if($like_num!=1)
					{
						$str=$str." and ".($like_num-1)." people "; 
					}
					$str=$str." Liked this";
				}
				else
				{
					$str=$str." ".$like_num." people liked this";
				}
			}
			return $str;
		}
	}
?>