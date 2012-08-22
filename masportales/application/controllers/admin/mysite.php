<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mysite extends Admin_Controller
{

	public function _index_index($params = array())
	{
		
	}
	
	public function _config_index($params = array())
	{
		$data['form_action'] = 'config/save';
		
		return $data;
	}
	
	public function _config_save($params = array())
	{
		$settings = array();
		$this->load->model('mp_model');
		
		foreach ($this->input->post('site') as $setting => $value) {
			$settings[$setting] = $value;
		}
		if ($this->mp_model->saveSiteSettings($settings)) {
			$this->registry->set_message(array(
				'class'		=> 'success',
			  'content'	=> 'Configuración guardada correctamente.'
			));
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al guardar la configuración.'
			));
		}
		$this->registry->set('action','index', 'request');
		
		return array(
			'form_action'	=> 'config/save'
		);
	}
	
	public function _payment_index($params = array())
	{
		$this->load->model('ecommerce_model');
		
		return array(
			'payment_gateways' => $this->ecommerce_model->getPaymentGateways(false, 0)
		);
	}
	
	public function _payment_edit($params = array())
	{
		$this->load->model('ecommerce_model');
		$gateway_id = (isset($params[1])) ? $params[1] : 0;
		
		return array(
			'payment_gateway' => $this->ecommerce_model->getPaymentGatewayConfig($gateway_id, site_id())
		);
	}
	
	public function _payment_save($params = array())
	{
		$this->load->model('ecommerce_model');
		
		$payment_gateway_settings = $this->input->post(null, true);
		$gateway_id = $payment_gateway_settings['bid'];
		unset($payment_gateway_settings['bid']);
		foreach ($payment_gateway_settings as $key => $value) {
			$payment_gateway[$key] = $value;
		}
		
		if($this->ecommerce_model->savePaymentGatewayConfig($payment_gateway, $gateway_id)) {
			$this->registry->set_message(array(
				'class'		=> 'success',
			  'content'	=> 'Configuración guardada correctamente.'
			));
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al guardar la configuración.'
			));
		}
		$this->registry->set('action','edit', 'request');
		
		return array(
			'payment_gateway' => $this->ecommerce_model->getPaymentGatewayConfig($gateway_id, site_id())
		);
	}
	
	public function _seo_index($params = array())
	{
		$data['form_action'] = 'seo/save';
		
		return $data;
	}
	
	public function _seo_save($params = array())
	{
		$settings = array();
		$this->load->model('mp_model');
		
		foreach ($this->input->post('site') as $setting => $value) {
			$settings[$setting] = $value;
		}
		if ($this->mp_model->saveSiteSettings($settings)) {
			$this->registry->set_message(array(
				'class'		=> 'success',
			  'content'	=> 'Configuración guardada correctamente.'
			));
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al guardar la configuración.'
			));
		}
		$this->registry->set('action','index', 'request');
		$this->registry->load_site_settings( explode('.', $_SERVER['HTTP_HOST']) );
		
		return array(
			'form_action'	=> 'seo/save'
		);
	}

}

/* End of file mysite.php */
/* Location: ./application/controllers/admin/mysite.php */