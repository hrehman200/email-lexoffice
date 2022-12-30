<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Laminas\Mail\Storage;

class Worker extends CI_Controller
{

	public  function __construct()
	{
		parent::__construct();

		$this->load->model('UserModel');
	}

	public function work()
	{
		$mailbox = new \Pb\Imap\Mailbox(
			IMAP_HOST,
			IMAP_USERNAME,
			IMAP_PASS,
			'INBOX',
			ATTACHMENT_FOLDER,
			[
				\Pb\Imap\Mailbox::OPT_DEBUG_MODE => true
			]
		);
		$messageIds = $mailbox->search('UNSEEN');

		if (count($messageIds) == 0) {
			echo "No emails found \n";
			exit();
		}

		foreach ($messageIds as $messageId) {
			$message = $mailbox->getMessage($messageId);

			// echo '<pre>';
			// print_r($message);
			// echo '</pre>';

			// print_r($message->getAttachments());

			$to_email = $message->toString;

			// viHGPh@email-invoice.de <viHGPh@email-invoice.de>
			if(strpos($to_email, ' ') !== false) {
				$to_email = explode(' ', $to_email)[0];
			}

			$user = $this->UserModel->getByLexEmail($to_email);
			if(!$user) {
				log_message('error', sprintf('No user found with Lex Email %s', $to_email));
				continue;
			}

			$attachments = $message->getAttachments();
			foreach ($attachments as $attachment) {
				log_message('error', sprintf('Uploading file %s', ATTACHMENT_FOLDER . $attachment->filepath));
				$response = $this->UserModel->makeRequest('files', $user['lex_api_key'], array('file' => new CURLFILE(ATTACHMENT_FOLDER . $attachment->filepath), 'type' => 'voucher'), true);

				if (array_key_exists('id', $response)) {
					unlink(ATTACHMENT_FOLDER . $attachment->filepath);

					try {
						$mailbox->addFlags([$messageId], [Storage::FLAG_DELETED]);
						$mailbox->expunge();
					} catch (Exception $e) {
						log_message('error', $e->getMessage());
						echo $e->getMessage() . "\n";
					}
				}
			}
		}
	}
}
