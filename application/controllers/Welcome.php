<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';


class Welcome extends CI_Controller
{

	public function index($video_id = null)
	{
		print_r($video_id);
		$html = $this->load->view('auth/create_user', [], true);
		$this->load->view('layout', ['content' => $html]);
	}

	public function loginView($video_id = null)
	{
		print_r($video_id);
		$html = $this->load->view('auth/login', [], true);
		$this->load->view('layout', ['content' => $html]);
	}
	public function dashboard($video_id = null)
	{
		print_r($video_id);
		$html = $this->load->view('dashboard', [], true);
		$this->load->view('layout', ['content' => $html]);
	}

	public function signin()
	{	
		$this->load->model('UserModel');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');            
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE){
               $_SESSION['login_error'] = true;
               $this->loginView();
        }
        else
        {
        	$email = $this->input->post('email');
        	$password = $this->input->post('password');
        	$data = array('email' => $email, 'password' => $password);
        	$res = $this->UserModel->checkSignin($data);
        	if ($res) {
        		$status = $res->status;
        		$name   = $res->name;
        		$id     = $res->id;
        		if ($status == 1) {
        			$_SESSION['userId'] = $id;
        			$_SESSION['name'] = $name;
        			$this->dashboard();
        		}else{
        			$_SESSION['account_not_active'] = "Failed! Your account is not active";
        			$this->loginView();
        		}
        		
        	}else{
        		$_SESSION['no_record_found'] = "Failed! Please enter correct detail";
        		$this->loginView();
        	}
        }
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
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');            
        $this->form_validation->set_rules('password', 'Password', 'required');
	 $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');



        if ($this->form_validation->run() == FALSE){
        	$_SESSION['error'] = true;
               $this->index();

        }
        else
        {
          	$token = bin2hex(random_bytes(15));
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
        		'verification_code' => $token,
        		'status' => 0,

        	);
        	$email_id = $this->input->post('email');
        	$user_name = $this->input->post('name');
             if ($this->UserModel->insertData($data)) { 
             		$this->load->library('email');
		        $config = array();

		        $config['protocol'] = "smtp";
		        $config['smtp_host'] = "ssl://smtp.gmail.com";
		        $config['smtp_port'] = "465";
		        $config['smtp_user'] = "sohailafridy99@gmail.com";
		        $config['smtp_pass'] = "oiiockwealavuwui";
		        $config['charset'] = "utf-8";
		        $config['mailtype'] = "html";
		        $config['newline'] = "\r\n";

		        $this->email->initialize($config);
		        $this->email->set_newline("\r\n");

		        $this->email->from('sohail.it99@gmail.com', 'Your Name');
		        $this->email->to($email_id);

			$this->email->subject('Account Activation');
			$this->email->message("Hi,".$user_name."click here to activate your account http://localhost/ci3-email/activate/account/".$token);

			if($this->email->send()){
				$_SESSION['activation_pending'] = "Alert! Check your email to activate your account";
				$this->loginView();
			}
		}else{
                    echo 'have a prob';
                }   

        }
	}

	public function logout(){
		session_destroy();
		$this->index();
	}

	public function accountActivate($token){
		$this->load->model('UserModel');
		$res = $this->UserModel->activateAccount($token);
		if ($res) {
			$_SESSION['activation_success'] = "Success! Your account is active now";
			$this->loginView();
		}
	}


	public function lexDetail(){
		$this->load->model('UserModel');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('lexapikey', 'LexApiKey', 'required');            
        $this->form_validation->set_rules('lex_email', 'LexEmail', 'required|valid_email');

        if ($this->form_validation->run() == FALSE){
               $_SESSION['lex_error'] = true;
               $this->dashboard();
        }
        else
        {
        	$lexapikey = $this->input->post('lexapikey');
		$lex_email = $this->input->post('lex_email');
		$id = $this->input->post('userid');

		$data = array('lex_api_key' => $lexapikey, 'lex_email' => $lex_email);
		$res = $this->UserModel->updLexDetail($data,$id);
		if ($res) {
			$_SESSION['lex_detail_update_success'] = "Success! Lex detail updated successfully";
			$this->dashboard();
		}else{
			$_SESSION['lex_detail_update_error'] = "Failed! Your have some problem";
			$this->dashboard();
		}	
        }
    }


	
}
