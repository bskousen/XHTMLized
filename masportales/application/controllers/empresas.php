<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresas extends Front_Controller {

	public function _remap($method, $arguments = array())
	{
		global $class;
		
		$this->load->model('ecommerce_model');
		$this->load->model('companies_model');
		$this->load->library('form_validation');
		
		$this->registry->set('module', $class, 'request');
		$view = 'themes/default/layout';
		//$this->settings['module_url']	= _reg('site_url') . $class . '/';
		/*
		if (isset($_POST['pid'])) {
			$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
			
			$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
			$this->form_validation->set_message('valid_email', 'El campo \'%s\' debe contener un email válido.');
			
			$this->form_validation->set_rules('name', 'Nombre', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('web', 'Web', 'trim|prep_url|xss_clean');
			$this->form_validation->set_rules('message', 'Mensaje', 'trim|xss_clem|strip_tags');
			
			if ($this->form_validation->run()) {
				$this->_save_comment();
			}
		}
		*/
		
		if ($method == 'index' and !$arguments) {
			$this->registry->set('section', 'empresas', 'request');
			$this->registry->set('company_id', false, 'request');
		} elseif ($company_id = $this->companies_model->slugFor($method)) {
			$this->registry->set('section', 'empresa', 'request');
			$this->registry->set('company_id', $company_id, 'request');
		} elseif (method_exists($this, '_' . $method) and is_callable(array($this, '_' . $method))) {
			$this->registry->set('section', $method, 'request');
			$this->registry->set('company_id', false, 'request');
		} else {
			show_404();
		}
		
		$function = '_' . $this->registry->request('section');
		if (method_exists($this, $function)) {
			$this->settings['data'] = $this->$function($this->registry->request('company_id'));
		} else {
			show_404();
		}
		$this->columns(); // TODO
		$this->load->view($view, $this->settings);
	}
	
	public function _empresas()
	{
		$params = array(
			'start'			=> 0,
			'limit'			=> 5,
			'filter_by'	=> 'status',
			'filter'		=> 'publicado'
		);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Guía Comercial');
		$this->registry->set_meta('keywords', $this->registry->site('companies_keywords'));
		$this->registry->set_meta('description', $this->registry->site('companies_description'));
		return array(
			'companies'	=> $this->companies_model->getCompanies($params),
			'search_query'	=> false
		);
	}
	
	public function _search()
	{
		$search_query = $this->input->post('searchquery', true);
		
		$params_companies = array(
			'start'			=> 0,
			'limit'			=> 10,
			'search_by'	=> ($search_query) ? array('name', 'description') : false,
			'search'		=> array($search_query, $search_query),
			'filter_by'	=> 'status',
			'filter'		=> 'publicado'
		);
		
		$companies	= $this->companies_model->getCompanies($params_companies);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Guía Comercial . Resultado para la búsqueda: ' . $search_query);
		$this->registry->set_meta('keywords', $this->registry->site('companies_keywords'));
		$this->registry->set_meta('description', $this->registry->site('companies_description'));
		$this->registry->set('section', 'empresas', 'request');
		
		return array(
			'companies'			=> $companies,
			'search_query'	=> $search_query
		);
	}
	
	public function _empresa($company_id)
	{
		$this->load->helper('captcha');
		$vals = array(
			'img_path'	=> _reg('base_path') . 'usrs/captcha/',
			'img_url'		=> _reg('base_url') .  'usrs/captcha/'
		);
		
		$cap = create_captcha($vals);
		
		$data = array(
			'captcha_time'	=> $cap['time'],
			'ip_address'		=> $this->input->ip_address(),
			'word'					=> $cap['word']
		);
		
		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);
		
		$company_data = $this->companies_model->getCompany($company_id);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Guía Comercial . ' . $company_data['name']);
		$this->registry->set_meta('keywords', $company_data['meta_keywords']);
		$this->registry->set_meta('description', $company_data['meta_description']);
		
		return array(
			'company' => $company_data,
			'captcha'	=> $cap
		);
	}
	
	public function _microsite($company_id)
	{
		$company_data = $this->companies_model->getCompany($company_id);
		$microsite = $this->companies_model->getCompanyMicrosite($company_id);
		
		$this->registry->set_meta('title', $company_data['name'] . ' - Home');
		$this->registry->set_meta('keywords', $company_data['meta_keywords']);
		$this->registry->set_meta('description', $company_data['meta_description']);
		
		$params = array(
			'limit'			=> '1',
		  'filter_by'	=> 'company_ID',
		  'filter'		=> $company_id
		);
		$banner = $this->companies_model->getMicrositeBanners($params);
		
		/*
		echo '<pre>';
		print_r($company_data);
		echo '</pre>';
		echo '<pre>';
		print_r($microsite);
		echo '</pre>';
		*/
		return array(
			'company'					=> $company_data,
			'company_images'	=> $this->companies_model->getCompanyImages($company_id),
			'microsite_pages'	=> $microsite,
			'banner'					=> $banner[0]
		);
	}
	
	public function _registrarse()
	{
		
	}
	
	public function _confirmation()
	{
		$this->load->model('users_model');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required|xss_clean');
		$this->form_validation->set_rules('surname', 'Apellidos', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('username', 'Nombre de usuario', 'trim|required|is_unique[users.username]|xss_clean');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|matches[password2]');
		$this->form_validation->set_rules('password2', 'Repite contraseña', 'trim|required');
		
		if ($this->form_validation->run() == false) {
			$this->registry->set('section', 'registrarse', 'request');
		} else {
			
			$data = array(
				'users' => array(
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
				'users_address' => array(
					'name' 		=> $this->input->post('name'),
					'surname'	=> $this->input->post('surname')
				)
			);
			
			if ($user_id = $this->users_model->saveUSer($data)) {
				$data['users']['user_ID'] = $user_id;
				
				$data['confirmation_hash'] = array(
					'user_ID' => $user_id,
					'meta_key' => 'confirmation_user_hash',
					'meta_value' => random_string('unique')
				);
				
				$this->users_model->setUserMeta($data['confirmation_hash']);
				
				$data['company'] = array(
					'user_ID'	=> $user_id,
					'name'		=> $this->input->post('companyname'),
					'slug'		=> url_title($this->input->post('companyname'), '-', true), // TODO. now there can be duplicated slugs
					'address'	=> $this->input->post('address'),
					'zipcode'	=> $this->input->post('zipcode'),
					'city'		=> $this->input->post('city'),
					'state'		=> $this->input->post('state'),
					'country'	=> $this->input->post('country'),
					'phone'		=> $this->input->post('phone'),
					'email'		=> ($this->input->post('companyemail')) ? $this->input->post('companyemail') : $this->input->post('email'),
					'web'			=> $this->input->post('web'),
					'date_modified'	=> date('Y-m-d H:i:s')
				);
				if ($company_id = $this->companies_model->saveCompany($data)) {
					$this->companies_model->sendRegistrationEmail($data);
					$this->registry->set_message(array(
				    'class'		=> 'success',
				    'content'	=> 'Solicitud de suscripción recibida correctamente. Se le ha enviado un email para confirmar su cuenta.'
				  ));
				} else {
					$this->registry->set_message(array(
				    'class'		=> 'error',
				    'content'	=> 'No se ha podido procesar su solicitd correctamente. Vuelva a intentarlo más tarde.'
				  ));
				}
			} else {
			  $this->registry->set_message(array(
				  'class'		=> 'error',
				  'content'	=> 'No se ha podido procesar su solicitd correctamente. Vuelva a intentarlo más tarde.'
				));
			}
		}
		
	}

}

/* End of file empresas.php */
/* Location: ./application/controllers/empresas.php */