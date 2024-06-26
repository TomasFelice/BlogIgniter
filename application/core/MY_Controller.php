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

		$this->load->helper('User_helper');
	}

	public function init_session_auto($level) {
		$this->require_min_level($level);

		if ($this->auth_data) {
			$this->session->set_userdata([
				'email' => $this->auth_data->email,
				'name' => $this->auth_data->username,
				'id' => $this->auth_data->user_id,
				'auth_level' => $this->auth_data->auth_level,
				'avatar' => image_user($this->auth_data->user_id)
			]);
		}

	}

	public function optional_session_auto($level) {
		$this->verify_min_level($level);

		if ($this->auth_data) {
			$this->session->set_userdata([
				'email' => $this->auth_data->email,
				'name' => $this->auth_data->username,
				'id' => $this->auth_data->user_id,
				'auth_level' => $this->auth_data->auth_level,
				'avatar' => image_user($this->auth_data->user_id)
			]);
		}

	}

	    /*     * ***
     * VALIDATION
     */

     public function validate_password($password) {
        // Verificamos que tenga al menos un digito
        $regex = '(?=.*\d)';
        // Verificamos que tenga al menos una minuscula
        $regex .= '(?=.*[a-z])';
        // Verificamos que tenga al menos una mayuscula
        $regex .= '(?=.*[A-Z])';
        // Verificamos que no tenga espacios, tabs o otros caracteres especiales
        $regex .= '(?!.*\s)';
        // Verificamos que no tenga contrabarra, apostrofe, comillas, etc
        $regex .= '(?!.*[\\\\\'"])';

        if (preg_match('/^' . $regex . '.*$/', $password)) {
            return true;
        }

        return false;
     }

	 public function validate_same_password($password) {
		$user = $this->User->find($this->session->userdata('id'));

		return $this->authentication->check_passwd($user->passwd, $password);
	 }
}

/* End of file MY_Controller.php */
/* Location: /community_auth/core/MY_Controller.php */