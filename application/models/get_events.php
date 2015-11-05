<?php
	class Get_events extends CI_Model{
		
		function upcoming(){
			$current_date=date('Y/m/d');
			$current_time=date('G:i');	
			$query = $this->db->query("select * from event WHERE sdate>'{$current_date}' or ( sdate='{$current_date}' and stime>'{$current_time}')");
			return $query->result();
		}
		function past(){
			$current_date=date('Y/m/d');
			$current_time=date('G:i');
			$query = $this->db->query("select * from event  WHERE sdate<'{$current_date}' or (sdate='{$current_date}' and stime<'{$current_time}')");
			return $query->result();
		}
		
		function create($new){
			$query = $this->db->insert('event',$new);
			return $this->db->insert_id();
		}
		
		function get_by_id($id){
			$query = $this->db->query("select * from event where event_id = ".$id);
			return $query->result();
		}
		
		function search($str){
			$query = $this->db->query("select event_id,event_logo,title,location from event where event_id in (select parent_id from `tag-post` where type=3 and tags_id in(select hashtag_id from hashtag_details where hashtag like '%".$str."%')) or title like '%".$str."%' or location like '%".$str."%' or city in (select id from cities where name like '%".$str."%')");
			return $query->result();
		}
		
		function update($data,$id){
			$this->db->update("event",$data,"event_id = ".$id);
		}
		
		function is_creator($user,$event){
			$query = $this->db->query("select title from event where creator =".$user." and event_id = ".$event."");
			if($query->num_rows()>0)
			return true;
			else
			return false;
		}

	}
?>

