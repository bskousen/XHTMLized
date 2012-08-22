<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BasicAds extends Admin_Controller
{

	public function _index_index($params = array())
	{
		$this->load->model('basicads_model');
		
		// search
		$search = $this->input->post('search', true);
		$this->registry->set('search', $search, 'request');
		
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'index/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->basicads_model->getNBasicAds(),
			'per_page'		=> $per_page
		);
		
		$this->pagination->initialize($config_pagination); 
		
		$params = array(
			'start'			=> $pagination_start,
			'limit'			=> $per_page,
			'search_by'	=> ($search) ? 'title' : false,
			'search'		=> $search
		);
		
		return array(
			'basicads'		=> $this->basicads_model->getBasicAds($params),
			'pagination'	=> $this->pagination->create_links()
		);
	}
	
	public function _index_edit($params = array())
	{
		$this->load->model('basicads_model');
		$basicad_id = (isset($params[1])) ? $params[1] : 0;
		
		return array(
			'basicad'					=> $this->basicads_model->getBasicAd($basicad_id),
			'basicad_images'	=> $this->basicads_model->getBasicAdImages($basicad_id),
			'categories'			=> $this->basicads_model->getBasicAdsCategories()
		);
	}
	
	public function _index_save($params = array())
	{
		$data = array();
		$basic_id = $this->input->post('bid');
		$this->load->model('basicads_model');
		
		$data['basicad'] = array(
			'user_ID'					=> $this->registry->user('user_ID'),
		  'title'						=> $this->input->post('title'),
		  'slug'						=> $this->input->post('slug'),
		  'content'					=> $this->input->post('content'),
		  'price'						=> $this->input->post('price'),
		  'status'					=> $this->input->post('status'),
		  'date_modified' 	=> date('Y-m-d H:i:s'),
		  'category_ID'			=> $this->input->post('category')
		);
		$image_main = $this->input->post('image_main', true);
		$tmp_images = array(
		  'name'	=> $this->input->post('images_name', true),
		  'uri'		=> $this->input->post('images_uri', true),
		  'type'	=> $this->input->post('images_type', true)
		);
		$data['basicad_images'] = array();
		if ($tmp_images['name']) {
		  foreach ($tmp_images['name'] as $key => $image_name) {
		  	$data['basicad_images'][$image_name] = array(
		  		'name'				=> $image_name,
		  		'uri'					=> $tmp_images['uri'][$key],
		  		'mime_type'		=> $tmp_images['type'][$key],
		  		'status'			=> 'publish',
		  		'main'				=> ($image_name == $image_main) ? 1 : 0,
		  		'date_added'	=> date('Y-m-d H:i:s')
		  	);
		  }
		} else {
		  $data['basicad_images'] = false;
		}
		
		unset($data['basicad']['umod'], $data['basicad']['bid']);
		
		if ($basicad_id = $this->basicads_model->saveBasicAd($data, $basic_id)) {
			$this->registry->set_message(array(
				'class'		=> 'success',
			  'content'	=> 'Anuncio guardado correctamente.'
			));
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al guardar el anuncio.'
			));
		}
		$this->registry->set('action','edit', 'request');
		
		return array(
			'basicad'					=> $this->basicads_model->getBasicAd($basicad_id),
			'basicad_images'	=> $this->basicads_model->getBasicAdImages($basicad_id),
			'categories'			=> $this->basicads_model->getBasicAdsCategories()
		);
	}
	
	public function _index_delete($params = array())
	{
		$this->load->model('basicads_model');
		$basicad_id = (isset($params[1])) ? $params[1] : 0;
		
		if ($this->basicads_model->deleteBasicAd($basicad_id)) {
			$this->registry->set_message(array(
				'class'		=> 'success',
			  'content'	=> 'Anuncio borrado correctamente.'
			));
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al borrar el anuncio.'
			));
		}
		$this->registry->set('action','index', 'request');
		
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'index/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->basicads_model->getNBasicAds(),
			'per_page'		=> $per_page
		);
		
		$this->pagination->initialize($config_pagination); 
		
		$params = array(
			'start'			=> $pagination_start,
			'limit'			=> $per_page,
			'search_by'	=> ($search) ? 'title' : false,
			'search'		=> $search
		);
		
		return array(
			'basicads'		=> $this->basicads_model->getBasicAds($pagination_start, $per_page),
			'pagination'	=> $this->pagination->create_links()
		);
	}

}

/* End of file basicads.php */
/* Location: ./application/controllers/admin/basicads.php */