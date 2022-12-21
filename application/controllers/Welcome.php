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
}
