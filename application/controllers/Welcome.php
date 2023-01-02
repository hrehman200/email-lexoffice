<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public  function __construct()
	{
		parent::__construct();

		$this->load->model('UserModel');
	}

	public function index()
	{
		$html = $this->load->view('auth/create_user', [], true);
		$this->load->view('layout', ['content' => $html]);
	}

	public function loginView()
	{
		$html = $this->load->view('auth/login', [], true);
		$this->load->view('layout', ['content' => $html]);
	}
	public function dashboard()
	{
		if(!$_SESSION['name']) {
			redirect('auth/signin');
		}
		$user = $this->UserModel->get($_SESSION['userId']);
		$html = $this->load->view('dashboard', ['user' => $user], true);
		$this->load->view('layout', ['content' => $html]);
	}

	public function signin()
	{

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$_SESSION['login_error'] = true;
			$this->loginView();
		} else {
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$data = array('email' => $email, 'password' => sha1($password));
			$res = $this->UserModel->checkSignin($data);
			if ($res) {
				$status = $res->status;
				$name   = $res->name;
				$id     = $res->id;
				if ($status == 1) {
					$_SESSION['userId'] = $id;
					$_SESSION['name'] = $name;
					$this->dashboard();
				} else {
					$_SESSION['account_not_active'] = "Failed! Your account is not active";
					$this->loginView();
				}
			} else {
				$_SESSION['no_record_found'] = "Failed! Please enter correct detail";
				$this->loginView();
			}
		}
	}

	public function logout()
	{
		unset($_SESSION);
		session_destroy();
		$this->loginView();
	}


	public function createUser()
	{
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('company', 'Company', 'required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('address', 'Address', 'required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('city', 'City', 'required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('zip', 'Zip', 'required|min_length[3]|max_length[20]');
		$this->form_validation->set_rules('country', 'Country', 'required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');
		$this->form_validation->set_rules('trader', 'Trader', 'required');

		if ($this->form_validation->run() == FALSE) {
			$_SESSION['error'] = true;
			$this->index();
		} else {
			$token = bin2hex(random_bytes(15));
			$data = array(
				'name' => $this->input->post('name'),
				'company' => $this->input->post('company'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'last_name' => $this->input->post('last_name'),
				'zip' => $this->input->post('zip'),
				'country' => $this->input->post('country'),
				'email' => $this->input->post('email'),
				'password' => sha1($this->input->post('password')),
				'verification_code' => $token,
				'status' => 0,
				'trader' => $this->input->post('trader') ? $this->input->post('trader') : 0,
			);
			$email_id = $this->input->post('email');
			$user_name = $this->input->post('name');
			if ($this->UserModel->insertData($data)) {

				$to = $email_id;
				$subject = 'Email-Invoice.de Account Activation';
				$body = sprintf("Hi <b>%s</b>, <br><br> Click the following link to activate your account <br><br> %s",  $user_name, base_url().'activate/account/'.$token);

				$this->sendMail($to, $subject, $body);
				$_SESSION['activation_pending'] = "Alert! Check your email to activate your account";
				$this->loginView();
			} else {
				echo 'have a prob';
			}
		}
	}


	public function accountActivate($token)
	{
		$res = $this->UserModel->activateAccount($token);
		if ($res) {
			$user = $this->UserModel->getByToken($token);
			$to = 'lange@75marketing.net';
			$subject = 'New User Activated on Email-Invoice.de';
			$details = '<b>Name:</b> : ' . $user['name'] . ' ' . $user['last_name'] . '<br>
			<b>Company:</b> : ' . $user['company'] . '<br>
			<b>Email:</b> : ' . $user['email'];
			$body = sprintf("Hi <b>Admin</b>, <br><br> A new user with following details signed up: <br><br> %s",  $details);
			$this->sendMail($to, $subject, $body);

			$_SESSION['activation_success'] = "Erfolgreich! Ihr Konto ist jetzt akti";
			redirect('auth/signin');
		}
	}

	private function sendMail($to, $subject, $body) {
		$this->load->library('email');
		$config = array(
			'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
			'smtp_host' => IMAP_HOST,
			'smtp_auth' => true,
			'smtp_port' => 587,
			'smtp_user' => IMAP_USERNAME,
			'smtp_pass' => IMAP_PASS,
			//'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
			'mailtype' => 'html', //plaintext 'text' mails or 'html'
			'smtp_timeout' => '5', //in seconds
			'charset' => 'utf-8',
			'wordwrap' => TRUE
		);

		$this->email->initialize($config);

		$this->email->from('no-reply@email-invoice.de', 'Email-Invoice Support');
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($body);
		$this->email->send();
		// var_dump($this->email->print_debugger());
	}


	public function lexDetail()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('lexapikey', 'LexApiKey', 'required');

		if ($this->form_validation->run() == FALSE) {
			$_SESSION['lex_error'] = true;
			$this->dashboard();
		} else {
			$lex_api_key = $this->input->post('lexapikey');
			$verified = $this->UserModel->checkLexApiKey($lex_api_key);

			if ($verified) {
				$user = $this->UserModel->get($_SESSION['userId']);

				$data = array('lex_api_key' => $lex_api_key);
				if(!$user['lex_email']) {
					$lex_email = sprintf('%s@email-invoice.de', random_string('alnum', 6));
					$data['lex_email'] = $lex_email;
					$user['lex_email'] = $lex_email;
				}

				// create customer on client's lex
				$this->UserModel->createCustomerOnLex($_SESSION['userId']);

				$res = $this->UserModel->updLexDetail($data, $_SESSION['userId']);
				$_SESSION['lex_detail_update_success'] = 'Lex API Key added';

				$to = $user['email'];
				$subject = 'Email-Invoice.de LexOffice API Key Added';
				$body = sprintf("Hi <b>%s</b>, <br><br> 
				Your LexOffice API key has been added into our app. You can now share this email address <b>%s</b> with your suppliers.<br>
				Any invoice that is sent by your supplier to <b>%s</b> will be uploaded by our app to your LexOffice dashboard. <br><br>
				Regards, <br>
				Email-Invoice.de Support",  $user['name'], $user['lex_email'], $user['lex_email']);

				$this->sendMail($to, $subject, $body);	

			} else {
				$this->session->set_flashdata('lex_detail_update_error', 'Lex API key not valid');
			}
			redirect("dashboard");
		}
	}


	public function forgotpassword(){
		$html = $this->load->view('auth/forgotPasswrod', [], true);
		$this->load->view('layout', ['content' => $html]);
	}

	public function revoverPasswordView(){
		$html = $this->load->view('auth/revoverPassword', [], true);
		$this->load->view('layout', ['content' => $html]);
	}
	public function revoverPassword(){
		$email = $this->input->post('email');
		$check_email_exist = $this->UserModel->check_email_exist($email);
		if ($check_email_exist) {
			$token = bin2hex(random_bytes(15));
			$id = $check_email_exist->id;
			$email = $check_email_exist->email;
			$data = array('forgot_pass_code' => $token);
			$update_pass_recover_code = $this->UserModel->updatePasswordRevoverCode($id,$data);
			if ($update_pass_recover_code) {
				$to = $email;
				$subject = 'Forgot Password';
				$body = sprintf("Hi <b>%s</b>, <br><br> Click the following link to reset your password <br><br> %s",  $user_name, base_url().'user/revover/password/'.$token);

				$this->sendMail($to, $subject, $body);

				$_SESSION['code_sent'] = "Password reset instructions sent to your email";
				$this->forgotpassword();
			}
		}else{
			$_SESSION['no_email_found'] = "No email found";
			$this->forgotpassword();
		}
	}


	public function passwordRecoverView($token)
	{
		$res = $this->UserModel->check_token_exist($token);
		if ($res) {
			$id = $res->id;
			$data['id'] = $id;
			$html = $this->load->view('auth/recoverPassword',$data, true);
			$this->load->view('layout', ['content' => $html]);
		}else{
			//no token exist
		}
	}

	public function updatePassword(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('conf_pass', 'Password Confirmation', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			$_SESSION['update_pass_error'] = true;
			$this->revoverPasswordView();
		}else{
			$id = $this->input->post('id');
			$password = $this->input->post('password');
			$data = array('password' => sha1($password));
			$res = $this->UserModel->updatePassword($id,$data);
			if ($res) {
				$_SESSION['password_updata'] = "Succes! Password updated successfully";
				$this->loginView();
			}
		}
	}
}
