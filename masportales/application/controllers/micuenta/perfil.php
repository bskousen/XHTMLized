<?php

class Perfil extends Account_Controller
{

	public function _index_index()
	{
		
	}
	
	public function _user_edit()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		$this->form_validation->set_message('valid_email', 'El campo \'%s\' debe contener un email válido.');
		$this->form_validation->set_message('exact_length', 'El campo \'%s\' debe tener %s carácteres.');
		$this->form_validation->set_message('is_unique', 'Ya existe usuario con el \'%s\' indicado.');
		
	}
	
	public function _user_password()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		
	}
	
	public function _user_save()
	{
		$this->load->model('users_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		$this->form_validation->set_message('matches', '\'%s\' y \'%s\' son distintos.');
		$this->form_validation->set_message('valid_email', 'El campo \'%s\' debe contener un email válido.');
		$this->form_validation->set_message('exact_length', 'El campo \'%s\' debe tener 9 carácteres.');
		$this->form_validation->set_message('is_unique', 'Ya existe usuario con el \'%s\' indicado.');
		
		$this->form_validation->set_rules('username', 'Nombre de usuario', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		
		$this->form_validation->set_rules('nif', 'N.I.F.', 'trim|exact_length[9]|xss_clean');
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required|xss_clean');
		$this->form_validation->set_rules('surname', 'Apellidos', 'trim|required|xss_clean');
		$this->form_validation->set_rules('address', 'Direccion', 'trim|xss_clean');
		$this->form_validation->set_rules('zipcode', 'Codigo Postal', 'trim|xss_clean');
		$this->form_validation->set_rules('city', 'Ciudad', 'trim|xss_clean');
		$this->form_validation->set_rules('state', 'Provincia', 'trim|xss_clean');
		$this->form_validation->set_rules('country', 'Pais', 'trim|xss_clean');
		$this->form_validation->set_rules('phone', 'Telefono', 'trim|xss_clean');
		$this->form_validation->set_rules('web', 'Web', 'trim|xss_clean');
		
		//$this->form_validation->set_rules('uid', 'ID usuario', 'trim|numeric|xss_clean');
		
		if ($this->form_validation->run() == false) {
			$this->registry->set('action', 'edit', 'request');
		} else {
			$this->registry->set('section', 'index', 'request');
			$this->registry->set('action', 'index', 'request');
			
			$data['users'] = array(
				'username'				=> $this->input->post('username'),
				'email'						=> $this->input->post('email'),
				'nif'							=> $this->input->post('nif'),
				'display_name'		=> $this->input->post('name') . ' ' . $this->input->post('surname'),
				'web'							=> $this->input->post('web'),
				'IP_modified'			=> $this->input->ip_address(),
				'date_modified' 	=> date('Y-m-d H:i:s')
			);
			
			$data['users_address'] = array(
				'name' 		=> $this->input->post('name'),
				'surname'	=> $this->input->post('surname'),
				'address'	=> $this->input->post('address'),
				'zipcode'	=> $this->input->post('zipcode'),
				'city'		=> $this->input->post('city'),
				'state'		=> $this->input->post('state'),
				'country'	=> $this->input->post('country'),
				'phone'		=> $this->input->post('phone')
			);
			
			/*
			foreach ($this->input->post('other') as $key => $value) {
				if ($value != '') $data['user_meta'][$key] = $value;
			}
			*/
			if ($user_id = $this->users_model->saveUser($data, $this->registry->user('user_ID'))) {
				$this->registry->set('section', 'index', 'request');
				$this->registry->set('action', 'index', 'request');
				$this->registry->set_user($this->users_model->getUser($user_id));
			} else {
				$this->registry->set('action', 'edit', 'request');
			}
		}
	}
	
	public function _user_savepsw()
	{
		$this->load->model('users_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		$this->form_validation->set_message('matches', '\'%s\' y \'%s\' deben ser iguales.');
		
		$this->form_validation->set_rules('old_psw', 'Contraseña actual', 'trim|required|xss_clean');
		$this->form_validation->set_rules('new_psw1', 'Nueva contraseña', 'trim|required|matches[new_psw2]|xss_clean');
		$this->form_validation->set_rules('new_psw2', 'Nueva contraseña', 'trim|required|xss_clean');
		
		//$this->form_validation->set_rules('uid', 'ID usuario', 'trim|numeric|xss_clean');
		
		if ($this->form_validation->run() == false) {
			$this->registry->set('action', 'password', 'request');
		} else {
			$this->registry->set('section', 'index', 'request');
			$this->registry->set('action', 'index', 'request');
			
			$data = array(
				'users' => array(
					'password'				=> sha1($this->input->post('new_psw1').$this->config->item('encryption_key')),
					'IP_modified'			=> $this->input->ip_address(),
					'date_modified' 	=> date('Y-m-d H:i:s')
				)
			);
			
			if (!$user_id = $this->users_model->saveUser($data, $this->registry->user('user_ID'))) {
				$this->registry->set('action', 'password', 'request');
			}
		}
	}

}

/* End of file perfil.php */
/* Location: ./application/controllers/micuenta/perfil.php */