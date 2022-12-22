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

	public function signin()
	{	$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');            
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE){
               print_r(validation_errors());
        }
        else
        {
        	//done
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
          	$verification_code = bin2hex(random_bytes(15));
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
        	$email_id = $this->input->post('email');
        	$user_name = $this->input->post('name');
             if ($this->UserModel->insertData($data)) {

                	$this->load->library('PHPMailer_Lib');

			        $mail = $this->PHPMailer_Lib->load();
			       
			        /* SMTP configuration */
			        $mail->isSMTP();
			        $mail->Host     = 'smtp.gmail.com';
			        $mail->SMTPAuth = true;
			        $mail->Username = 'sohailafridy99@gmail.com';
			        $mail->Password = 'xlyzzvsgqefsapfz';
			        $mail->SMTPSecure = 'tls';
			        $mail->Port     = 587;
			       
			        $mail->setFrom('sohailafridy99@gmail.com', 'CodexWorld');
			        // $mail->addReplyTo('info@example.com', 'CodexWorld');
			       
			        /* Add a recipient */
			        $mail->addAddress($email_id);
			       
			      
			       
			        /* Email subject */
			        $mail->Subject = 'Account Activation';
			       
			        /* Set email format to HTML */
			        $mail->isHTML(true);
			       
			        /* Email body content */
			        $mailContent = "Hi,".$user_name." ";
			        $mail->Body = $mailContent;
			       
			        /* Send email */
			        if(!$mail->send()){
			            echo 'Mail could not be sent.';
			            echo 'Mailer Error: ' . $mail->ErrorInfo;
			        }else{
			            echo 'Mail has been sent';
			        }    

			    }else{
                    echo 'have a prob';
                }   

        }
	}


	
}
