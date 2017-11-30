<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class My_404 extends CI_Controller 
	{
		public function __construct() 
		{
			parent::__construct(); 
		} 

		public function index() 
		{ 
			$this->output->set_status_header('404');
			//assign page title name
			$data['pageTitle'] = 'Avenue 1-OH-1';	
			$data['content'] = 'error_404'; // View name 
			$this->load->view('pages/page_404',$data);//loading in my template 
		} 
	} 
