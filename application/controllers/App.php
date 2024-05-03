<?php

class App extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library("Form_validation");

        $this->load->helper('form');

        $this->load->database();
    }

    public function login() {
		if ($this->uri->uri_string() == 'app/login') {
			show_404();
		}

        $view['body'] = $this->load->view("app/login", null, true);
        $this->parser->parse("admin/template/body_format_2", $view);
    }

    public function ajax_attempt_login()
	{
		if( $this->input->is_ajax_request() )
		{
			// Allow this page to be an accepted login page
			$this->config->set_item('allowed_pages_for_login', ['app/ajax_attempt_login'] );

			// Make sure we aren't redirecting after a successful login
			$this->authentication->redirect_after_login = FALSE;

			// Do the login attempt
			$this->auth_data = $this->authentication->user_status( 0 );

			// Set user variables if successful login
			if( $this->auth_data )
				$this->_set_user_variables();

			// Call the post auth hook
			$this->post_auth_hook();

			// Login attempt was successful
			if( $this->auth_data )
			{
				echo json_encode([
					'status'   => 1,
					'user_id'  => $this->auth_user_id,
					'username' => $this->auth_username,
					'level'    => $this->auth_level,
					'role'     => $this->auth_role,
					'email'    => $this->auth_email
				]);
			}

			// Login attempt not successful
			else
			{
				$this->tokens->name = config_item('login_token_name');

				$on_hold = ( 
					$this->authentication->on_hold === TRUE OR 
					$this->authentication->current_hold_status()
				)
				? 1 : 0;

				echo json_encode([
					'status'  => 0,
					'count'   => $this->authentication->login_errors_count,
					'on_hold' => $on_hold, 
					'token'   => $this->tokens->token()
				]);
			}
		}

		// Show 404 if not AJAX
		else
		{
			show_404();
		}
	}

    	/**
	 * Log out
	 */
	public function logout()
	{
		$this->authentication->logout();

		$this->session->sess_destroy();

		// Set redirect protocol
		$redirect_protocol = USE_SSL ? 'https' : NULL;

		redirect( site_url( LOGIN_PAGE . '?' . AUTH_LOGOUT_PARAM . '=1', $redirect_protocol ) );
	}

	public function register() {
		if ($this->uri->uri_string() == 'app/register') {
			show_404();
		}

		$data['name'] = "";
		$data['surname'] = "";
		$data['username'] = "";
		$data['email'] = "";

		if ($this->input->server("REQUEST_METHOD") == "POST") {
            $this->form_validation->set_rules('username', 'usuario', 'max_length[12]|is_unique[' . config_item('user_table') . '.username]|required');
            $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|is_unique[' . config_item('user_table') . '.email]');
            $this->form_validation->set_rules('passwd', 'contraseña', 'min_length[8]|trim|required|max_length[72]|callback_validate_password');
            $this->form_validation->set_rules('name', 'nombre', 'max_length[100]|required');
            $this->form_validation->set_rules('surname', 'apellido', 'max_length[100]|required');
            $this->form_validation->set_message('is_unique', 'El %s ya está registrado');

            $data['title'] = $this->input->post('name');
            $data['content'] = $this->input->post('surname');
            $data['description'] = $this->input->post('username');
            $data['posted'] = $this->input->post('email');

            if($this->form_validation->run()) {

                // Form valido
                $save = [
                    'name' => $this->input->post('name'),
                    'surname' => $this->input->post('surname'),
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
					'passwd' => $this->authentication->hash_passwd($this->input->post('passwd')),
					'user_id' => $this->User->get_unused_id(),
					'created_at' => date('Y-m-d H:i:s'),
					'auth_level' => 1
                ];

				$post_id = $this->User->insert($save);

				// TODO: Enviar email de confirmación

				$this->session->set_flashdata('text', 'Registro correcto');
            	$this->session->set_flashdata('type', 'success');
                
                redirect('/login');
            }
        }

		$view['body'] = $this->load->view('app/register', $data, true);
		$this->parser->parse('admin/template/body_format_2', $view);
	}

	/* Perfil de usuario */

	public function profile() {

		$this->init_session_auto(1);
		$this->load->helper('Breadcrumb_helper');

		$data['user'] = $this->User->find($this->session->userdata('id'));

		$this->form_validation->set_rules('old_pass', 'Contraseña actual', 'required|callback_validate_same_password');
		$this->form_validation->set_rules('new_pass', 'Contraseña nueva', 'required|min_length[8]|max_length[72]|callback_validate_password');
		$this->form_validation->set_rules('new_pass_verify', 'Repita la nueva contraseña', 'required|matches[new_pass]');

		if($this->input->server('REQUEST_METHOD') == 'POST') {
			if($this->form_validation->run()) {
				// Formulario valido
	
				$save = [
					'passwd' => $this->authentication->hash_passwd($this->input->post('new_pass'))
				];
	
				$this->User->update($this->session->userdata('id'), $save);
				$this->session->sess_destroy();
				$this->session->set_flashdata('text', 'Contraseña actualizada');
				$this->session->set_flashdata('type', 'danger');
				redirect('/login');
			}
		}

		$view["body"] = $this->load->view("app/profile", $data, true);
		$view["title"] = 'Perfil';
        
        if ($this->session->userdata("auth_level") == 9) {
            $view['breadcrumb'] = breadcrumb_admin("profile");
            $this->parser->parse("admin/template/body", $view);
        } else {
            $this->parser->parse("blog/template/body", $view);
        }
	}

	
    /* Upload Perfil */

    public function load_avatar() {

        $this->avatar_upload();
        $this->session->set_flashdata('type', 'success');
        $this->session->set_flashdata('text', 'Avatar cambiado con exito.');
        redirect('/app/profile');
    }

    /* Subida del avatar */

    private function avatar_upload() {

        $id = $this->session->userdata('id');

        $image = 'image';
        $config['upload_path'] = 'uploads/user/';
        $config['file_name'] = 'imagen_' . $id;
        $config['allowed_types'] = "jpg|jpeg|png";
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($image)) {
			// ocurrio un error
            $this->session->set_flashdata('type', 'danger');
            $this->session->set_flashdata('text', $this->upload->display_errors());
            return;
        }

        // informacion acerca de la subida
        $data = $this->upload->data();
        $save = array('avatar' => 'imagen_' . $id . $data['file_ext']);
        // actualizo la url
        $this->User->update($id, $save);
        $this->session->set_userdata('avatar', $save['avatar']);
        $this->resize_avatar($data['full_path'], $save['avatar']);
    }

    private function resize_avatar($ruta, $nombre) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $ruta;
        $config['new_image'] = 'uploads/avatar/user/' . $nombre;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 300;
        $config['height'] = 300;

        $this->load->library('image_lib', $config);

        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
    }

}
