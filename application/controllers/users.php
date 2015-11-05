<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller {
		
	public function index(){
		if($this->session->userdata('is_logged_in')){
			redirect('site/home');
		}
		else{
			redirect('users/login');
		}
	}
	public function login(){
		if($this->session->userdata('is_logged_in')){
			redirect('site/home');
		}
		else{
			$data['title']="Almashines Events - Creat organise and view events";
			$this->load->view("login/login",$data);
		}
	}
	public function loginProcess(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','Email','required|trim|xss_clean|callback_login_success');
		$this->form_validation->set_rules('password','Password','required|md5|trim');
		if($this->form_validation->run()){
			
			$this->load->model('get_users');
			$result=$this->get_users->get_by_mail($this->input->post('email'));
			$data=array(
				'user_name' => $result[0]->name,
				'user_id' => $result[0]->id,
				'user_image' => $result[0]->image,
				'user_email' => $this->input->post('email'),
				'is_logged_in' => 1
			);
			$this->session->set_userdata($data);
			redirect('site/home');
		}
		else{
			$data['Success']="KINDLY CHECK YOUR EMAIL AND PASSWORD";
			$this->load->view('login/login',$data);
		}
	}
	public function login_success(){
		$this->load->model('get_users');
		if($this->get_users->can_login()){
			return true;
		}
		else{
			$this->form_validation->set_message('login_success','incorrect email/password<br>Kindly login again with your correct password and username');
			return false;
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('users/login');
	}	
	public function register(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|trim|xss_clean');
		$this->form_validation->set_rules('email','Email','required|trim|xss_clean|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password','Password','required|trim');
		$this->form_validation->set_rules('cpassword','Confirm Password','required|trim|matches[password]');
		if($this->form_validation->run()){
			$config['upload_path'] = './images/users';                    ///////////////// upload the image for the event
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '2048';
			$config['encrypt_name']  = true;
			$this->load->library('upload', $config);
			$logo="";
			if ( ! $this->upload->do_upload('file'))
			{	
				$data = array('error' => $this->upload->display_errors());	
				$logo ='nouser.jpg';
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());	
				$logo=$data['upload_data']['file_name'];                           ///////////////// event logo/image name for database
			}
			$this->load->model("get_users");
			$new=array(
				"image" => $logo,
				"name" => $this->input->post('name'),
				"email" => $this->input->post('email'),
				"password" => md5($this->input->post('password'))
			);
			$this->get_users->register($new);
			$data['Success']="you have registerd successfully and now you can login to almashines ";
			$this->load->view("login/login",$data);				}
		else{
			$data['Success']="The form has not been filled properly";
			$this->load->view("login/login",$data);			
		}
	}	
	public function search($str){
		if(!$this->session->userdata('is_logged_in'))
		return false;
		$str=str_replace("%7B%7B%7D%7D"," ",$str);                    /////////////////// because " {{}} " is changed to "%7B%7B%7D%7D"		
		$this->load->model("get_users");
		$data['result']=$this->get_users->search($str);
		$this->load->view('home/request/users',$data);
	}
}