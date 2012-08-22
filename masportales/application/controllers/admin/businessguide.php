<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BusinessGuide extends Admin_Controller
{

	public function _index_index($params = array())
	{
		
	}
	
	public function _companies_index($params = array())
	{
		$this->load->model('companies_model');
		
		// search
		$search = $this->input->post('search', true);
		$this->registry->set('search', $search, 'request');
		$params = array(
			'search_by'	=> ($search) ? 'name' : false,
			'search'		=> $search
		);
		
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'companies/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->companies_model->getNCompanies($params),
			'per_page'		=> $per_page
		);
		
		$this->pagination->initialize($config_pagination); 
		
		return array(
			'companies'		=> $this->companies_model->getCompanies($params),
			'pagination'	=> $this->pagination->create_links()
		);
	}
	
	public function _companies_edit($params = array())
	{
		$this->load->model('companies_model');
		$company_id = (isset($params[1])) ? $params[1] : 0;
		
		return array(
			'company'	=> $this->companies_model->getCompany($company_id)
		);
	}
	
	public function _companies_save($params = array())
	{
		$data = array();
		$company_id = $this->input->post('cid');
		$this->load->model('companies_model');
		
		$data['company'] = $this->input->post();
		$data['company']['logo'] = $this->input->post('logo');
		$data['company']['logo_mime_type'] = $this->input->post('logo_mime_type');
		$data['company']['date_modified'] = date('Y-m-d H:i:s');
		$data['company']['status'] = 'publicado';
		
		unset($data['company']['umod'], $data['company']['cid']);
		
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
		
		if ($company_id = $this->companies_model->saveCompany($data, $company_id)) {
			$this->registry->set_message(array(
				'class'		=> 'success',
			  'content'	=> 'Empresa guardada correctamente.'
			));
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al guardar la empresa.'
			));
		}
		$this->registry->set('action','edit', 'request');
		
		return array(
			'company'	=> $this->companies_model->getCompany($company_id)
		);
	}
	
		public function _companies_delete($params = array())
	{
		$this->load->model('companies_model');
		$company_id = (isset($params[1])) ? $params[1] : 0;
		if ($this->companies_model->getCompany($company_id)) {
			$company_data = $this->companies_model->getCompany($company_id);

			$this->_delete_files($company_data["logo"]);
		
			if ($this->companies_model->deleteCompany($company_id)) {
				if($this->companies_model->getCompanyImages($company_id)) {
					foreach ($this->companies_model->getCompanyImages($company_id) as $key => $value) {
						$this->_delete_files($value["uri"]);
					}
					$this->companies_model->deleteCompanyImages($company_id);
				}
				$this->registry->set_message(array(
					'class'		=> 'success',
				  'content'	=> 'Empresa borrada correctamente.'
				));
			} 
		}else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al borrar la empresa.'
			));
		}
		$this->registry->set('action','index', 'request');
		
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'companies/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->companies_model->getNCompanies($params),
			'per_page'		=> $per_page
		);
		
		$this->pagination->initialize($config_pagination); 

		return array(
			'companies'		=> $this->companies_model->getCompanies($params),
			'pagination'	=> $this->pagination->create_links()
		);
	}

	public function _products_index($params = array())
	{
		
	}

	private function _delete_files($file)
	{
		$file = explode('.', $file);
		unlink(_reg('base_path') ."usrs/empresas/".$file[0].".".$file[1]);
		unlink(_reg('base_path') ."usrs/empresas/".$file[0]."_96x96.".$file[1]);
		unlink(_reg('base_path') ."usrs/empresas/".$file[0]."_210x96.".$file[1]);
		unlink(_reg('base_path') ."usrs/empresas/".$file[0]."_210x210.".$file[1]);
	}

}

/* End of file businessguide.php */
/* Location: ./application/controllers/admin/businessguide.php */