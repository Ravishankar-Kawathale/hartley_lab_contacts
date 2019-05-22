<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contact_model extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->database();	
	}
	
	function insert_data($table_name='',$data=array())
	{
		$this->db->insert($table_name,$data);			
	}
	
	public function select($fields,$table)
	{
		$this->db->select($fields); 
		$this->db->from($table);   
		return $this->db->get()->result_array();
	}
	
	function update($table,$where,$data)
	{
		$this->db->where($where);
		$this->db->update($table, $data); 
	}
	
	public function select_where($fields,$where,$table)
	{
		$this->db->select($fields); 
		$this->db->from($table);   
		$this->db->where($where);
		return $this->db->get()->result_array();
	}
	public function custom_query($query)
	{
		$ci = & get_instance();
		$arr = $ci->db->query($query);
		return $arr->result_array();
	}	
}