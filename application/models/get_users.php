<?php
	class Get_users extends CI_Model{
		
		function can_login(){
			$this->db->where('email',$this->input->post('email'));
			$this->db->where('password',md5($this->input->post('password')));
			$query = $this->db->get('users');
			if($query->num_rows()==1){
				return true;
			}
			else{
				return false;
			}
		}
		
		function register($data){
			$this->db->insert("users",$data);
		}
		
		function get_by_mail($mail){
			$query = $this->db->query("select * from users where email='".$mail."'");
			return $query->result();
		}
		
		function search($str){
			$query=$this->db->query("select id,name,email,image from users where (name like '".$str."%' or email like '".$str."%') and id!=0" );
			return $query->result();
		}
		
	}
?>