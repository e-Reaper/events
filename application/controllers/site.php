<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once("include/convert.inc");
class Site extends CI_Controller {
	public function index(){                                            ////////////// when the page loads /////////////////////
		if($this->session->userdata('is_logged_in')){
			$this->home();
		}
		else{
			$data['title']="Almashines Events - Creat organise and view events";
			$this->load->view('login/login',$data);
		}
	}
	public function home(){                                             ///////// if user is logged in show homepage ///////////
		if($this->session->userdata('is_logged_in'))
		{
			$data['title']="Almashines Events - Creat organise and view events";
			$this->load->view("home/resource",$data);
			$this->load->view("base/header");
			$this->load->model('get_city');
			$city['list_of_cities']=$this->get_city->getAll();
			$this->load->view("home/event_form",$city);
			$this->load->model('get_events');
			$data['upcoming'] = $this->get_events->upcoming();
			$data['past'] = $this->get_events->past();
			$this->load->view("home/event_list",$data);
		}
		else
		redirect('users/login');
	}
	public function events($event_id=0){                                //////////////////// show events ///////////////////////
		
		if($event_id==0)redirect('site/home');
		if(!$this->session->userdata('is_logged_in'))
		redirect('users/login');
		
		$title['title']="Almashines Events - Creat organise and view events";
		$this->load->model('get_events');
		$data['event'] = $this->get_events->get_by_id($event_id);
		$this->load->model('get_event_posts_display');
		$data['activity']=$this->get_event_posts_display->get_recent_activity($event_id);
		$this->load->model('get_organisers');		
		$data['organisers'] = $this->get_organisers->get_by_event_id($event_id);
		$this->load->model('get_links');
		$data['links'] = $this->get_links->get_by_event_id($event_id);
		$this->load->model('get_tagPost');
		$data['hash'] = $this->get_tagPost->get_by_event_id($event_id);
		$this->load->model('get_guests');
		$atnd=$this->get_guests->isAttending($event_id);
		$data['attend']=-1;
		if($atnd!=-1)
		foreach($atnd as $a){
		$data['attend']= $a->isAttending;
		}
		$this->load->view("event/resource",$title);
		$this->load->view("base/header");
		$this->load->view('event/event',$data);
		
	}
	public function attend($event_id,$is_attending,$user_id){/////////////whether user is attending or not /////////
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$data= array("Event_ID"=>$event_id,"Guest_ID"=>$user_id,"isAttending"=>$is_attending);
		print_r($data);
		$this->load->model('get_guests');
		$this->get_guests->mark($data);
	}
	public function guests($event){                                     ////////////// get the guests of the event /////////////
	
		if(!$this->session->userdata('is_logged_in'))
		return false;

		$this->load->model('get_guests');
		$data['result']=$this->get_guests->guests($event);
		$this->load->view('event/request/guests',$data);
	}	
	public function to_invite($event){                                  ////////////// get the people to invite ////////////////
		
		if(!$this->session->userdata('is_logged_in'))
		return false;
		
		$this->load->model('get_guests');
		$data['result']=$this->get_guests->to_invite($event);
		$data['event']=$event;
		$this->load->view('event/request/to_invite',$data);
	}	
	public function invite($guest,$event,$user){                        ///////////// invite a person or say user///////////////
		
		if(!$this->session->userdata('is_logged_in'))
		return false;

		$this->load->model('get_guests');
		$invitation=array(
			"event_id" => $event,
			"guest" => $guest,
			"inviter" => $user
		);
		print_r($invitation);
		$this->get_guests->invite($invitation);
	}
	public function SearchEvent($str){                                  //search for event matching title,location,venue,hashtag
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$str=str_replace("%7B%7B%7D%7D"," ",$str);                    /////////////////// because " {{}} " is changed to "%7B%7B%7D%7D"
		
		$this->load->model('get_events');
		$data['str']=$str;
		$data['results'] = $this->get_events->search($str);
		$this->load->view('home/request/searchedEvents',$data);
	}
	public function SearchGuests($str,$event){                          //search for guests by name matching the search string//
		
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$str=str_replace("%7B%7B%7D%7D"," ",$str);                    /////////////////// because " {{}} " is changed to "%7B%7B%7D%7D"		
		$this->load->model('get_guests');
		$data['result'] = $this->get_guests->searchGuests($str,$event);
		$this->load->view('event/request/guests',$data);
	}
	public function SearchInvitees($str,$event){                        //search for invitees by name matching the search string
		
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$str=str_replace("%7B%7B%7D%7D"," ",$str);                    /////////////////// because " {{}} " is changed to "%7B%7B%7D%7D"				
		$this->load->model('get_guests');
		$data['event']=$event;
		$data['result'] = $this->get_guests->searchInvitees($str,$event);
		$this->load->view('event/request/to_invite',$data);
	}
	public function EditEventForm($event_id){                           ////////////// get the form to edit event //////////////
		
		if(!$this->session->userdata('is_logged_in'))
		return false;
		
		if(!$this->can_edit($this->session->userdata('user_id'),$event_id))
		return false;

		$data['event_id']=$event_id;
		$this->load->model('get_events');
		$data['event'] = $this->get_events->get_by_id($event_id);
		$this->load->model('get_organisers');		
		$data['organisers'] = $this->get_organisers->get_by_event_id($event_id);
		$this->load->model('get_links');
		$data['links'] = $this->get_links->get_by_event_id($event_id);
		$this->load->model('get_tagPost');
		$data['hash'] = $this->get_tagPost->get_by_event_id($event_id);
		$this->load->model('get_city');
		$data['list_of_cities'] = $this->get_city->getAll();
		$this->load->view('event/request/EditEvent',$data);
	}
	public function CheckEventChanges($event_id){                           ////////////// it will check for the change in the events //////////////
		
		if(!$this->session->userdata('is_logged_in'))
		return false;
		
		if(!$this->can_edit($this->session->userdata('user_id'),$event_id))
		return false;
		$editor=$this->session->userdata('user_id');
		if($this->input->post('e_public')){ $e_pub='1';} else { $e_pub='0'; }
			if($this->input->post('e_f_date')) {
				$fdate=convertdate($this->input->post('e_f_date'));
			} else {
				$fdate="";
			}
			if($this->input->post('e_f_time')) {
				$ftime=converttime($this->input->post('e_f_time'));
			} else {
				$ftime="";
				}
		$data['event_id']=$event_id;
		$this->load->model('get_events');
		$this->load->model('get_event_edit_history');
		$data['event'] = $this->get_events->get_by_id($event_id);
		
		$this->load->model('get_event_posts_display');
		if($data['event'][0]->title != $this->input->post('e_title')) {
		$event_change=array('event_id'=>$event_id,'field'=>1,'old_value'=>$data['event'][0]->title,'user_id'=>$editor);
		$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);
		$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>1);
		$activity=$this->get_event_posts_display->insert_new_activity($data1);
		}
		if($data['event'][0]->location != $this->input->post('e_location') && $data['event'][0]->city != $this->input->post('e_city') ) {
		$event_change=array('event_id'=>$event_id,'field'=>3,'old_value'=>$data['event'][0]->location.",".$data['event'][0]->city,'user_id'=>$editor);
		$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);
		$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>3);
		$activity=$this->get_event_posts_display->insert_new_activity($data1);
		}
		else if($data['event'][0]->location != $this->input->post('e_location')) {
		$event_change=array('event_id'=>$event_id,'field'=>2,'old_value'=>$data['event'][0]->location,'user_id'=>$editor);
		$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);
		$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>2);
		$activity=$this->get_event_posts_display->insert_new_activity($data1);
		}
		if($data['event'][0]->sdate != convertdate($this->input->post('e_s_date')) && $data['event'][0]->stime != converttime($this->input->post('e_s_time'))) 		  {
		$event_change=array('event_id'=>$event_id,'field'=>6,'old_value'=>$data['event'][0]->sdate.','.$data['event'][0]->stime,'user_id'=>$editor);
		$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);
		$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>6);
		$activity=$this->get_event_posts_display->insert_new_activity($data1);
		}
		else if($data['event'][0]->sdate != convertdate($this->input->post('e_s_date'))) {
		$event_change=array('event_id'=>$event_id,'field'=>4,'old_value'=>$data['event'][0]->sdate,'user_id'=>$editor);
		$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);
		$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>4);
		$activity=$this->get_event_posts_display->insert_new_activity($data1);
		}
		else if($data['event'][0]->stime != converttime($this->input->post('e_s_time'))){
		$event_change=array('event_id'=>$event_id,'field'=>5,'old_value'=>$data['event'][0]->stime,'user_id'=>$editor);
		$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);
		$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>5);
		$activity=$this->get_event_posts_display->insert_new_activity($data1);
		}	
		if($data['event'][0]->fdate != $fdate && $data['event'][0]->ftime != $ftime) {
		$event_change=array('event_id'=>$event_id,'field'=>9,'old_value'=>$data['event'][0]->fdate.','.$data['event'][0]->ftime,'user_id'=>$editor);
		$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);
		$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>9);
		$activity=$this->get_event_posts_display->insert_new_activity($data1);
		}
		else if($data['event'][0]->fdate != $fdate) {
		$event_change=array('event_id'=>$event_id,'field'=>7,'old_value'=>$data['event'][0]->fdate,'user_id'=>$editor);
		$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);
		$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>7);
		$activity=$this->get_event_posts_display->insert_new_activity($data1);
		}
		else if($data['event'][0]->ftime != $ftime) {
		$event_change=array('event_id'=>$event_id,'field'=>8,'old_value'=>$data['event'][0]->ftime,'user_id'=>$editor);
		$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);
		$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>8);
		$activity=$this->get_event_posts_display->insert_new_activity($data1);
		}
		
		if($data['event'][0]->desc != $this->input->post('e_desc')) {
		$event_change=array('event_id'=>$event_id,'field'=>10,'old_value'=>'','user_id'=>$editor);
		$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);
		$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>10);
		$activity=$this->get_event_posts_display->insert_new_activity($data1);
		}
		if($data['event'][0]->event_public != $e_pub) {
		$event_change=array('event_id'=>$event_id,'field'=>11,'old_value'=>$data['event'][0]->event_public,'user_id'=>$editor);
		$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);
		$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>11);
		$activity=$this->get_event_posts_display->insert_new_activity($data1);
		}
		/////////////////////////////////////////////////////////////////
		
		////////////////////////////////////////////////////////////////
		$this->load->model('get_organisers');		
		$data['organisers'] = $this->get_organisers->get_by_event_id($event_id);
		//number of organisers
		$number= $this->get_organisers->number_of_organiser($event_id);
		//$flag will check whether organizer details are changed or not
		$flag=0;
		if ($this->input->post('num_org')!=$number) {
		$event_change=array('event_id'=>$event_id,'field'=>13,'old_value'=>'','user_id'=>$editor);
		$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);
		$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>13);
		$activity=$this->get_event_posts_display->insert_new_activity($data1);
		}
		else {
		for($i=0;$i<$this->input->post('num_org');$i++)
			{
				if($this->input->post('orgName'.$i)!="" && $this->input->post('orgName'.$i)!= $data['organisers'][$i]->Name){
					$flag=1;
					break;
				}
				if($this->input->post('orgDesc'.$i)!="" && $this->input->post('orgDesc'.$i)!= $data['organisers'][$i]->Description){	
					$flag=1;
					break;
				}
			}
			if($flag==1) {
			$event_change=array('event_id'=>$event_id,'field'=>13,'old_value'=>'','user_id'=>$editor);
			$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);
			$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>13);
			$activity=$this->get_event_posts_display->insert_new_activity($data1);
			}
		}
		/////////////////////////////////////////////////////////////////
		
		////////////////////////////////////////////////////////////////
		$this->load->model('get_links');
		$data['links'] = $this->get_links->get_by_event_id($event_id);
		//number of links
		$number= $this->get_links->number_of_links($event_id);
		//$flag will check whether organizer details are changed or not
		$flag=0;
		if ($this->input->post('num_links')!=$number) {
		$event_change=array('event_id'=>$event_id,'field'=>14,'old_value'=>'','user_id'=>$editor);
		$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);		
		$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>14);
		$activity=$this->get_event_posts_display->insert_new_activity($data1);
		}
		else {
			for($i=0;$i<$this->input->post('num_links');$i++)
			{	
				if($this->input->post('link'.$i)!=$data['links'][$i]->link){
					$flag=1;
					break;
				}
				if($this->input->post('detLink'.$i)!= $data['links'][$i]->link_detail){
					$flag=1;
					break;
				}
			}
			if($flag==1) {
			$event_change=array('event_id'=>$event_id,'field'=>14,'old_value'=>'','user_id'=>$editor);
			$event_ch_id=$this->get_event_edit_history->insert_new_activity($event_change);
			$data1=array('table_name'=>1,'activity_id'=>$event_ch_id,'activity_type'=>14);
			$activity=$this->get_event_posts_display->insert_new_activity($data1);
			}
		}
	}
	public function EditEvent($event_id){                               ///////////// save the changes in event   //////////////
		if(!$this->session->userdata('is_logged_in'))
		return false;
		
		if(!$this->can_edit($this->session->userdata('user_id'),$event_id))
		return false;
		$this->load->library('form_validation');                           ///////////////// user for form validation //////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$this->form_validation->set_rules('e_title','Title','required|trim');
		$this->form_validation->set_rules('e_location','Location','required|trim');
		$this->form_validation->set_rules('e_city','City','required|trim');
		$this->form_validation->set_rules('e_type','Type','required|trim');
		$this->form_validation->set_rules('e_s_date','S_date','required|trim');
		$this->form_validation->set_rules('e_s_time','S_time','required|trim');
		$this->form_validation->set_rules('e_f_date','F_date','trim');
		$this->form_validation->set_rules('e_f_time','F_time','trim');
		$this->form_validation->set_rules('e_desc','Description','required|trim');
		if($this->input->post('e_public')){ $e_pub='1';} else { $e_pub='0'; }
		if($this->input->post('e_access')){ $e_acc='1';} else { $e_acc='0'; }	
		$this->form_validation->set_rules('num_org','organisers','trim');
		$this->form_validation->set_rules('num_link','links','trim');
		if($this->form_validation->run()){
			$this->load->model("get_events");
			if($this->input->post('e_f_date')) {
				$fdate=convertdate($this->input->post('e_f_date'));
			} else {
				$fdate="";
			}
			if($this->input->post('e_f_time')) {
				$ftime=converttime($this->input->post('e_f_time'));
			} else {
				$ftime="";
			}
			$this->CheckEventChanges($event_id);
			$new=array(
				"title" =>  $this->input->post('e_title'),
				"city" =>  $this->input->post('e_city'),
				"location" =>  $this->input->post('e_location'),
				"type" =>  $this->input->post('e_type'),
				"sdate" =>  convertdate($this->input->post('e_s_date')),
				"stime" =>  converttime($this->input->post('e_s_time')),
				"fdate" =>  $fdate,
				"ftime" =>  $ftime,
				"desc" =>  $this->input->post('e_desc'),
				"event_public" =>  $e_pub,
				"approved" => 'y',
			);
			//////////////////////////////////////////////////////////////////////////
			$this->get_events->update($new,$event_id);
			$this->load->model("get_organisers");
			$org=array();
			
			for($i=0;$i<$this->input->post('num_org');$i++)
			{
				if($this->input->post('orgName'.$i)!=""){	
					array_push($org,array(
						"name"=>$this->input->post('orgName'.$i),
						"Description"=>$this->input->post('orgDesc'.$i),
						"User_Id"=>$this->input->post('orgId'.$i),
						"Event_Id"=>$event_id,
					));
				}
			}
			
			$this->get_organisers->delete($event_id);
			if($org)
			$this->get_organisers->add($org);
			//////////////////////////////////////////////////////////////////////////
			
			//////////////////////////////////////////////////////////////////////////
			
			$this->load->model("get_links");
			$links=array();
			for($i=0;$i<$this->input->post('num_links');$i++)
			{	
				if($this->input->post('link'.$i)!=""){	
					if($this->input->post('detLink'.$i)!=""){
						array_push($links,array(
							"link"=>$this->input->post('link'.$i),
							"link_detail" => $this->input->post('detLink'.$i),
							"event_id"=>$event_id
						));
					}
					else{
						array_push($links,array(
							"link"=>$this->input->post('link'.$i),
							"link_detail" => $this->input->post('link'.$i),
							"event_id"=>$event_id
						));
					}
				}
				
			}
			print_r($links);
			$this->get_links->delete($event_id);
			if($links)
			$this->get_links->add($links);
			//////////////////////////////////////////////////////////////////////////
			redirect("site/events/".$event_id);
		}
		else{
			$error="The form has not been filled properly";
			echo $error;
			//redirect("site/createEventFail",$error);
			redirect("site/events/".$event_id);

		}
	}
	public function editHash($str,$event_id){                           /////////////  edit hashtag of event      //////////////
		
		
		if(!$this->session->userdata('is_logged_in'))
		return false;

		if(!$this->can_edit($this->session->userdata('user_id'),$event_id))
		return false;
		
		if($str!=""){
			
			$this->load->model('get_hash');
			$new=array("hashtag" => $str);
			$hash_id = $this->get_hash->get_hash_id($new);			
			echo $str;
			$this->load->model('get_tagPost');
			$this->get_tagPost->update($hash_id,$event_id,3);
		}
	}
	public function EditEventPic($event_id,$pic){                       ///////////// cahnge dissplay pic of event//////////////
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$this->load->helper('file');
		if(file_exists('./images/eventlogos/'.$pic))unlink('./images/eventlogos/'.$pic);
		if(!$this->can_edit($this->session->userdata('user_id'),$event_id)) return false;
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$config['upload_path'] = './images/eventlogos';                    ///////////////// upload the image for the event
		$config['allowed_types'] = 'gif|jpg|png';
		
		$config['max_size']	= '2048';
		if($pic=="noevent.jpg")
			$config['encrypt_name']  = true;
		else { 
			$config['encrypt_name']  = false;
			$config['file_name'] = $pic;
		}
		$this->load->library('upload', $config);
		$logo="";
		if ( ! $this->upload->do_upload('file'))
		{	
			$data = array('error' => $this->upload->display_errors());	
			$logo = 'noevent.jpg';
			echo 'dasds';
			redirect("site/ImageUploadingFailed/".$event_id);			
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());	
			$logo=$data['upload_data']['file_name'];                           ///////////////// event logo/image name for database
			if($pic=="noevent.jpg"){
			$new = array("event_logo" => $logo);
			$this->load->model('get_events');
			$this->get_events->update($new,$event_id);
			}
			redirect("site/events/".$event_id);
		}
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	}		
	public function few_going($event){                                  ///////////// get few names of guests     //////////////
		if(!$this->session->userdata('is_logged_in'))
		return false;
		
		$this->load->model('get_guests');
		$data['event']=$event;		
		$data['few']=$this->get_guests->few_going($event);
		$data['num']=$this->get_guests->num($event);
		$this->load->view('home/request/few_going',$data);
	}
	public function can_edit($user,$event){                             //////////// return true if organiser or creator////////
		
		$this->load->model('get_events');
		$this->load->model('get_organisers');
		if($this->get_organisers->is_organiser($user,$event)||$this->get_events->is_creator($user,$event))
		{
			return true;
		}
	}
	public function createEvent(){                                      /////////////// create the event ///////////////////////

		if(!$this->session->userdata('is_logged_in'))
		redirect('users/login');
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$config['upload_path'] = './images/eventlogos';                    ///////////////// upload the image for the event
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '2048';
		$config['encrypt_name']  = true;
		$this->load->library('upload', $config);
		$logo="";
		if ( ! $this->upload->do_upload('file'))
		{	
			$data = array('error' => $this->upload->display_errors());	
			$logo = 'noevent.jpg';
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());	
			$logo=$data['upload_data']['file_name'];                           ///////////////// event logo/image name for database
		}
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		
		$this->load->library('form_validation');                           ///////////////// user for form validation //////////
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$this->form_validation->set_rules('hash','Hash','trim|xss_clean');
		$hash_id=0;
		if($this->form_validation->run()){
			if($this->input->post('hash')!=""){
				$this->load->model('get_hash');
				$new=array("hashtag" => $this->input->post('hash'));
				$hash_id = $this->get_hash->get_hash_id($new);                 /////////////////// event hashtag_id for the database
			}
		}
		else{ }
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$this->form_validation->set_rules('e_title','Title','required|trim');
		$this->form_validation->set_rules('e_location','Location','required|trim');
		$this->form_validation->set_rules('e_city','City','required|trim');
		$this->form_validation->set_rules('e_type','Type','required|trim');
		$this->form_validation->set_rules('e_s_date','S_date','required|trim');
		$this->form_validation->set_rules('e_s_time','S_time','required|trim');
		$this->form_validation->set_rules('e_f_date','F_date','trim');
		$this->form_validation->set_rules('e_f_time','F_time','trim');
		$this->form_validation->set_rules('e_desc','Description','required|trim');
		if($this->input->post('e_public')){ $e_pub='1';} else { $e_pub='0'; }
		if($this->input->post('e_access')){ $e_acc='1';} else { $e_acc='0'; }	
		$this->form_validation->set_rules('num_org','organisers','trim');
		$this->form_validation->set_rules('num_link','links','trim');
		if($this->form_validation->run()){
			$this->load->model("get_events");
			if($this->input->post('e_f_date')) {
				$fdate=convertdate($this->input->post('e_f_date'));
			} else {
				$fdate="";
			}
			if($this->input->post('e_f_time')) {
				$ftime=converttime($this->input->post('e_f_time'));
			} else {
				$ftime="";
				}
			$created_time = date('Y/m/d h:i:s a', time());
			$new=array(
				"creator" => $this->session->userdata('user_id'),
				"title" =>  $this->input->post('e_title'),
				"location" =>  $this->input->post('e_location'),
				"city" =>  $this->input->post('e_city'),
				"sdate" =>  convertdate($this->input->post('e_s_date')),
				"stime" =>  converttime($this->input->post('e_s_time')),
				"fdate" =>  $fdate,
				"ftime" =>  $ftime,
				"desc" =>  $this->input->post('e_desc'),
				"event_public" =>  $e_pub,
				"event_logo" =>  $logo,
				"created_time" => $created_time,
				"approved" => 'y',
				"type" => $this->input->post('e_type')
			);
			//////////////////////////////////////////////////////////////////////////
			$event_id=$this->get_events->create($new);
			echo $event_id;
			$this->load->model("get_organisers");
			$org=array();
			echo $this->input->post('num_org');
			for($i=0;$i<$this->input->post('num_org');$i++)
			{
				$orgid=$this->input->post('orgId'.$i);
				if($this->input->post('orgName'.$i)&&$event_id)
				if(!$orgid)
				$orgid=0;
				array_push($org,array(
					"name"=>$this->input->post('orgName'.$i),
					"Description"=>$this->input->post('orgDesc'.$i),
					"User_Id"=>$orgid,
					"Event_Id"=>$event_id,
				));
			}
			
			if($org)
			$this->get_organisers->add($org);
			//////////////////////////////////////////////////////////////////////////
			
			
			
			//////////////////////////////////////////////////////////////////////////
			$this->load->model("get_tagPost");
			$hashrow=array("tags_id"=>$hash_id,"type"=>3,"parent_id"=>$event_id);
			$this->get_tagPost->insert($hashrow);
			//////////////////////////////////////////////////////////////////////////
			
			
			
			//////////////////////////////////////////////////////////////////////////
			$this->load->model("get_links");
			$links=array();
			for($i=0;$i<$this->input->post('num_link');$i++)
			{	
				
				if($this->input->post('link'.$i)!="")array_push($links,array(
					"link"=>$this->input->post('link'.$i),
					"link_detail" => $this->input->post('detLink'.$i),
					"event_id"=>$event_id,
				));
			}
			if($links)
			$this->get_links->add($links);
			//print_r($links);
			//////////////////////////////////////////////////////////////////////////
			redirect("site/events/".$event_id);
		}
		else{
			$error="The form has not been filled properly";
			echo $error;
			redirect("site/createEventFail",$error);
		}
		
	}
	public function addPost($comment,$event_id,$type){
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$this->load->model('get_event_posts');
		$user=$this->session->userdata('user_id');
		$data=array('Events_id'=>$event_id , 'Type' => $type , 'Content' => $comment , 'Unique_user_id' => $user );
		$comment=addslashes($comment);
		$activity_id=$this->get_event_posts->insert_new_post($data);
		$postdata['posts']=$this->get_event_posts->get_post_by_id($activity_id);
		$this->load->model('get_event_posts_display');
		
		$data=array('table_name'=>2,'activity_id'=>$activity_id,'activity_type'=>1);
		$postdata['activity']=$this->get_event_posts_display->insert_new_activity($data);
		$this->load->view('event/request/newPost',$postdata);
	}
	public function like($parent,$type){
		
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$this->load->model('get_likes');
		$data=array('parent_id'=>$parent,'like_type'=>$type,'unique_user_id'=>$this->session->userdata('user_id'));
		$this->get_likes->like($data);
		
	}
	public function getComment($parent,$type){
		
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$this->load->model('get_comments');
		$data['comments']=$this->get_comments->get_by_id($parent,$type);
		
		$data['post_id']=$parent;
		$this->load->view('event/request/comment',$data);
	}
	public function comment($parent,$type,$content){
	
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$this->load->model('get_comments');
		$data=array('parent_id'=>$parent,'comment_type'=>$type,'unique_user_id'=>$this->session->userdata('user_id'),'comment'=>$content);
		print_r($data);
		$this->get_comments->comment($data);
	}
	public function get_like($parent,$type){
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$this->load->model('get_likes');
		$likes=$this->get_likes->get_num_of_likes($parent,$type);
		echo "<span id='liked_".$parent."_".$type."'>".$likes."</span>";
	}
	public function createPoll($event_id){                              /////////////// create the poll ///////////////////////
		if(!$this->session->userdata('is_logged_in'))
		redirect('users/login');
		$this->load->library('form_validation');                           ///////////////// user for form validation //////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$this->form_validation->set_rules('poll_ques','Question','required|trim');
		$this->form_validation->set_rules('poll_type','Type','required|trim');
		$this->form_validation->set_rules('poll_restriction','Poll_Restriction','required|trim');
		$this->form_validation->set_rules('num_opt','options','trim');
		if($this->form_validation->run()){
			$this->load->model("get_event_posts");
			if($this->input->post('poll_type')==0 && $this->input->post('poll_restriction')==0) { //single choice, only poster can add option
				$ptype=1;
			} else if($this->input->post('poll_type')==1 && $this->input->post('poll_restriction')==0){ //multiple choice, only poster can add option
				$ptype=2;
			} else if($this->input->post('poll_type')==1 && $this->input->post('poll_restriction')==1){ //multiple choice, anyone can add option
				$ptype=3;
			} else {   //single choice, anyone can add option
				$ptype=4;
			}
			
			$user=$this->session->userdata('user_id');
			$data=array('Events_id'=>$event_id , 'Type' => $ptype , 'Content' => $this->input->post('poll_ques') , 'Unique_user_id' => $user );
			$poll_id=$this->get_event_posts->insert_new_post($data);
			//////////////////////////////////////////////////////////////////////////
			echo $poll_id;
			// Adding options of poll
			$this->load->model("get_poll_options");
			$opt=array();
			echo $this->input->post('num_opt');
			for($i=0;$i<$this->input->post('num_opt');$i++)
			{
				array_push($opt,array(
					"content"=>$this->input->post('option'.$i),
					"unique_user_Id"=>$user,
					"parent_Id"=>$poll_id,
					"option_type"=>3,
				));
			}
			
			if($opt)
			$this->get_poll_options->insert_new_option($opt);
			$this->load->model('get_event_posts_display');
			$data=array('table_name'=>2,'activity_id'=>$poll_id,'activity_type'=>6);
			$postdata['activity']=$this->get_event_posts_display->insert_new_activity($data);				
			//////////////////////////////////////////////////////////////////////////
			//print_r($links);
			//////////////////////////////////////////////////////////////////////////
			redirect("site/events/".$event_id);
		}
		else{
			$error="The form has not been filled properly";
			echo $error;
			redirect("site/createPollFail",$error);
		}
		
	}
}