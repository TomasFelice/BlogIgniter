<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->optional_session_auto(1);
	}

	public function index()
	{
		if ($this->session->userdata('auth_level') == 9) {
			redirect('/admin');
		}

		redirect('/blog');
	}
}
