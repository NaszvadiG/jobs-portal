<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('users_model');
        $this->load->library('session');
    }
	public function index()
	{
		$result['users'] = $this->users_model->get_user_details();
		//var_dump($result);
		$this->load->view('index',$result);
	}

	public function profile(){
        $user=$this->session->userdata('logged_in');
        if(!empty($user)){
            $data['user']=$user;
            $this->load->view('user/personalInfo',$data);
        }else{
            redirect(base_url());
        }
		//	
	}
    public function logout(){
        $user=$this->session->sess_destroy();
        redirect(base_url());
	}
	public function add_new_user(){

	/*	$this->input->post();    // Catch values form url via POST Method
		$this->input->get();                 // Catch values form url via GET Method
		$this->input->get_post();      // Search data first for POST then for GET. */

		  $form_data = $this->input->post();
	      // or just the username:
	     // $username = $this->input->post("username");
		  var_dump($form_data);

	      $data = array(
			'fname' => $this->input->post('fname'),
			'lname' => $this->input->post('lname') ,
	    	'gender' => $this->input->post('gender'),
	    	'address' => $this->input->post('address') );
	           var_dump($data);
	    	$this->users_model->add_new_user($data);
    		redirect(base_url(),'refresh');
	}
    
    public function login(){
        $user_name=$this->input->post('email');
        $password=$this->input->post('password');
        if($this->users_model->authenticate($user_name,$password)){
            redirect(base_url('profile'));
        }else{
            redirect(base_url());
        };
    }
    
    public function register(){
        $user_name=$this->input->post('email');
        $password=$this->input->post('password');
        if(!$this->users_model->check_email($user_name)){
            $this->users_model->register($user_name,$password);
        }else{
            redirect(base_url());
        };
    }


	
/*
	// Show form in view page i.e view_page.php
	public function form_show() {
	$this->load->view("view_form");
	}

	// When user submit data on view page, Then this function store data in array.
	public function data_submitted() {
	$data = array(
	'user_name' => $this->input->post('u_name'),
	'user_email_id' => $this->input->post('u_email')
	);

	// Show submitted data on view page again.
	$this->load->view("view_form", $data);
	} */
}
