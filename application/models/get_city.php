<?php
	class Get_city extends CI_Model{
		
		function getAll(){
			$query=$this->db->query("select * from cities where name not like '' and country like 'India' order by name ");
			return $query->result();
		}
		function get_by_id($city_id){
			$query=$this->db->query("select name as city from cities where id=".$city_id);
			
			return $query->result();
		}
	}
?>