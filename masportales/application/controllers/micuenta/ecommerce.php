<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ecommerce extends Account_Controller
{

	public function _index_index()
	{
		/*
		$this->load->model('advertisements_model');
		
		return $this->advertisements_model->getUserAdvertisements($this->registry->user('user_ID'));
		*/
	}
	
	public function _perfil_new()
	{
		$this->load->model('companies_model');
		
		if ($this->companies_model->activeEcommerce($this->registry->company('company_ID'))) {
			mp_redirect('micuenta/ecommerce');
		} else {
			mp_redirect('micuenta');
		}
	}
	
	public function _productos_index()
	{
		$this->load->model('ecommerce_model');
		
		$params = array(
			'filter_by'	=> 'company_ID',
			'filter'		=> $this->registry->company('company_ID')
		);
		
		return $this->ecommerce_model->getProducts($params);
	}
	
	public function _productos_new()
	{
		$this->load->library('form_validation');
	}
	
	public function _productos_add()
	{
		$this->load->model('ecommerce_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		$this->form_validation->set_message('matches', '\'%s\' y \'%s\' son distintos.');
		$this->form_validation->set_message('valid_email', 'El campo \'%s\' debe contener un email válido.');
		$this->form_validation->set_message('exact_length', 'El campo \'%s\' debe tener 9 carácteres.');
		$this->form_validation->set_message('is_unique', 'Ya existe producto con el \'%s\' indicado.');
		
		$this->form_validation->set_rules('name', 'Nombre del producto', 'trim|required|xss_clean');
		$this->form_validation->set_rules('slug', 'URL Amigable', 'trim|required|is_unique[products_description.slug]|xss_clean');
		$this->form_validation->set_rules('description', 'Descripción', 'trim|required|xss_clean');
		$this->form_validation->set_rules('meta_keywords', 'Descripción', 'trim|required|xss_clean');
		$this->form_validation->set_rules('meta_description', 'Descripción', 'trim|required|xss_clean');
		$this->form_validation->set_rules('price', 'Precio', 'trim|required|xss_clean');
		
		$this->form_validation->set_rules('image', 'Imagen del producto', 'trim|xss_clean');
		$this->form_validation->set_rules('model', 'Modelo', 'trim|xss_clean');
		$this->form_validation->set_rules('status', 'Estado', 'trim|numeric|xss_clean');
		$this->form_validation->set_rules('quantity', 'Cantidad', 'trim|numeric|xss_clean');
		$this->form_validation->set_rules('shipping', 'Envío', 'trim|required|xss_clean');
		$this->form_validation->set_rules('manufacturer', 'Fabricante', 'trim|xss_clean');
		
		if ($this->form_validation->run() == false) {
			$this->registry->set('action', 'new', 'request');
		} else {
			$data['product'] = array(
				'user_ID'				=> $this->registry->user('user_ID'),
				'company_ID'		=> $this->registry->company('company_ID'),
				'image'					=> $this->input->post('image'),
				'price'					=> $this->input->post('price'),
				'model' 				=> $this->input->post('model'),
				'status'				=> $this->input->post('status'),
				'quantity'			=> $this->input->post('quantity'),
				'date_added'		=> date('Y-m-d H:i:s'),
				'date_modified'	=> date('Y-m-d H:i:s')
			);
			$data['product_description'] = array(
				'name'				=> $this->input->post('name'),
				'slug'				=> $this->input->post('slug'),
				'description'	=> $this->input->post('description'),
				'meta_keywords'			=> $this->input->post('meta_keywords'),
				'meta_description'	=> $this->input->post('meta_description')
			);
			$tmp_images = array(
				'name'	=> $this->input->post('images_name'),
				'ext'		=> $this->input->post('images_ext'),
				'type'	=> $this->input->post('images_type')
			);
			$data['product_images'] = array();
			if ($tmp_images['name']) {
				foreach ($tmp_images['name'] as $key => $image_name) {
					$data['product_images'][$image_name] = array(
						'name'				=> $image_name,
						'ext'					=> $tmp_images['ext'][$key],
						'mime_type'		=> $tmp_images['type'][$key],
						'status'			=> 'publish',
						'date_added'	=> date('Y-m-d H:i:s')
					);
				}
			} else {
				$data['product_images'] = false;
			}
			$data['product_image_main'] = ($this->input->post('images_main') ? $this->input->post('images_main') : null);
			
			if ($this->ecommerce_model->addProduct($data)) {
				$this->registry->set('action', 'index', 'request');
				$params = array(
					'filter_by'	=> 'company_ID',
					'filter'		=> $this->registry->company('company_ID')
				);
				return $this->ecommerce_model->getProducts($params);
			} else {
				$this->registry->set('action', 'new', 'request');
			}
		}
	}
	
	public function _productos_edit($product_id)
	{
		$this->load->model('ecommerce_model');
		$this->load->library('form_validation');
		
		return array(
			'product' => $this->ecommerce_model->getProduct($product_id, $this->registry->company('company_ID')),
			'product_images' => $this->ecommerce_model->getProductImages($product_id)
		);
	}
	
	public function _productos_save($product_id)
	{
		$this->load->model('ecommerce_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		$this->form_validation->set_message('matches', '\'%s\' y \'%s\' son distintos.');
		$this->form_validation->set_message('valid_email', 'El campo \'%s\' debe contener un email válido.');
		$this->form_validation->set_message('exact_length', 'El campo \'%s\' debe tener 9 carácteres.');
		$this->form_validation->set_message('is_unique', 'Ya existe producto con el \'%s\' indicado.');
		
		$this->form_validation->set_rules('name', 'Nombre del producto', 'trim|required|xss_clean');
		$this->form_validation->set_rules('slug', 'URL Amigable', 'trim|required|xss_clean');
		$this->form_validation->set_rules('description', 'Descripción', 'trim|required|xss_clean');
		$this->form_validation->set_rules('meta_keywords', 'Descripción', 'trim|required|xss_clean');
		$this->form_validation->set_rules('meta_description', 'Descripción', 'trim|required|xss_clean');
		$this->form_validation->set_rules('price', 'Precio', 'trim|required|xss_clean');
		
		$this->form_validation->set_rules('image', 'Imagen del producto', 'trim|xss_clean');
		$this->form_validation->set_rules('model', 'Modelo', 'trim|xss_clean');
		$this->form_validation->set_rules('status', 'Estado', 'trim|numeric|xss_clean');
		$this->form_validation->set_rules('quantity', 'Cantidad', 'trim|numeric|xss_clean');
		$this->form_validation->set_rules('shipping', 'Envío', 'trim|required|xss_clean');
		$this->form_validation->set_rules('manufacturer', 'Fabricante', 'trim|xss_clean');
		
		if ($this->form_validation->run() == false) {
			$this->registry->set('action', 'new', 'request');
			return $this->ecommerce_model->getProduct($product_id, $this->registry->company('company_ID'));
		} else {
			$data['product'] = array(
				'user_ID'				=> $this->registry->user('user_ID'),
				'company_ID'		=> $this->registry->company('company_ID'),
				'image'					=> $this->input->post('image'),
				'price'					=> $this->input->post('price'),
				'model' 				=> $this->input->post('model'),
				'status'				=> $this->input->post('status'),
				'quantity'			=> $this->input->post('quantity'),
				'date_modified'	=> date('Y-m-d H:i:s')
			);
			
			$data['product_description'] = array(
				'name'							=> $this->input->post('name'),
				'slug'							=> $this->input->post('slug'),
				'description'				=> $this->input->post('description'),
				'meta_keywords'			=> $this->input->post('meta_keywords'),
				'meta_description'	=> $this->input->post('meta_description')
			);
			$tmp_images = array(
				'name'	=> $this->input->post('images_name'),
				'ext'		=> $this->input->post('images_ext'),
				'type'	=> $this->input->post('images_type')
			);
			
			$data['product_images'] = array();
			if ($tmp_images) {
				foreach ($tmp_images['name'] as $key => $image_name) {
					$data['product_images'][$image_name] = array(
						'name'				=> $image_name,
						'ext'					=> $tmp_images['ext'][$key],
						'mime_type'		=> $tmp_images['type'][$key],
						'status'			=> 'publish',
						'date_added'	=> date('Y-m-d H:i:s')
					);
				}
			} else {
				$data['product_images'] = false;
			}
			$data['product_image_main'] = ($this->input->post('images_main') ? $this->input->post('images_main') : null);
			
			if ($this->ecommerce_model->saveProduct($data, $product_id)) {
				$this->registry->set('action', 'index', 'request');
				$params = array(
					'filter_by'	=> 'company_ID',
					'filter'		=> $this->registry->company('company_ID')
				);
				return $this->ecommerce_model->getProducts($params);
			} else {
				$this->registry->set('action', 'new', 'request');
				return $this->ecommerce_model->getProduct($product_id, $this->registry->company('company_ID'));
			}
		}
	}
	
	public function _productos_delete($product_id)
	{
		$this->load->model('ecommerce_model');
		
		if ($this->ecommerce_model->deleteProduct($product_id)) {}
		
		$this->registry->set('action', 'index', 'request');
		$params = array(
			'filter_by'	=> 'company_ID',
			'filter'		=> $this->registry->company('company_ID')
		);
		return $this->ecommerce_model->getProducts($params);
	}
	
	public function _pedidos_index()
	{
		$this->load->model('ecommerce_model');
		
		return $this->ecommerce_model->getOrders(
			array(
				'filter_by'	=> array('o.company_ID', 'o.user_ID', 'order_type'),
				'filter'		=> array($this->registry->company('company_ID'), $this->registry->user('user_ID'), 'ecommerce')
			)
		);
	}
	
	public function _pedidos_edit($order_id)
	{
		$this->load->model('ecommerce_model');
		$this->load->library('form_validation');
		
		return array(
			'order'						=> $this->ecommerce_model->getOrder(array(
				'filter_by'	=> array('order_ID', 'o.company_ID', 'o.user_ID', 'order_type'),
				'filter'		=> array($order_id, $this->registry->company('company_ID'), $this->registry->user('user_ID'), 'ecommerce')
			)),
			'order_address'		=> array(
				'shipping_address' => $this->ecommerce_model->getOrderShippingAddress(array(
					'filter_by'	=> array('order_ID', 'company_ID', 'user_ID', 'order_type'),
					'filter'		=> array($order_id, $this->registry->company('company_ID'), $this->registry->user('user_ID'), 'ecommerce')
				)),
				'payment_address' => $this->ecommerce_model->getOrderPaymentAddress(array(
					'filter_by'	=> array('order_ID', 'company_ID', 'user_ID', 'order_type'),
					'filter'		=> array($order_id, $this->registry->company('company_ID'), $this->registry->user('user_ID'), 'ecommerce')
				))
			),
			/*
			 $this->ecommerce_model->getOrderAddress(array(
				'company_ID'	=> $this->registry->company('company_ID'),
				'user_ID'			=> $this->registry->user('user_ID'),
				'site_ID'			=> site_id()
			), $order_id),
			*/
			'order_products'	=> $this->ecommerce_model->getOrderProducts(array(
					'filter_by'	=> array('o.order_ID', 'company_ID', 'user_ID', 'order_type'),
					'filter'		=> array($order_id, $this->registry->company('company_ID'), $this->registry->user('user_ID'), 'ecommerce')
				)),
			'order_history'		=> $this->ecommerce_model->getOrderHistory(array(
					'filter_by'	=> array('o.order_ID', 'company_ID', 'user_ID', 'order_type'),
					'filter'		=> array($order_id, $this->registry->company('company_ID'), $this->registry->user('user_ID'), 'ecommerce')
				))
		);
	}
	
	public function _config_index()
	{
	}
	
	public function _config_payment($gateway)
	{
		$this->load->model('ecommerce_model');
		
		// check if
		if ($gateway !== null) {
			// we are in any of the payment gateways forms
			$this->load->library('form_validation');
			$this->settings['payment_gateway'] = $gateway;
			
			if ($gateway === 'save') {
				// we are going to save a payment gateway
				$form_gateaway = $this->input->post('pgwy', true);
				
				$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
				
				$gateway = $this->_save_payment_gateway($form_gateaway);
				
			} else {
				// we are going to load the payment gateaway form
			}
			$this->settings['payment_gateway'] = $gateway;
		} else {
			// or we are in the index of payment gateways
			$this->settings['payment_gateway'] = false;
			return $this->ecommerce_model->getCompanyPaymentGateways($this->registry->company('company_ID'));
		}
	}
	
	private function _save_payment_gateway($gateway)
	{
		// set general form validation rules
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		
		// set the form validations rules for each payment gateway
		switch ($gateway) {
			case 'banktransfer':
				$this->form_validation->set_message('exact_length', '\'%s\' debe tener un n. de cuenta válido en el formato indicado.');
				
				$this->form_validation->set_rules('bankname', 'Nombre del banco', 'trim|required|xss_clean');
				$this->form_validation->set_rules('cccnumber', 'Número de cuenta', 'trim|required|exact_length[23]|xss_clean');
				$this->form_validation->set_rules('status', 'Estado', 'trim|numeric|xss_clean');
				$this->form_validation->set_rules('message', 'Descripción', 'trim|xss_clean|strip_tags');
				break;
			default:
				break;
		}
		
		if ($this->form_validation->run() == false) {
			return 'banktransfer';
		} else {
			$gateway_data = $this->ecommerce_model->getPaymentGateway($gateway);
			$data['keys'] = array(
				'payment_gateway_ID'	=> $gateway_data['payment_gateway_ID'],
				'company_ID'					=> $this->registry->company('company_ID'),
				'keyword'							=> $gateway_data['keyword']
			);
			$data['settings'] = array(
				'bankname'						=> $this->input->post('bankname'),
				'cccnumber'						=> $this->input->post('cccnumber'),
				'status'							=> $this->input->post('status'),
				'message'							=> $this->input->post('message')
			);
			
			if ($this->ecommerce_model->savePaymentGatewayConfig($data)) {
				//this->settings['action'] = 'index';
				
			} else {
				//this->settings['action'] = 'edit';
			}
			
		  return false;
		}
	}
	
	public function _config_shipping($method)
	{
		$this->load->model('ecommerce_model');
		
		// check if
		if ($method !== null) {
			// we are in any of the shipping method forms
			$this->load->library('form_validation');
			$this->settings['shipping_method'] = $method;
			
			if ($method === 'save') {
				// we are going to save a shipping method
				$form_method = $this->input->post('shng', true);
				
				$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
				
				$method = $this->_save_shipping_method($form_method);
				
			} else {
				// we are going to load the shipping method form
			}
			$this->settings['shipping_method'] = $method;
		} else {
			// or we are in the index of shipping methods
			$this->settings['shipping_method'] = false;
			return $this->ecommerce_model->getCompanyShippingMethods($this->registry->company('company_ID'));
		}
	}
	
	private function _save_shipping_method($method)
	{
		// set general form validation rules
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		
		// set the form validations rules for each shipping method
		switch ($method) {
			case 'flatrate':
				$this->form_validation->set_message('exact_length', '\'%s\' debe tener un n. de cuenta válido en el formato indicado.');
				
				$this->form_validation->set_rules('rate', 'Tarifa envío', 'trim|required|xss_clean');
				$this->form_validation->set_rules('time', 'Tiempo de entrega', 'trim|required|xss_clean');
				$this->form_validation->set_rules('status', 'Estado', 'trim|numeric|xss_clean');
				$this->form_validation->set_rules('message', 'Descripción', 'trim|xss_clean|strip_tags');
				break;
			default:
				break;
		}
		
		if ($this->form_validation->run() == false) {
			return 'flatrate';
		} else {
			$method_data = $this->ecommerce_model->getShippingMethod($method);
			$data['keys'] = array(
				'shipping_method_ID'	=> $method_data['shipping_method_ID'],
				'company_ID'					=> $this->registry->company('company_ID'),
				'keyword'							=> $method_data['keyword']
			);
			$data['settings'] = array(
				'rate'		=> $this->input->post('rate'),
				'time'		=> $this->input->post('time'),
				'status'	=> $this->input->post('status'),
				'message'	=> $this->input->post('message')
			);
			
			if ($this->ecommerce_model->saveShippingMethodConfig($data)) {
				//this->settings['action'] = 'index';
			} else {
				//this->settings['action'] = 'edit';
			}
			
		  return false;
		}
	}

}

/* End of file ecommerce.php */
/* Location: ./application/controllers/micuenta/ecommerce.php */