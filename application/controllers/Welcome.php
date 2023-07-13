<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
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
		if (!$_SESSION['name']) {
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
				$name = $res->name;
				$id = $res->id;
				if ($status == 1) {
					$_SESSION['userId'] = $id;
					$_SESSION['name'] = $name;
					$this->dashboard();
				} else {
					$_SESSION['account_not_active'] = "Fehlgeschlagen! Ihr Konto wurde nicht aktiviert";
					$this->loginView();
				}
			} else {
				$_SESSION['no_record_found'] = "Fehlgeschlagen! Bitte korrektes Detail eingeben";
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

		$this->form_validation->set_rules('name', 'Name', 'required|min_length[3]|max_length[100]', [
			'required' => 'Bitte füllen Sie das Feld Vorname aus.'
		]);
		$this->form_validation->set_rules('company', 'Firma', 'required|min_length[3]|max_length[100]', [
			'required' => 'Bitte füllen Sie das Feld Firma aus.'
		]);
		$this->form_validation->set_rules('address', 'Adresse', 'required|min_length[3]|max_length[100]', [
			'required' => 'Bitte füllen Sie das Feld Adresse aus.'
		]);
		$this->form_validation->set_rules('city', 'Ort', 'required|min_length[3]|max_length[100]', [
			'required' => 'Bitte füllen Sie das Feld Ort aus.'
		]);
		$this->form_validation->set_rules('last_name', 'Nachname', 'required|min_length[3]|max_length[100]', [
			'required' => 'Bitte füllen Sie das Feld Nachname aus.'
		]);
		$this->form_validation->set_rules('zip', 'PLZ', 'required|min_length[3]|max_length[20]', [
			'required' => 'Bitte füllen Sie das Feld PLZ aus.'
		]);
		$this->form_validation->set_rules('country', 'Land', 'required|min_length[3]|max_length[100]', [
			'required' => 'Bitte füllen Sie das Feld Land aus.'
		]);
		$this->form_validation->set_rules('email', 'Emaildresse', 'required|valid_email|is_unique[users.email]|min_length[3]|max_length[100]', [
			'required' => 'Bitte füllen Sie das Feld Emailadresse aus.'
		]);
		$this->form_validation->set_rules('password', 'Passwort', 'required|min_length[3]|max_length[100]', [
			'required' => 'Bitte füllen Sie das Feld Passwort aus.'
		]);
		$this->form_validation->set_rules('password_confirm', 'Passwort bestätigen', 'required|matches[password]', [
			'required' => 'Bitte füllen Sie das Passwort bestätigen Firma aus.'
		]);
		$this->form_validation->set_rules('trader', 'Trader', 'required', ['required' => 'Bitte Auftragsverarbeitungsvertrag, AGBs und Datenschutzerklärung zustimmen']);

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
				'timing' => $this->input->post('timing'),
			);
			$email_id = $this->input->post('email');
			$user_name = $this->input->post('name');
			if ($this->UserModel->insertData($data)) {


				$tariff = 'KOSTENLOS: in der Beta Testphase.
Vor dem Ende der Beta Testphase werden Sie rechtzeitig informiert und haben dann die Wahl ein kostenpflichtiges Abo für EMAIL INVOICE abzuschließen oder die Nutzung von EMAIL INVOICE zu beenden.';
				if ($user['timing'] == 2) {
					$tariff = 'Monatstarif: 8 EURO / Monat zzgl. MwSt 
Vertragslaufzeit 1 Monat: sollte der Vertrag bis 4 Wochen vor Ablauf der Vertragslaufzeit nicht gekündigt sein, verlängert sich der Vertrag automatisch um 1 Monat.';
				} else if ($user['timing'] == 3) {
					$tariff = 'Jahrestarif: 90 EURO / Jahr zzgl. MwSt 
Vertragslaufzeit 1 Jahr: sollte der Vertrag bis 4 Wochen vor Ablauf der Vertragslaufzeit nicht gekündigt sein, verlängert sich der Vertrag automatisch um 12 Monate.';
				}



				$to = $email_id;
				$subject = 'EMAIL INVOICE Konto-Aktivierung';
				$body = sprintf("Hallo %s, <br><br>Willkommen bei EMAIL INVOICE.<br>
				Klicken Sie auf den folgenden Link, um Ihr Konto zu aktivieren <br><br> %s
				<br><br>
				Nach Ihrem erfolgreichen Login haben Sie die Möglichkeit ihren persönliche lexoffice Public API Schlüssel online einzugeben.<br>
				Sie erhalten Ihre persönliche Emailadresse direkt nach der Eingabe und EMAIL INVOICE steht Ihnen in vollem Umfang zur Verfüfung.
				<br>
				Wo finde ich meinen persönliche lexoffice Public API Schlüssel?
				<br>
				https://app.lexoffice.de/addons/public-api
				<br>
				<br>
				Noch Fragen? Unsere FAQ finden Sie auf unserer Homepage: https://email-invoice.de/
				<br>
				<br>
				Ihr ausgewählter Tarif:<br>
				$tariff
				<br>
				<br>
				Mit freundlichem Gruß<br>
				<br>
				EMAIL INVOICE Support<br>
				Ulmenstraße 17<br>
				D-65527 Niedernhausen<br>
				Tel.: +49 (0) 06127 706982-0<br>
				USt-IdNr.: DE165054377<br>
				Inh.: Dipl. Kfm. Sören Lange<br>
				Email: hallo@email-invoice.de<br>
				Internet: email-invoice.de
				", $user_name, base_url() . 'activate/account/' . $token);

				$body = $this->load->view('emails/newuser', [
					'activation_link' => base_url() . 'activate/account/' . $token,
					'tariff' => $tariff
				], true);

				$this->sendMail($to, $subject, $body);
				$_SESSION['activation_pending'] = "Prüfen Sie Ihre Email, um Ihr Konto zu aktivieren.";
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

			$tariff = 'KOSTENLOS: in der Beta Testphase
Vor dem Ende der Beta Testphase werden Sie rechtzeitig informiert und haben dann die Wahl ein kostenpflichtiges Abo für EMAIL INVOICE abzuschließen oder die Nutzung von EMAIL INVOICE zu beenden.';
			if ($user['timing'] == 2) {
				$tariff = 'Monatstarif: 8 EURO / Monat zzgl. MwSt
Vertragslaufzeit 1 Monat: sollte der Vertrag bis 4 Wochen vor Ablauf der Vertragslaufzeit nicht gekündigt sein, verlängert sich der Vertrag automatisch um 1 Monat.';
			} else if ($user['timing'] == 3) {
				$tariff = 'Jahrestarif: 90 EURO / Jahr zzgl. MwSt
Vertragslaufzeit 1 Jahr: sollte der Vertrag bis 4 Wochen vor Ablauf der Vertragslaufzeit nicht gekündigt sein, verlängert sich der Vertrag automatisch um 12 Monate.';
			}

			$to = 'lange@75marketing.net';
			$subject = 'Neuer Kunde bei EMAIL-INVOICE';
			$details = 'Hi <b>Admin</b>,<br>
			<p>Ein neuer Kunde hat sich angemeldet:</p>
			<b>Name:</b> : ' . $user['name'] . ' ' . $user['last_name'] . '<br>
			<b>Company:</b> : ' . $user['company'] . '<br>
			<b>Email:</b> : ' . $user['email'] . '<br>
			<b>Tarif:</b> :<br>
			' . $tariff;
			$body = sprintf("%s", $details);
			$this->sendMail($to, $subject, $body);

			$_SESSION['activation_success'] = "Erfolgreich! Ihr Konto wurde erfolgreich aktivert.";
			redirect('auth/signin');
		}
	}

	private function sendMail($to, $subject, $body)
	{
		$this->load->library('email');
		$config = array(
			'protocol' => 'smtp',
			// 'mail', 'sendmail', or 'smtp'
			'smtp_host' => IMAP_HOST,
			'smtp_auth' => true,
			'smtp_port' => 587,
			'smtp_user' => IMAP_USERNAME,
			'smtp_pass' => IMAP_PASS,
			//'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
			'mailtype' => 'html',
			//plaintext 'text' mails or 'html'
			'smtp_timeout' => '5',
			//in seconds
			'charset' => 'utf-8',
			'wordwrap' => TRUE
		);

		$this->email->initialize($config);

		$this->email->from('no-reply@email-invoice.de', 'EMAIL INVOICE Support');
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
				if (!$user['lex_email']) {
					$lex_email = sprintf('%s@email-invoice.de', random_string('alnum', 6));
					$data['lex_email'] = $lex_email;
					$user['lex_email'] = $lex_email;
				}

				// create customer on client's lex
				$this->UserModel->createCustomerOnLex($_SESSION['userId']);

				$res = $this->UserModel->updLexDetail($data, $_SESSION['userId']);
				$_SESSION['lex_detail_update_success'] = 'lexoffice Public API wurde hinzugefügt';

				$to = $user['email'];
				$subject = 'EMAIL INVOICE: Ihr lexoffice Public API Schlüssel wurde erfolgreich hinzugefügt';
				$body = sprintf("Hallo %s, <br><br> 
				Ihr lexoffice Public API Schlüssel wurde erfolgreich hinzugefügt.<br>
				Mit folgender EMAIL INVOICE Adresse können Sie ab jetzt Ihre Rechnungen empfangen und diese werden direkt
				in Ihrem lexoffice Account hinterlegt:<br><br>
				<b>%s</b>
				<br><br><br>
				Mit freundlichem Gruß<br>
				<br>
				EMAIL INVOICE Support<br>
				Ulmenstraße 17<br>
				D-65527 Niedernhausen<br>
				Tel.: +49 (0) 6127 706982-0<br>
				USt-IdNr.: DE165054377<br>
				Inh.: Dipl. Kfm. Sören Lange<br>
				Email: hallo@email-invoice.de<br>
				Internet: email-invoice.de
				", $user['name'], $user['lex_email'], $user['lex_email']);

				$body = $this->load->view('emails/account_activate', [
					'username' => $user['name'],
					'lex_email' => $user['lex_email']
				], true);

				$this->sendMail($to, $subject, $body);

			} else {
				$this->session->set_flashdata('lex_detail_update_error', 'Dieser Lexoffice API Key ist nicht gültig');
			}
			redirect("dashboard");
		}
	}

	public function secondEmail()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('second_email', 'Second Email', 'required|valid_email|is_unique[users.email]');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('msg_type', 'danger');
			$this->session->set_flashdata('msg', 'Invalid email');
			$this->dashboard();
		} else {
			$second_email = $this->input->post('second_email');

			$this->UserModel->updateSecondEmail($_SESSION['userId'], $second_email);

			$this->session->set_flashdata('msg_type', 'success');
			$this->session->set_flashdata('msg', 'Second email updated');
			
			redirect("dashboard");
		}
	}


	public function forgotpassword()
	{
		$html = $this->load->view('auth/forgotPasswrod', [], true);
		$this->load->view('layout', ['content' => $html]);
	}

	public function revoverPasswordView()
	{
		$html = $this->load->view('auth/revoverPassword', [], true);
		$this->load->view('layout', ['content' => $html]);
	}
	public function revoverPassword()
	{
		$email = $this->input->post('email');
		$check_email_exist = $this->UserModel->check_email_exist($email);
		if ($check_email_exist) {
			$token = bin2hex(random_bytes(15));
			$id = $check_email_exist->id;
			$email = $check_email_exist->email;
			$data = array('forgot_pass_code' => $token);
			$update_pass_recover_code = $this->UserModel->updatePasswordRevoverCode($id, $data);
			if ($update_pass_recover_code) {
				$to = $email;
				$subject = 'Passwort vergessen';
				$body = sprintf("Hallo %s, <br><br> Klicken Sie auf den folgenden Link, um Ihr Passwort zurückzusetzen <br><br> %s
				<br>
				Mit freundlichem Gruß<br>
				<br>
				EMAIL INVOICE Support<br>
				Ulmenstraße 17<br>
				D-65527 Niedernhausen<br>
				Tel.: +49 (0) 6127 / 706982-0<br>
				USt-IdNr.: DE165054377<br>
				Inh.: Dipl. Kfm. Sören Lange<br>
				Email: hallo@email-invoice.de<br>
				Internet: email-invoice.de
				", $user_name, base_url() . 'user/revover/password/' . $token);

				$this->sendMail($to, $subject, $body);

				$_SESSION['code_sent'] = "Anweisungen zum Zurücksetzen des Kennworts werden an Ihre Emailadresse gesendet";
				$this->forgotpassword();
			}
		} else {
			$_SESSION['no_email_found'] = "Diese Emailadresse wurde nicht gefunden";
			$this->forgotpassword();
		}
	}


	public function passwordRecoverView($token)
	{
		$res = $this->UserModel->check_token_exist($token);
		if ($res) {
			$id = $res->id;
			$data['id'] = $id;
			$html = $this->load->view('auth/recoverPassword', $data, true);
			$this->load->view('layout', ['content' => $html]);
		} else {
			//no token exist
		}
	}

	public function updatePassword()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('conf_pass', 'Password Confirmation', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			$_SESSION['update_pass_error'] = true;
			$this->revoverPasswordView();
		} else {
			$id = $this->input->post('id');
			$password = $this->input->post('password');
			$data = array('password' => sha1($password));
			$res = $this->UserModel->updatePassword($id, $data);
			if ($res) {
				$_SESSION['password_updata'] = "Erfolgreich! Passwort erfolgreich aktualisiert";
				$this->loginView();
			}
		}
	}
}