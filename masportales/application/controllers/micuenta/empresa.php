<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa extends Account_Controller
{

	public function _index_index()
	{
		
	}
	
	public function _perfil_index()
	{
		
	}
	
	public function _perfil_new()
	{
		$this->load->library('form_validation');
	}
	
	public function _perfil_add()
	{
		$this->load->model('companies_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		$this->form_validation->set_message('matches', '\'%s\' y \'%s\' son distintos.');
		$this->form_validation->set_message('valid_email', 'El campo \'%s\' debe contener un email válido.');
		$this->form_validation->set_message('exact_length', 'El campo \'%s\' debe tener 9 carácteres.');
		$this->form_validation->set_message('is_unique', 'Ya existe usuario con el \'%s\' indicado.');
		
		$this->form_validation->set_rules('name', 'Denominacion', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nif', 'N.I.F.', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		
		$this->form_validation->set_rules('address', 'Direccion', 'trim|xss_clean');
		$this->form_validation->set_rules('zipcode', 'Codigo Postal', 'trim|xss_clean');
		$this->form_validation->set_rules('city', 'Ciudad', 'trim|xss_clean');
		$this->form_validation->set_rules('state', 'Provincia', 'trim|xss_clean');
		$this->form_validation->set_rules('country', 'Pais', 'trim|xss_clean');
		$this->form_validation->set_rules('phone', 'Telefono', 'trim|xss_clean');
		$this->form_validation->set_rules('web', 'Web', 'trim|xss_clean');
		
		if ($this->form_validation->run() == false) {
			$this->registry->set('action', 'new', 'request');
		} else {
			
			$data['company'] = $this->input->post();
			$data['company']['date_added'] = date('Y-m-d H:i:s');
			$data['company']['date_modified'] = date('Y-m-d H:i:s');
			$data['company']['status'] = 'pendiente';
			$data['company']['user_ID'] = $this->registry->user('user_ID');
			
			unset($data['company']['files'], $data['company']['umod']);
			
			if (!$this->companies_model->addCompany($data)) {
				$this->registry->set('action', 'new', 'request');
			} else {
				$this->registry->set('section', 'index', 'request');
				$this->registry->set('action', 'index', 'request');
				$this->registry->set_company($this->users_model->getUserCompany($this->registry->user('user_ID')));
			}
		}
	}
	
	public function _perfil_edit()
	{
		$this->load->library('form_validation');
		$this->load->model('companies_model');
		
		return array(
			'company_images'	=> $this->companies_model->getCompanyImages($this->registry->company('company_ID'))
		);
	}
	
	public function _perfil_save()
	{
		$this->load->model('companies_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		$this->form_validation->set_message('matches', '\'%s\' y \'%s\' son distintos.');
		$this->form_validation->set_message('valid_email', 'El campo \'%s\' debe contener un email válido.');
		$this->form_validation->set_message('exact_length', 'El campo \'%s\' debe tener 9 carácteres.');
		$this->form_validation->set_message('is_unique', 'Ya existe usuario con el \'%s\' indicado.');
		
		$this->form_validation->set_rules('name', 'Denominacion', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nif', 'N.I.F.', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		
		$this->form_validation->set_rules('address', 'Direccion', 'trim|xss_clean');
		$this->form_validation->set_rules('zipcode', 'Codigo Postal', 'trim|xss_clean');
		$this->form_validation->set_rules('city', 'Ciudad', 'trim|xss_clean');
		$this->form_validation->set_rules('state', 'Provincia', 'trim|xss_clean');
		$this->form_validation->set_rules('country', 'Pais', 'trim|xss_clean');
		$this->form_validation->set_rules('phone', 'Telefono', 'trim|xss_clean');
		$this->form_validation->set_rules('web', 'Web', 'trim|xss_clean');
		
		if ($this->form_validation->run() == false) {
			$this->registry->set('action', 'edit', 'request');
		} else {
			$data['company'] = $this->input->post();
			$data['company']['date_modified'] = date('Y-m-d H:i:s');
			
			$image_main = $this->input->post('image_main', true);
			$tmp_images = array(
				'name'	=> $this->input->post('images_name', true),
				'uri'		=> $this->input->post('images_uri', true),
				'type'	=> $this->input->post('images_type', true)
			);
			$data['companies_images'] = array();
			if ($tmp_images['name']) {
				foreach ($tmp_images['name'] as $key => $image_name) {
					$data['companies_images'][$image_name] = array(
						'name'				=> $image_name,
						'uri'					=> $tmp_images['uri'][$key],
						'mime_type'		=> $tmp_images['type'][$key],
						'status'			=> 'publish',
						'main'				=> ($image_name == $image_main) ? 1 : 0,
						'date_added'	=> date('Y-m-d H:i:s')
					);
				}
			} else {
				$data['companies_images'] = false;
			}
			
			unset($data['company']['files'], $data['company']['umod'], $data['company']['image_main'], $data['company']['images_name'], $data['company']['images_uri'], $data['company']['images_type']);
			
			if ($this->companies_model->saveCompany($data, $this->registry->company('company_ID'))) {
				$this->registry->set('section', 'index', 'request');
				$this->registry->set('action', 'index', 'request');
				$this->registry->set_company(array_merge($this->registry->company(), $data['company']));
			} else {
				$this->registry->set('action', 'edit', 'request');
			}
		}
	}
	
	public function _upgrade_index()
	{
		$this->load->model('ecommerce_model');
		$this->load->library('form_validation');
		
		return array(
			'payment'				=> $this->ecommerce_model->getPaymentGateways(false, 0)
		);
	}
	
	public function _upgrade_confirmation()
	{
		$this->load->model('ecommerce_model');
		$this->load->library('form_validation');
		
		return array(
			'payment'				=> $this->ecommerce_model->getPaymentGateways(false, 0)
		);
	}
	
	public function _microsite_index()
	{
		$this->load->model('companies_model');
		
		$params = array(
			'filter_by' => 'company_ID',
			'filter'		=> $this->registry->company('company_ID')
		);
		
		return array(
			'microsites_pages'	=> $this->companies_model->getMicrositePages($params)
		);
	}
	
	public function _microsite_pageedit($microsite_page_id)
	{
		$this->load->model('companies_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		return array(
			'microsite_page'	=> $this->companies_model->getMicrositePage($microsite_page_id)
		);
	}
	
	public function _microsite_pagesave()
	{
		$this->load->model('companies_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		$this->form_validation->set_message('matches', '\'%s\' y \'%s\' son distintos.');
		$this->form_validation->set_message('valid_email', 'El campo \'%s\' debe contener un email válido.');
		$this->form_validation->set_message('exact_length', 'El campo \'%s\' debe tener 9 carácteres.');
		$this->form_validation->set_message('is_unique', 'Ya existe usuario con el \'%s\' indicado.');
		
		$this->form_validation->set_rules('title', 'Título', 'trim|required|xss_clean');
		$this->form_validation->set_rules('slug', 'URL amigable', 'trim|required|xss_clean');
		
		$this->form_validation->set_rules('content', 'Contenido', 'trim|xss_clean');
		$this->form_validation->set_rules('meta_keywords', 'Palabras claves', 'trim|xss_clean');
		$this->form_validation->set_rules('meta_description', 'Descripcion SEO', 'trim|xss_clean');
		
		$microsite_page_id = $this->input->post('upid', true);
		
		if ($this->form_validation->run() == false) {
			//$this->registry->set('action', 'edit', 'request');
		} else {
			$data['microsites_pages'] = $this->input->post();
			$data['microsites_pages']['company_ID'] = $this->registry->company('company_ID');
			$data['microsites_pages']['author']	= $this->registry->user('user_ID');
			$data['microsites_pages']['date_modified'] = date('Y-m-d H:i:s');
			
			unset($data['microsites_pages']['upid']);
			/*
			echo '<pre>';
			print_r($data);
			echo '</pre>';
			exit();
			*/
			
			if ($microsite_page_id = $this->companies_model->saveMicrositePage($data, $microsite_page_id)) {
				$this->registry->set_message(array(
					'class'		=> 'success',
				  'content'	=> 'Apartado guardado correctamente.'
				));
				//$this->registry->set('section', 'index', 'request');
				//$this->registry->set('action', 'index', 'request');
				//$this->registry->set_company(array_merge($this->registry->company(), $data['company']));
			} else {
				$this->registry->set_message(array(
					'class'		=> 'error',
				  'content'	=> 'Error al guardar el apartado.'
				));
				//$this->registry->set('action', 'edit', 'request');
			}
		}
		$this->registry->set('action', 'pageedit', 'request');
		
		return array(
			'microsite_page'	=> $this->companies_model->getMicrositePage($microsite_page_id)
		);
	}
	
	public function _microsite_banneredit($microsite_banner_id)
	{
		$this->load->model('companies_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		// get the ID of the banner
		if (!$microsite_banner_id) {
			$params = array(
				'limit'			=> '1',
				'filter_by'	=> 'company_ID',
				'filter'		=> $this->registry->company('company_ID')
			);
			$banner = $this->companies_model->getMicrositeBanners($params);
			$microsite_banner_id = $banner[0]['microsite_banner_ID'];
		}
		
		return array(
			'microsite_banner'	=> $this->companies_model->getMicrositeBanner($microsite_banner_id)
		);
	}
	
	public function _microsite_bannersave()
	{
		$this->load->model('companies_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_rules('name', 'Título', 'trim|xss_clean');
		
		$microsite_banner_id = $this->input->post('ubid', true);
		
		if ($this->form_validation->run() == false) {
			//$this->registry->set('action', 'edit', 'request');
		} else {
			$data['microsites_banners'] = $this->input->post();
			$data['microsites_banners']['company_ID'] = $this->registry->company('company_ID');
			//$data['microsites_banners']['author']	= $this->registry->user('user_ID');
			//$data['microsites_banners']['date_modified'] = date('Y-m-d H:i:s');
			
			unset($data['microsites_banners']['ubid'], $data['microsites_banners']['umod'], $data['microsites_banners']['files']);
			/*
			echo '<pre>';
			print_r($data);
			echo '</pre>';
			exit();
			*/
			
			if ($microsite_banner_id = $this->companies_model->saveMicrositeBanner($data, $microsite_banner_id)) {
				$this->registry->set_message(array(
					'class'		=> 'success',
				  'content'	=> 'Banner guardado correctamente.'
				));
				//$this->registry->set('section', 'index', 'request');
				//$this->registry->set('action', 'index', 'request');
				//$this->registry->set_company(array_merge($this->registry->company(), $data['company']));
			} else {
				$this->registry->set_message(array(
					'class'		=> 'error',
				  'content'	=> 'Error al guardar el banner.'
				));
				//$this->registry->set('action', 'edit', 'request');
			}
		}
		$this->registry->set('action', 'banneredit', 'request');
		
		return array(
			'microsite_banner'	=> $this->companies_model->getMicrositeBanner($microsite_banner_id)
		);
	}
	
	public function _banners_index()
	{
		$this->load->model('banners_model');
		
		// search
		$search = $this->input->post('search', true);
		$this->registry->set('search', $search, 'request');
		// load banners
		$params = array(
			'search_by'	=> ($search) ? 'name' : false,
			'search'		=> $search,
			'filter_by'	=> 'user_ID',
			'filter'		=> $this->registry->user('user_ID')
		);
		
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'banners/banner/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->banners_model->getNBanners($params),
			'per_page'		=> $per_page
		);
		
		$this->pagination->initialize($config_pagination); 
		
		return array(
			'banners'			=> $this->banners_model->getBanners($params),
			'pagination'	=> $this->pagination->create_links()
		);
	}
	
	public function _banners_edit($banner_id)
	{
		$this->load->model('banners_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		return array(
			'banner'						=> $this->banners_model->getBanner($banner_id),
			'banners_positions'	=> $this->banners_model->getBannersPositions(),
			'banners_contracts'	=> $this->banners_model->getBannersContracts()
		);
	}
	
	public function _banners_save()
	{
		$this->load->model('banners_model');
		$banner_id = $this->input->post('bid', true);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required|xss_clean');
		$this->form_validation->set_rules('link', 'Enlace', 'trim|prep_url|xss_clean');
		
		if ($this->form_validation->run() == false) {
			$this->registry->set('action', 'edit', 'request');
		} else {
			$this->registry->set('action', 'edit', 'request');
			
			$data = array(
				'banners' => array(
					'user_ID'							=> $this->registry->user('user_ID'),
					'name'								=> $this->input->post('name'),
					'image_uri'						=> $this->input->post('image_uri'),
					'image_mime_type'			=> $this->input->post('image_mime_type'),
					'link'								=> $this->input->post('link'),
					'date_modified'				=> date('Y-m-d H:i:s')
				)
			);
			
			//($this->input->post('contract')) ? $data['banners']['banner_contract_ID'] = $this->input->post('contract');
			if ($this->input->post('position')) $data['banners']['banner_position_ID'] = $this->input->post('position');
			if ($this->input->post('contract')) $data['banners']['banner_contract_ID'] = $this->input->post('contract');
			if (!$banner_id) $data['banners']['status'] = 'pendiente';
			
			if ($banner_id = $this->banners_model->saveBanner($data, $banner_id)) {
				$this->registry->set_message(array(
					'class'		=> 'success',
				  'content'	=> 'Banner guardado correctamente.'
				));
			} else {
				$this->registry->set_message(array(
					'class'		=> 'error',
				  'content'	=> 'Error al guardar el banner.'
				));
			}
			$this->registry->set('action','edit', 'request');
			
			return array(
				'banner'						=> $this->banners_model->getBanner($banner_id),
				'banners_positions'	=> $this->banners_model->getBannersPositions()
			);
		}
	}

}

/* End of file empresa.php */
/* Location: ./application/controllers/micuenta/empresa.php */