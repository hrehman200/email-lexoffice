
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends CI_Controller{
   
    function  __construct(){
        parent::__construct();
    }
    function index(){
        

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
        $this->email->to('sohailkust397@gmail.com');

        $this->email->subject('Demo message local');
        $this->email->message('demo msg');

        if($this->email->send()){
            echo "success";
        }else{
            print_r($this->email->print_debugger());
        }
    }
   
    function send(){
        /* Load PHPMailer library */
        $this->load->library('phpmailer_lib');
       
        /* PHPMailer object */
        $mail = $this->Phpmailer_lib->load();
       
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
        $mail->addAddress('sohailkust397@gmail.com');
       
      
       
        /* Email subject */
        $mail->Subject = 'Send Email via SMTP using PHPMailer in CodeIgniter';
       
        /* Set email format to HTML */
        $mail->isHTML(true);
       
        /* Email body content */
        $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
        <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
        $mail->Body = $mailContent;
       
        /* Send email */
        if(!$mail->send()){
            echo 'Mail could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo 'Mail has been sent';
        }
    }
   
}






