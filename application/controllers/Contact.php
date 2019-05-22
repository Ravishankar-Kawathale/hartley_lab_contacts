<?php
if(!defined('BASEPATH')){ exit('You dont have direct access of this page...'); }

class Contact extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('IsUserLoggedIn') != "Yes"){
			redirect('User/login/');
		}
	}
	
	// display conatact list created by logged in user, 
	function index(){
		$data['contact_list'] = $this->Contact_model->custom_query("SELECT * FROM user_contact_details where user_id='".$this->session->userdata['user_id']."' and delete_status = '0' order by contact_id desc");
		
		$data['page_name'] = $this->session->userdata('user_name').'\'s Contacts';
		$this->load->view('header',$data);
		$this->load->view('contact_list');
	}
	
	
	function create() {		
		$data['page_name'] = $this->session->userdata('user_name').'\'s Contacts';
		$this->load->view('header',$data);
		$this->load->view('create_contact');
		
	}
	
	
	// function to save details
	function save_contact_details(){
		
		if($this->input->post('first_name')){
			
			$data['user_id'] = trim($this->session->userdata('user_id'));
			$user_id = trim($this->session->userdata('user_id'));
			$data['first_name'] = trim($this->input->post('first_name'));
			$data['middle_name'] = trim($this->input->post('middle_name'));
			$data['last_name'] = trim($this->input->post('last_name'));
			$data['primary_phone'] = trim($this->input->post('primary_phone'));
			$data['secondary_phone'] = trim($this->input->post('secondary_phone'));
			$data['email_id'] = trim($this->input->post('email_id'));
			
			//date and time
			date_default_timezone_set('Asia/Calcutta');
			$timeStamp=date("Y-m-d H:i:s");
			$data['created_date_time'] = $timeStamp;
			
			// check already exist or not with email with same user id for now, we can check with any column or with combination
			$email_id = $data['email_id'];			
			$cdata = $this->Contact_model->custom_query("SELECT * FROM user_contact_details WHERE email_id='".$email_id."' and user_id='".$user_id."'");
		
			if(count($cdata) > 0)
			{
				echo json_encode(array('result'=>'Already Exist')); die;
			}else{
				// Insert in to contact_details
				$this->db->insert('user_contact_details', $data);
				$contact_id = $this->db->insert_id();
				
				if($contact_id != ""){					
					echo json_encode(array('result'=>'S')); die;
				}else{
					echo json_encode(array('result'=>'F')); die;
				}
			}
			
		}else{
			echo json_encode(array('result'=>'F')); die;
		}
	}
	
	
	// function to delete contact/ hide status
	function change_d_status(){
		
		$contact_id = trim($this->input->post('contact_id'));
		if($contact_id!=''){
			$data['delete_status'] = '1';
			$where = array('contact_id' => $contact_id);
			$this->db->where($where);			
			$this->db->update('user_contact_details', $data);
			echo json_encode(array('result'=>'S')); die;
		}
	}
	
	// function to display view to user to share contact
	function for_share(){
		//  get all user list in this system except current loggein user
		$data['user_list'] = $this->Contact_model->custom_query("SELECT * FROM hl_user_details where user_id!='".$this->session->userdata('user_id')."'");
		$contact_id = trim($this->input->post('contact_id'));
		$data['page_name'] = $this->session->userdata('user_name').'\'s Contacts';	
		$data['contact_id'] = $contact_id;		
		$this->load->view('for-share', $data);
	}
	
	
	
	// function to share contact, share selected conatct to selected multiple user
	function share_contact(){
		
		if($this->input->post('contact_id')){
			
			$data['shared_by_user'] = trim($this->session->userdata('user_id'));
			
			$data['contact_id'] = trim($this->input->post('contact_id'));
			
			//date and time
			date_default_timezone_set('Asia/Calcutta');
			$timeStamp=date("Y-m-d H:i:s");
			$data['shared_on'] = $timeStamp;
			// received selected users in array fomat, add new record for each selected user
			foreach($this->input->post('user') as $shared_with_user){
				$data['shared_with_user'] = $shared_with_user;
				$this->db->insert('user_shared_contacts', $data);
			}			
			echo json_encode(array('result'=>'S')); die;
			
		}else{
			echo json_encode(array('result'=>'F')); die;
		}
	}
	
	//  fucntion  to display shared conatcts by other users with you
	function shared_contacts(){
		// get list from DB
		$contact_list = $this->Contact_model->custom_query("SELECT * FROM user_shared_contacts where shared_with_user='".$this->session->userdata['user_id']."' order by id desc");
		// get details like, shared by user name and contact details
		/// we can user here  joins fot better performance
		for($i=0;$i<count($contact_list);$i++){
			
			$user_name = $this->Contact_model->custom_query("SELECT full_name FROM hl_user_details where user_id='".$contact_list[$i]['shared_by_user']."'");
			$contact_list[$i]['shared_by_name'] = $user_name[0]['full_name'];
			
			
			$contact_details = $this->Contact_model->custom_query("SELECT * FROM user_contact_details where contact_id='".$contact_list[$i]['contact_id']."'");
			$contact_list[$i]['first_name'] = $contact_details[0]['first_name'];
			$contact_list[$i]['middle_name'] = $contact_details[0]['middle_name'];
			$contact_list[$i]['last_name'] = $contact_details[0]['last_name'];
			$contact_list[$i]['primary_phone'] = $contact_details[0]['primary_phone'];
			$contact_list[$i]['secondary_phone'] = $contact_details[0]['secondary_phone'];
			$contact_list[$i]['email_id'] = $contact_details[0]['email_id'];
			
		}
		
		$data['page_name'] = $this->session->userdata('user_name').'\'s Contacts';
		$data['contact_list'] = $contact_list;
		$this->load->view('header',$data);
		$this->load->view('shared_list');
	}
	
	
    function export_vcf($contact_id = '')
    {       
		if($contact_id!=''){
			
			$user_details = $this->Contact_model->custom_query("SELECT * FROM user_contact_details where contact_id='".$contact_id."'");
			if(count($user_details) > 0){
				$card_data = array();
				$card_data['first_name'] = $user_details[0]['first_name'];
				$card_data['last_name'] = $user_details[0]['last_name'];
				$card_data['middle_name'] = $user_details[0]['middle_name'];				
				$card_data['nickname'] = $user_details[0]['first_name'];
				
				$card_data['secondary_phone'] = $user_details[0]['secondary_phone'];				
				$card_data['primary_phone'] = $user_details[0]['primary_phone'];				
				$card_data['email_id'] = $user_details[0]['email_id'];				
				$card_data['note'] = "From Ravishankar For Hartley Lab Machine Test..";			
				// load library (Downloded from github)
				$this->load->library('vcard');				
				// load card data
				$this->vcard->load($card_data);
				// generate string to write in file
				$string = $this->vcard->generate_string();
				// download file
				$this->vcard->generate_download('VCF_Hartley_Lab_Ravishankar.vcf');
			}
		}
    } 
    
}