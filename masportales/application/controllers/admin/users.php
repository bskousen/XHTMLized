<?php

class Users extends Admin_Controller
{

	public function _index_index()
	{
		$this->load->model('users_model');
		
		return $this->users_model->getUsers();
	}
	
	public function _user_index()
	{
		$this->load->model('users_model');
		
		// search
		$search = $this->input->post('search', true);
		$this->registry->set('search', $search, 'request');
		
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'users/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->users_model->getNUsers(),
			'per_page'		=> $per_page
		);
		
		$this->pagination->initialize($config_pagination); 
		
		$params = array(
			'start'			=> $pagination_start,
			'limit'			=> $per_page,
			'search_by'	=> ($search) ? 'display_name' : false,
			'search'		=> $search
		);
		
		return array(
			'users'				=> $this->users_model->getUsers($params),
			'pagination'	=> $this->pagination->create_links()
		);
	}
	
	public function _user_edit($params = array())
	{
		$this->load->model('users_model');
		$user_id = (isset($params[1])) ? $params[1] : 0;
		$data = array();
		
		if ($user_id == 0) {
			$data['form_action'] = 'user/save';
		} else {
			$data['form_action'] = 'user/update';
		}
		
		$data['roles'] = $this->users_model->getRoles();
		
		$data['user'] = $this->users_model->getUser($user_id);
		$data['user_roles'] = $this->users_model->getUserRoles($user_id);
		
		return $data;
	}
	
	public function _user_me()
	{
		$this->load->model('users_model');
		$user_id = $this->getUserLogged('user_ID');
		$data = array();
		
		if ($user_id == 0) {
			mp_redirect('admin/dashboard'); // TODO: redirect to a error page
		} else {
			$data['form_action'] = 'user/update';
		}
		
		$data['user'] = $this->users_model->getUser($user_id);
		
		return $data;
	}
	
	public function _user_save()
	{
		$data = array();
		$user_id = $this->input->post('userid');
		$this->load->model('users_model');
		$password = $this->input->post('pass1');
		
		if ($password == $this->input->post('pass2')) {
			/*
			$data['user'] = array(
				'username'				=> $this->input->post('username'),
				'email'						=> $this->input->post('email'),
				'nif'							=> $this->input->post('nif'),
				'display_name'		=> $this->input->post('name') . ' ' . $this->input->post('surname'),
				'status'					=> $this->input->post('status'),
				'IP'							=> $this->users_model->getUserIP(),
				'date_modified' 	=> date('Y-m-d H:i:s'),
				'date_added' 			=> date('Y-m-d H:i:s')
			);
			*/
			$data['users'] = array(
				'username'				=> $this->input->post('username'),
				'email'						=> $this->input->post('email'),
				'nif'							=> $this->input->post('nif'),
				'display_name'		=> $this->input->post('name') . ' ' . $this->input->post('surname'),
				'status'					=> $this->input->post('status'),
				'web'							=> $this->input->post('web'),
				'IP_modified'			=> $this->input->ip_address(),
				'date_modified' 	=> date('Y-m-d H:i:s')
			);
			// save address data
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
			// save password if user filled it
			if ($password !== '') {
				$data['users']['password'] = sha1($password.$this->config->item('encryption_key'));
			}
			// save roles
			$data['users_roles'] = $this->input->post('roles');
			
			if (!$user_id and $password == '') {
				$this->registry->set_message(array(
					'class'		=> 'error',
				  'content'	=> 'Debe indicar una contraseña.'
				));
			} else {
				if ($user_id = $this->users_model->saveUser($data, $user_id)) {
					$this->registry->set_message(array(
						'class'		=> 'success',
					  'content'	=> 'Datos de usuario guardados correctamente.'
					));
				} else {
					$this->registry->set_message(array(
						'class'		=> 'error',
					  'content'	=> 'Error al guardar los datos del usuario.'
					));
				}
			}
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Debe introducir la misma contraseña dos veces.'
			));
		}
		$this->registry->set('action','edit', 'request');
		
		return array(
			'form_action'	=> 'user/save',
			'roles'				=> $this->users_model->getRoles(),
			'user'				=> $this->users_model->getUser($user_id),
			'user_roles'	=> $this->users_model->getUserRoles($user_id)
		);
	}
	
	public function _user_update()
	{
		$data = array();
		$this->load->model('users_model');
		$user_id = $this->registry->user('user_ID');
		$password = $this->input->post('pass1');
		
		if ($password == $this->input->post('pass2')) {
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
			
			if ($password !== '') {
				$data['users']['password'] = sha1($password.$this->config->item('encryption_key'));
			}
			
			if ($user_id = $this->users_model->saveUser($data, $user_id)) {
				$this->registry->set_message(array(
					'class'		=> 'success',
				  'content'	=> 'Datos de usuario guardados correctamente.'
				));
			} else {
				$this->registry->set_message(array(
					'class'		=> 'error',
				  'content'	=> 'Error al guardar los datos del usuario.'
				));
			}
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Debe introducir la misma contraseña dos veces.'
			));
		}
		$this->registry->set('action','me', 'request');
		$this->registry->set_user($this->users_model->getUser($user_id));
	}
	
	public function _user_delete($params = array())
	{
		$this->load->model('users_model');
		$user_id = (isset($params[1])) ? $params[1] : 0;
		
		if ($this->users_model->deleteUser($user_id)) {
			$this->session->set_flashdata('message', 'Usuario borrado correctamente.');
		} else {
			$this->session->set_flashdata('message', 'Error al borrar el usuario.');
		}
		
		mp_redirect('admin/users/user');
	}
	
	public function _role_index($params = array())
	{
		$this->load->model('users_model');
		
		return $this->users_model->getRoles();
	}
	
	public function _role_edit($params = array())
	{
		$this->load->model('users_model');
		$role_id = (isset($params[1])) ? $params[1] : 0;
		$data = array();
		
		if ($role_id == 0) {
			$data['form_action'] = 'role/save';
		} else {
			$data['form_action'] = 'role/update';
		}
		
		$data['roles'] = $this->users_model->getRoles();
		
		$data['role'] = $this->users_model->getRole($role_id);
		
		return $data;
	}
	
	public function _role_save($params = array())
	{
		$data = array();
		$this->load->model('users_model');
		
		$data['role'] = array(
			'name'						=> $this->input->post('name'),
			'value'						=> $this->input->post('value')
		);
		if ($this->users_model->addRole($data)) {
			$this->session->set_flashdata('message', 'Nuevo perfil guardado correctamente.');
			mp_redirect('admin/users/role');
		} else {
			$this->session->set_flashdata('message', 'Error al guardar el nuevo perfil.');
			mp_redirect('admin/users/role/edit');
		}
	}
	
	public function _role_update($params = array())
	{
		$data = array();
		$role_id = $this->input->post('roleid');
		$this->load->model('users_model');
		
		$data['role'] = array(
			'name'						=> $this->input->post('name'),
			'value'						=> $this->input->post('value')
		);
		
		if ($this->users_model->updateRole($data, $role_id)) {
			$this->session->set_flashdata('message', 'Perfil actualizado correctamente.');
			mp_redirect('admin/users/role');
		} else {
			$this->session->set_flashdata('message', 'Error al actualizar el perfil.');
			mp_redirect('admin/users/role/edit/' . $role_id);
		}
	}
	
	public function _role_delete($params = array())
	{
		$this->load->model('users_model');
		$role_id = (isset($params[1])) ? $params[1] : 0;
		
		if ($this->users_model->deleteRole($role_id)) {
			$this->session->set_flashdata('message', 'Perfil borrado correctamente.');
		} else {
			$this->session->set_flashdata('message', 'Error al borrar el perfil.');
		}
		
		mp_redirect('admin/users/role');
	}

}

/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */