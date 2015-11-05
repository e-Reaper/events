<?php
	class Get_guests extends CI_Model{
		
		function mark($data){                                ///////// mark the choice of user attending or not /////////////		
			$this->db->where('Event_ID',$data['Event_ID']);
			$this->db->where('Guest_ID',$data['Guest_ID']);
			$query = $this->db->get('event_guests');
			if($query->num_rows()==1){
				$update['isAttending']=$data['isAttending'];
				$this->db->update("event_guests",$update,"Event_ID = '{$data['Event_ID']}' and Guest_ID = '{$data['Guest_ID']}'");
			}
			else{
				$this->db->insert("event_guests",$data);
			}
		}
		function guests($event){                             ///////// get all the guests////////////////////////////////////
			$query=$this->db->query('select name,image,id,email from users where id in (select Guest_ID from event_guests where Event_ID = "'.$event.'" and isAttending = 1) order by name');
			return $query->result();		
		}
		function searchGuests($str,$event){                  ///////// search the guests name matching the string ///////////
			$query=$this->db->query('select name,image,id,email from users where id in (select Guest_ID from event_guests where Event_ID = "'.$event.'" and isAttending = 1) and name like "%'.$str.'%" order by name');
			return $query->result();		
		}
		function to_invite($event){                          ///////// get the invitable users //////////////////////////////
			$query=$this->db->query('select name,image,id,email from users where id not in (select Guest_ID from event_guests where Event_ID = "'.$event.'") and id not in (select guest from invitations where event_id = "'.$event.'") and id !=0 order by name');
			return $query->result();		
		}
		function SearchInvitees($str,$event){                ///////// search invitable users by name////////////////////////
			$query=$this->db->query('select name,image,id,email from users where id not in (select Guest_ID from event_guests where Event_ID = "'.$event.'") and id not in (select guest from invitations where event_id = "'.$event.'") and name like "%'.$str.'%"order by name');
			return $query->result();		
		}
		function invite($data){                              ///////// invite a user ////////////////////////////////////////
			$query = $this->db->query('select id from users where id not in (select Guest_ID from event_guests where Event_ID = '.$data["event_id"].') and id not in (select guest from invitations where event_id = '.$data["event_id"].') and id='.$data["guest"]);
			print_r($query->result());
			if($query->num_rows()==1){
				$this->db->insert("invitations",$data);
			}
		}
		function num($event){                                ///////// number of guests//////////////////////////////////////
			$query=$this->db->query('SELECT COUNT( Guest_Id ) as num FROM event_guests WHERE Event_Id ='.$event.' and isAttending = 1');
			return $query->result();
		}
		function few_going($event){                          ///////// get few names of guests///////////////////////////////
			$query=$this->db->query("SELECT name,id from users where id in (select Guest_Id FROM event_guests WHERE Event_Id =".$event." and isAttending = 1) limit 0,3");
			return $query->result();
		}
		function isAttending($event){                        ///////// check if attendding or not ///////////////////////////
			$query=$this->db->query("select isAttending from event_guests WHERE Event_Id =".$event." and Guest_Id = ".$this->session->userdata('user_id'));
			if($query->num_rows()==0)
			return -1;
			else 
			return $query->result();
		}
	}
?>