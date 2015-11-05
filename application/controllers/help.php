<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends CI_Controller {
	
	public function getNewOrganiserColumn($k){                                 ///////////////// get new organiser column to add organiser///
		$data['k']=$k;
		$this->load->view("event/request/addMoreOrganisers",$data);
	}
	
	public function hash_by_event_id($event){                                  ///////////// get hash through the event_id     //////////////
		if(!$this->session->userdata('is_logged_in'))
		return false;
		
		$this->load->model('get_tagPost');
		
		$hashtag = $this->get_tagPost->get_by_event_id($event);
		foreach ($hashtag as $h)
		{
			echo "#".$h->hashtag;
		}
	}
	
	public function city_by_id($city){                                         ////////////// get city name by city id //////////////////////
		if(!$this->session->userdata('is_logged_in'))
		return false;
		
		$this->load->model('get_city');
		
		$city = $this->get_city->get_by_id($city);
		foreach ($city as $c)
		{
			echo $c->city;
		}
	}
	
	public function post_by_id($id,$type){                                  ////////// get post/poll through the activity_id of event_post_display /////////
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$this->load->model('get_event_posts');
		$data['posts']=$this->get_event_posts->get_post_by_id($id);
		$data['type']=$type;
		$this->load->view('event/request/posts',$data);
	}
	public function get_poll_option($id,$type){                                  ///////// get option through the poll_id ////////
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$this->load->model('get_poll_options');
		$data['options']=$this->get_poll_options->get_poll_option($id);
		$data['type']=$type;
		$this->load->view('event/request/options',$data);
	}

	public function edit_history_by_id($id,$type){                           /////// get change in event by the event_id as recent activity /////////
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$this->load->model('get_event_edit_history');
		$data['posts']=$this->get_event_edit_history->get_post_by_id($id);
		$data['type']=$type;
		$this->load->view('event/request/posts',$data);
	}
	
	public function get_new_option($id,$type,$cont){                           /////// get change in event by the event_id as recent activity /////////
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$this->load->model('get_poll_options');
		$new=array('unique_user_id'=>$this->session->userdata('user_id'),'content'=>$cont,'option_type'=>$type,'parent_id'=>$id);
		$data['option']=$this->get_poll_options->get_new_option($new);
		$data['type']=$type;
		$data['parent_id']=$id;
		$data['content']=$cont;
		$this->load->view('event/request/newoption',$data);
	}
}