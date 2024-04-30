<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - MY Controller
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2018, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

require_once APPPATH . 'third_party/community_auth/core/Auth_Controller.php';

class MY_Controller extends Auth_Controller
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function init_seccion_auto($level) {
		$this->require_min_level($level);

		if (!$this->auth_data) {
			// Redirect to login
		}

		$this->session->set_userdata([
			'email' => $this->auth_data->email,
			'name' => $this->auth_data->username,
			'id' => $this->auth_data->user_id,
			'auth_level' => $this->auth_data->auth_level
		]);
	}
}

/* End of file MY_Controller.php */
/* Location: /community_auth/core/MY_Controller.php */