<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';


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
		$this->form_validation->set_rules('state', 'State', 'required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('zip', 'Zip', 'required|min_length[3]|max_length[20]');
		$this->form_validation->set_rules('country', 'Country', 'required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');

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
				$config = array(
					'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
					'smtp_host' => 'smtp.gmail.com',
					'smtp_port' => 465,
					'smtp_user' => 'no-reply@example.com',
					'smtp_pass' => '12345!',
					'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
					'mailtype' => 'text', //plaintext 'text' mails or 'html'
					'smtp_timeout' => '4', //in seconds
					'charset' => 'iso-8859-1',
					'wordwrap' => TRUE
				);

				$this->email->initialize($config);

				$this->email->from('your@example.com', 'Your Name');
				$this->email->to($email_id);

				$this->email->subject('Account Activation');
				$this->email->message("Hi," . $user_name . "click here to activate your account http://localhost/email-lexoffice/activate/account/" . $token);

				if ($this->email->send()) {
					$_SESSION['activation_pending'] = "Alert! Check your email to activate your account";
				}
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
			$_SESSION['activation_success'] = "Success! Your account is active now";
			$this->loginView();
		}
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
				}

				// create customer on client's lex
				$this->UserModel->createCustomerOnLex($_SESSION['userId']);

				$res = $this->UserModel->updLexDetail($data, $_SESSION['userId']);
				$_SESSION['lex_detail_update_success'] = 'Lex API Key added';
			} else {
				$this->session->set_flashdata('lex_detail_update_error', 'Lex API key not valid');
			}
			redirect("dashboard");
		}
	}
}
