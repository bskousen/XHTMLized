<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sites extends Admin_Controller
{

	public function _index_index($params = array())
	{
		$this->load->model('sites_model');
		
		// search
		$search = $this->input->post('search', true);
		$this->registry->set('search', $search, 'request');
		
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'index/page/',
			'uri_segment'	=> 5,
			'total_rows'	=> $this->sites_model->getNSites(),
			'per_page'		=> $per_page
		);
		
		$this->pagination->initialize($config_pagination); 
		
		$params = array(
			'start'			=> $pagination_start,
			'limit'			=> $per_page,
			'search_by'	=> ($search) ? 'name' : false,
			'search'		=> $search
		);
		
		return array(
			'sites'				=> $this->sites_model->getSites($params),
			'pagination'	=> $this->pagination->create_links()
		);	
	}
	
	public function _index_edit($params = array())
	{
		$this->load->model('sites_model');
		$site_id = (isset($params[1])) ? $params[1] : 0;
		$owner_id = $this->sites_model->getSiteOwner($site_id);
		
		/*
		$data = array();
		
		$data['form_action'] = 'index/save';
		$data['categories'] = $this->sites_model->getBlogCategories();
		
		$data['site'] = $this->sites_model->getSite($site_id);
		$data['article_categories'] = $this->sites_model->getBlogArticleCategories($article_id);
		$data['article_attachments'] = $this->sites_model->getBlogArticleAttachments($article_id);
		*/
		$data = array(
			'form_action'	=> 'index/save',
			'site'				=> $this->sites_model->getSiteInfo($site_id),
			'user'				=> $this->users_model->getUser($owner_id)
		);
		
		return $data;
	}
	
	public function _index_save()
	{
		$data = array();
		$site_id = ($this->input->post('siteid')) ? $this->input->post('siteid') : '0';
		$user_id = $this->input->post('userid');
		$owner_id = $this->sites_model->getSiteOwner($site_id);
		$this->load->model('sites_model');
		$this->load->model('users_model');
		$password = $this->input->post('fpass1');
		$this->registry->set('action','edit', 'request');
		
		if ($password !== $this->input->post('fpass2')) {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Debe introducir la misma contraseña dos veces.'
			));
			return array(
				'form_action'	=> 'index/save',
				'site'				=> $this->sites_model->getSiteInfo($site_id),
				'user'				=> $this->users_model->getUser($owner_id)
			);
		}
		
		if (!$site_id and $password == '') {
			$this->registry->set_message(array(
		  	'class'		=> 'error',
		    'content'	=> 'Para poder crear un nuevo sitio debe indicar una contraseña para el usuario franquiciado.'
		  ));
		  return array(
				'form_action'	=> 'index/save',
				'site'				=> $this->sites_model->getSiteInfo($site_id),
				'user'				=> $this->users_model->getUser($owner_id)
			);
		}
		
		// site data
		$data['sites'] = array(
			'name' 			=> $this->input->post('name'),
		  'subdomain'	=> $this->input->post('subdomain'),
		  'domain'		=> $this->input->post('domain'),
		  'status'		=> $this->input->post('status')
		);
		// franchiser data
		$data['users'] = array(
			'username'				=> $this->input->post('fusername'),
		  'email'						=> $this->input->post('femail'),
		  'nif'							=> $this->input->post('fnif'),
		  'display_name'		=> $this->input->post('fname') . ' ' . $this->input->post('fsurname'),
		  'web'							=> $this->input->post('fweb'),
		  'IP_modified'			=> $this->input->ip_address(),
		  'date_modified' 	=> date('Y-m-d H:i:s')
		);
		$data['users_address'] = array(
			'name' 		=> $this->input->post('fname'),
		  'surname'	=> $this->input->post('fsurname'),
		  'address'	=> $this->input->post('faddress'),
		  'zipcode'	=> $this->input->post('fzipcode'),
		  'city'		=> $this->input->post('fcity'),
		  'state'		=> $this->input->post('fstate'),
		  'country'	=> $this->input->post('fcountry'),
		  'phone'		=> $this->input->post('fphone')
		);
		// save password if user filled it
		if ($password !== '') {
		  $data['users']['password'] = sha1($password.$this->config->item('encryption_key'));
		}
		
		if ($site_id = $this->sites_model->saveSite($data, $site_id)) {
			$this->registry->set_message(array(
		  	'class'		=> 'success',
		    'content'	=> 'Datos del sitio guardados correctamente.'
		  ));
		} else {
		  $this->registry->set_message(array(
		  	'class'		=> 'error',
		    'content'	=> 'Error al guardar los datos del sitio.'
		  ));
		}
		
		$owner_id = $this->sites_model->getSiteOwner($site_id);
		$data = array(
			'form_action'	=> 'index/save',
			'site'				=> $this->sites_model->getSiteInfo($site_id),
			'user'				=> $this->users_model->getUser($owner_id)
		);
		
		return $data;
		
		
		
		
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

}

/* End of file sites.php */
/* Location: ./application/controllers/admin/sites.php */