<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';


class Signup extends CI_Controller
{

	public function index()
	{
		
	}
	public function createUser()
	{
		$this->load->model('UserModel');
		$this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('company', 'Company', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('zip', 'Zip', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');            
        $this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');



        if ($this->form_validation->run() == FALSE){
               print_r(validation_errors());
        }
        else
        {
          echo $verification_code = bin2hex(random_bytes(15));
        	$data = array(
        		'name' => $this->input->post('name'),
        		'company' => $this->input->post('company'),
        		'address' => $this->input->post('address'),
        		'city' => $this->input->post('city'),
        		'state' => $this->input->post('state'),
        		'zip' => $this->input->post('zip'),
        		'country' => $this->input->post('country'),
        		'email' => $this->input->post('email'),
        		'password' => $this->input->post('password'),
        		'verification_code' => $verification_code,
        		'status' => 0,

        	);
             if ($this->UserModel->insertData($data)) {
                     echo 'success';
                }else{
                    echo 'have a prob';
                }   

        }
	}
	
}
