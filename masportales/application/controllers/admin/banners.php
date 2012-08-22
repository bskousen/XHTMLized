<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banners extends Admin_Controller
{

	public function _index_index($params = array())
	{
		
	}
	
	public function _banner_index($params = array())
	{
		$this->load->model('banners_model');
		
		// search
		$search = $this->input->post('search', true);
		$this->registry->set('search', $search, 'request');
		
		
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'banner/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->banners_model->getNBanners($params),
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
			'banners'			=> $this->banners_model->getBanners($params),
			'pagination'	=> $this->pagination->create_links()
		);
	}
	
	public function _banner_edit($params = array())
	{
		$this->load->model('banners_model');
		$this->load->model('companies_model');
		$this->load->library('form_validation');

		$banner_id = (isset($params[1])) ? $params[1] : 0;
		return array(
			'banner'						=> $this->banners_model->getBanner($banner_id),
			'banners_positions'	=> $this->banners_model->getBannersPositions(),
			'banners_contracts'	=> $this->banners_model->getBannersContracts(),
			'companies'	=> $this->companies_model->getCompanies()
		);
	}
	
	public function _banner_save($params = array())
	{
		$banner_id = $this->input->post('bid');
		$this->load->model('banners_model');
		$this->load->model('companies_model');

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		$this->form_validation->set_message('matches', '\'%s\' y \'%s\' son distintos.');
		$this->form_validation->set_message('valid_email', 'El campo \'%s\' debe contener un email válido.');
		$this->form_validation->set_message('exact_length', 'El campo \'%s\' debe tener 9 carácteres.');
		$this->form_validation->set_message('is_unique', 'Ya existe producto con el \'%s\' indicado.');

		$this->form_validation->set_rules('name', 'Nombre del producto', 'trim|required|xss_clean');
		$this->form_validation->set_rules('image_uri', 'Imagen del producto', 'trim|required|xss_clean');
		$this->form_validation->set_rules('banner_status', 'Estado', 'trim|required|xss_clean');
		$this->form_validation->set_rules('banner-position', 'Posición', 'trim|required|xss_clean');
		$this->form_validation->set_rules('link', 'Enlace', 'trim|xss_clean');
		
		$data = array(
			'banners' => array(
				'name'								=> $this->input->post('name'),
				'image_uri'						=> $this->input->post('image_uri'),
				'image_mime_type'			=> $this->input->post('image_mime_type'),
				'link'								=> $this->input->post('link'),
				'date_modified'				=> date('Y-m-d H:i:s'),
				'banner_position_ID'				=> $this->input->post('banner-position'),
				'banner_contract_ID' => $this->input->post('banner_contract'),
				'status'				=> $this->input->post('banner_status'), 
				'company_ID'		=> $this->input->post('banner_company'), 

			)
		);
		
		//($this->input->post('contract')) ? $data['banners']['banner_contract_ID'] = $this->input->post('contract');
		//if ($this->input->post('position')) $data['banners']['banner_position_ID'] = $this->input->post('position');
		//if ($this->input->post('contract')) $data['banners']['banner_contract_ID'] = $this->input->post('contract');
		//if (!$banner_id) $data['banners']['status'] = 'activo';
		if ($this->form_validation->run() == false) {
			$this->registry->set('action', 'edit', 'request');
		} else {
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
		}
		return array(
			'banner'			=> $this->banners_model->getBanner($banner_id),
			'banners_positions'	=> $this->banners_model->getBannersPositions(),
			'banners_contracts'	=> $this->banners_model->getBannersContracts(),
			'companies'	=> $this->companies_model->getCompanies()
		);
	}
	
	public function _banner_delete($params = array())
	{
		$this->load->model('banners_model');
		$banner_id = (isset($params[1])) ? $params[1] : 0;
		
		if ($this->banners_model->deleteBanner($banner_id)) {
			$this->registry->set_message(array(
				'class'		=> 'success',
			  'content'	=> 'Banner borrado correctamente.'
			));
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al borrar el banner.'
			));
		}
		$this->registry->set('action','index', 'request');
		
		// search
		$search = $this->input->post('search', true);
		$this->registry->set('search', $search, 'request');
		
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'banner/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->banners_model->getNBanners($params),
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
			'banners'			=> $this->banners_model->getBanners($params),
			'pagination'	=> $this->pagination->create_links()
		);
	}

	public function _banner_copiar($params = null) 
	{
		$banner["banners"] = $this->banners_model->getBanner($params[1]);
		
		unset($banner["banners"]["banner_ID"]);
		unset($banner["banners"]["contract_name"]);
		unset($banner["banners"]["contract_qty"]);
		unset($banner["banners"]["contract_type"]);
		unset($banner["banners"]["position_name"]);
		unset($banner["banners"]["type_name"]);
		unset($banner["banners"]["width"]);
		unset($banner["banners"]["height"]);
		unset($banner["banners"]["prints"]);
		unset($banner["banners"]["clicks"]);
		$banner["banners"]["date_added"] = date('Y-m-d H:i:s');
		$banner["banners"]["date_modified"] = date('Y-m-d H:i:s');
		
		if($this->banners_model->saveBanner($banner)) {
			$this->registry->set_message(array(
				'class'		=> 'success',
			  'content'	=> 'Banner copiado correctamente.'
			));	
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al copiar el banner.'
			));
		}
		$this->registry->set('action','index', 'request');

		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'banner/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->banners_model->getNBanners($params),
			'per_page'		=> $per_page
		);
		
		$this->pagination->initialize($config_pagination); 
		
		$params = array(
			'start'			=> $pagination_start,
			'limit'			=> $per_page,
			//'search_by'	=> ($search) ? 'name' : false,
			//'search'		=> $search
		);
		
		return array(
			'banners'			=> $this->banners_model->getBanners($params),
			'pagination'	=> $this->pagination->create_links()
		);

	}
	
	public function _contracts_index($params = array())
	{
		$this->load->model('banners_model');
		
		return array(
			'banners_contracts'	=> $this->banners_model->getBannersContracts(),
			'pagination'				=> $this->pagination->create_links()
		);
	}
	
	public function _contracts_edit($params = array())
	{
		$this->load->model('banners_model');
		$contract_id = (isset($params[1])) ? $params[1] : 0;
		
		return array(
			'banners_contract'	=> $this->banners_model->getBannersContract($contract_id),
			'banners_contracts_types'	=> $this->banners_model->getBannersContractsTypes()
		);
	}
	
	public function _contracts_save($params = array())
	{
		$contract_id = $this->input->post('bid');
		$this->load->model('banners_model');
		
		$data = array(
			'banners_contracts' => array(
				'name'										=> $this->input->post('name'),
				'quantity'								=> ($this->input->post('contract_type') != '1') ? $this->input->post('quantity') : '1',
				'price'										=> $this->input->post('price'),
				'banner_contract_type_ID'	=> $this->input->post('contract_type')
			)
		);
		
		if ($contract_id = $this->banners_model->saveBannersContract($data, $contract_id)) {
			$this->registry->set_message(array(
				'class'		=> 'success',
			  'content'	=> 'Tarifa de banner guardada correctamente.'
			));
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al guardar la tarifa de banner.'
			));
		}
		$this->registry->set('action','edit', 'request');
		
		return array(
			'banners_contract'	=> $this->banners_model->getBannersContract($contract_id),
			'banners_contracts_types'	=> $this->banners_model->getBannersContractsTypes()
		);
	}
	
	public function _contracts_delete($params = array())
	{
		$this->load->model('banners_model');
		$contract_id = (isset($params[1])) ? $params[1] : 0;
		
		if ($this->banners_model->deleteBannersContract($contract_id)) {
			$this->registry->set_message(array(
				'class'		=> 'success',
			  'content'	=> 'Tarifa de banner borrada correctamente.'
			));
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al borrar la tarifa banner.'
			));
		}
		$this->registry->set('action','index', 'request');
		
		return array(
			'banners_contracts'	=> $this->banners_model->getBannersContracts(),
			'pagination'				=> $this->pagination->create_links()
		);
	}
	
	public function _settings_index()
	{
		$this->load->model('banners_model');
		
		return array(
			'banners_settings'	=> $this->banners_model->getBannersSetting()
		);
	}
	
	public function _settings_save()
	{
		$this->load->model('banners_model');
		$error = false;
		
		foreach ($this->input->post(null, true) as $key => $value) {
			if(!$this->banners_model->saveBannersSetting($key, $value))
				$error = true;
		}
		
		if (!$error) {
			$this->registry->set_message(array(
				'class'		=> 'success',
			  'content'	=> 'Configuración de los banner guardada correctamente.'
			));
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al guardar la configuración de los banners.'
			));
		}
		$this->registry->set('action','index', 'request');
		
		return array(
			'banners_settings'	=> $this->banners_model->getBannersSetting()
		);
	}

}

/* End of file banners.php */
/* Location: ./application/controllers/admin/banners.php */