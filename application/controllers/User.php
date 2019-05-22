<?php
if(!defined('BASEPATH')){ exit('You dont have direct access of this page...'); }

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function login(){
		if($this->session->userdata('IsUserLoggedIn') == true ){
			redirect('Contact/');
		}
		
		$this->load->view('login');
	}

	// Function to register user
	function registration(){
		$this->load->view('registration');
	}
	
	// function to save user details
	function save_user_details(){
		
		// check form submitted, we can add hereserver side valisations also
		if($this->input->post('full_name')){
			
			// get the details
			$data['full_name'] = trim($this->input->post('full_name'));
			$data['email_id'] = trim($this->input->post('email_id'));
			$data['password'] = md5(trim($this->input->post('password')));
			
			//date and time
			date_default_timezone_set('Asia/Calcutta');
			$timeStamp=date("Y-m-d H:i:s");
			$data['date_time'] = $timeStamp;
			
			// check user already exist or not
			$udata = $this->Contact_model->custom_query("SELECT * FROM hl_user_details WHERE email_id='".$data['email_id']."'");
		
			if(count($udata) > 0)
			{
				echo json_encode(array('result'=>'Already Exists')); die;
			}else{
				
				// Insert
				$this->Contact_model->insert_data('hl_user_details', $data);		
				$user_id = $this->db->insert_id();
				
				if($user_id != ""){
					echo json_encode(array('result'=>'Success')); die;
				}else{
					echo json_encode(array('result'=>'Failure')); die;
				}
			}
			
		}else{
			// if not received any details send F and display message as something went wrong
			echo json_encode(array('result'=>'F')); die;
		}
	}
	
	
	// function to check login details
	public function login_auth()
	{
		$user_id = trim($this->input->post('user_id'));
        $password = md5(trim($this->input->post('password')));
		
		if($user_id!='' && $password!=''){
			
			$udata = $this->Contact_model->custom_query("SELECT * FROM hl_user_details WHERE email_id='".$user_id."' and password='".$password."'");		
			if(count($udata) > 0)
			{
				$this->session->set_userdata('IsUserLoggedIn','Yes');
				$this->session->set_userdata('user_id',$udata[0]['user_id']);
				$this->session->set_userdata('user_name',$udata[0]['full_name']);
				echo json_encode(array('result'=>'Yes'));
				die;
			}else{
				echo json_encode(array('result'=>'No'));
				die;
			}
		}else{
			echo json_encode(array('result'=>'No'));
			die;
		}	
	}
	
	// function to logout and distroy all session
	public function logout()
	{		
		$this->session->sess_destroy();	
		redirect('User/Login');
	}
	
}