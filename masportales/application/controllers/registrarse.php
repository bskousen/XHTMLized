<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registrarse extends Front_Controller {

	public function _remap($method, $arguments = array())
	{
		global $class;
		
		//$this->load->model('users_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		$this->form_validation->set_message('matches', '\'%s\' y \'%s\' son distintos.');
		$this->form_validation->set_message('valid_email', 'El campo \'%s\' debe contener un email válido.');
		$this->form_validation->set_message('exact_length', 'El campo \'%s\' debe tener 9 carácteres.');
		$this->form_validation->set_message('is_unique', 'Ya existe usuario con el \'%s\' indicado.');
		
		$this->registry->set('module', $class, 'request');
		$this->settings['module_url']	= _reg('site_url') . $class . '/';
		$this->registry->set('section', ($method == 'index' ? 'pasouno' : $method), 'request');
		
		$function = '_' . $this->registry->request('section');
		
		if (method_exists($this, $function)) {
			$this->settings['data'] = $this->$function($arguments);
		} else {
			show_404();
		}
		$this->columns(); // TODO
		$this->load->view('themes/default/layout', $this->settings);
	}
	
	public function _pasouno()
	{
		
	}
	
	public function _pasodos()
	{
		$this->load->model('users_model');
		
		$this->form_validation->set_rules('nif', 'DNI', 'trim|required|exact_length[9]|is_unique[users.nif]|xss_clean');
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required|xss_clean');
		$this->form_validation->set_rules('surname', 'Apellidos', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('username', 'Nombre de usuario', 'trim|required|is_unique[users.username]|xss_clean');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|matches[password2]');
		$this->form_validation->set_rules('password2', 'Repite contraseña', 'trim|required');
		
		if ($this->form_validation->run() == false) {
			$this->registry->set('section', 'pasouno', 'request');
		} else {
			$this->registry->set('section', 'pasodos', 'request');
			
			$data = array(
				'user' => array(
					'username'				=> $this->input->post('username'),
					'display_name'		=> $this->input->post('username'),
					'email'						=> $this->input->post('email'),
					'nif'							=> $this->input->post('nif'),
					'password'				=> sha1($this->input->post('password').$this->config->item('encryption_key')),
					'status'					=> '0',
					'IP'							=> $this->input->ip_address(),
					'date_modified' 	=> date('Y-m-d H:i:s'),
					'date_added' 			=> date('Y-m-d H:i:s')
				),
				'roles' => array('4'),
				'user_meta' => array(
					'name' 		=> $this->input->post('name'),
					'surname'	=> $this->input->post('surname')
				)
			);
			
			if ($user_id = $this->users_model->addUser($data)) {
				$data['user']['user_ID'] = $user_id;
				$this->_send_email_confirmation($data);
				$this->settings['user_saved'] = true;
			} else {
			  $this->settings['user_saved'] = false;
			}
			
		}
	}
	
	public function _confirmation($hash)
	{
		$this->load->model('users_model');
		$hash = $hash[0];
		
		if ($result = $this->users_model->getUserMeta($hash, 'VALUE')) {
			$user_id = $result[0]['user_ID'];
			if ($this->users_model->activeUser($user_id)) {
				$this->users_model->deleteUserConfirmationHash($hash);
				$confirmed = $result[0];
			} else {
				$confirmed = false;
			}
		} else {
			$confirmed = false;
		}
		
		return array('confirmed' => $confirmed);
	}
	
	private function _send_email_confirmation($user)
	{
		$this->load->model('users_model');
		
		$data = array(
			'user_ID' => $user['user']['user_ID'],
			'meta_key' => 'confirmation_user_hash',
			'meta_value' => random_string('unique')
		);
		
		$this->users_model->setUserMeta($data);
		
		$email_html = '<p>Estimado ' . $user['user_meta']['name'] . ' ' . $user['user_meta']['surname'] . '</p>';
		$email_html.= '<p>Gracias por registrarse en +Portales.</p>';
		$email_html.= '<p>Para activar su cuenta debe pulsar en el siguiente enlace.</p>';
		$email_html.= '<p><a href="' . _reg('site_url') . 'registrarse/confirmation/' . $data['meta_value'] . '">Confirma tu cuenta en +Portales</a></p>';
		$email_html.= '<p>Un saludo,</p>';
		$email_html.= '<p>+Portales</p>';
		
		$email_mssg = "Estimado " . $user['user_meta']['name'] . " " . $user['user_meta']['surname'] . "\r\n
Gracias por registrarse en +Portales.\r\n
Para activar su cuenta debe pulsar en el siguiente enlace.\r\n
{unwrap}" . _reg('site_url') . 'registrarse/confirmation/' . $data['meta_value'] . "{/unwrap}\r\n
Un saludo,\r\n
+Portales";
		
		$this->load->library('email');

		$this->email->from('no-reply@masportales.es', '+portales');
		$this->email->to($user['user']['email']);
		
		$this->email->subject('Confirma tu cuenta en +Portales');
		$this->email->message($email_mssg);
		
		$this->email->send();
	}

}

/* End of file registrarse.php */
/* Location: ./application/controllers/registrarse.php */