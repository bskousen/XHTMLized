<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web extends Front_Controller {

	public function _remap($method, $arguments = array())
	{
		global $class;
		
		$this->load->model('ecommerce_model');
		$this->load->model('companies_model');
		$this->load->library('form_validation');
		
		$this->registry->set('module', $class, 'request');
		
		/*
		echo '<pre>';
		print_r($class);
		echo '</pre>';
		echo '<pre>';
		print_r($method);
		echo '</pre>';
		echo '<pre>';
		print_r($arguments);
		echo '</pre>';
		*/
		if ($method == 'index') {
			show_404();
		} elseif ($company_id = $this->companies_model->slugFor($method)) {
			(isset($arguments[0])) ? $page = $arguments[0] : $page = 'index';
			
			// TODO: create a function to get the banner.
			$params = array(
				'limit'			=> '1',
			  'filter_by'	=> 'company_ID',
			  'filter'		=> $company_id
			);
			$banner = $this->companies_model->getMicrositeBanners($params);
			
			$data = array(
				'company'					=> $this->companies_model->getCompany($company_id),
				'company_images'	=> $this->companies_model->getCompanyImages($company_id),
				'microsite_pages'	=> $this->companies_model->getCompanyMicrosite($company_id),
				'banner'					=> $banner[0]
			);
		} else {
			show_404();
		}
		/*
		echo '<pre>';
		print_r($page);
		echo '</pre>';
		*/
		$this->load->view('microsites/default/layout', $data);
	}
	
	

}

/* End of file web.php */
/* Location: ./application/controllers/web.php */