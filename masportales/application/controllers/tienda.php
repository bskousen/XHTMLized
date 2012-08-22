<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tienda extends Front_Controller {

	public function _remap($method, $arguments = array())
	{
		global $class;
		
		$this->load->model('ecommerce_model');
		$this->load->library('form_validation');
		
		$this->registry->set('module', $class, 'request');
		$this->settings['module_url']	= base_url() . $class . '/';
		
		if ($method == 'index' and !$arguments) {
			$this->registry->set('section', 'productos', 'request');
			$this->registry->set('item_id', false, 'request');
		} elseif ($product_id = $this->ecommerce_model->slugFor($method)) {
			$this->registry->set('section', 'producto', 'request');
			$this->registry->set('item_id', $product_id, 'request');
		} elseif (method_exists($this, '_' . $method) and is_callable(array($this, '_' . $method))) {
			$this->registry->set('section', $method, 'request');
			$item_id = (isset($arguments[0]) ? $arguments[0] : (($this->input->post('cid')) ? $this->input->post('cid') : null));
			$this->registry->set('item_id', $item_id, 'request');
		} else {
			show_404();
		}
		
		$function = '_' . $this->registry->request('section');
		if (method_exists($this, $function)) {
			$this->settings['data'] = $this->$function($this->registry->request('item_id'));
		} else {
			show_404();
		}
		$this->columns(); // TODO
		$this->load->view('themes/default/layout', $this->settings);
	}
	
	public function _productos()
	{
		$params = array(
			'start'			=> 0,
			'limit'			=> 20,
			'filter_by'	=> 'p.status',
			'filter'		=> '1'
		);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Productos');
		$this->registry->set_meta('keywords', $this->registry->site('ecommerce_keywords'));
		$this->registry->set_meta('description', $this->registry->site('ecommerce_description'));
		return array(
			'products'			=> $this->ecommerce_model->getProducts($params),
			'search_query'	=> false
		);
	}
	
	public function _search()
	{
		$search_query = $this->input->post('searchquery', true);
		
		$params_products = array(
			'start'			=> 0,
			'limit'			=> 10,
			'search_by'	=> ($search_query) ? array('pd.name', 'pd.description') : false,
			'search'		=> array($search_query, $search_query),
			'filter_by'	=> 'p.status',
			'filter'		=> '1'
		);
		
		$products	= $this->ecommerce_model->getProducts($params_products);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Productos . Resultado para la búsqueda: ' . $search_query);
		$this->registry->set_meta('keywords', $this->registry->site('ecommerce_keywords'));
		$this->registry->set_meta('description', $this->registry->site('ecommerce_description'));
		$this->registry->set('section', 'productos', 'request');
		
		return array(
			'products'			=> $products,
			'search_query'	=> $search_query
		);
	}
	
	public function _producto($product_id)
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
		
		if ($this->input->post('pid')) {
			if (check_captcha()) {
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
		}
		$product_data = $this->ecommerce_model->getProduct($product_id);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Productos . ' . $product_data['name']);
		$this->registry->set_meta('keywords', $product_data['meta_keywords']);
		$this->registry->set_meta('description', $product_data['meta_description']);
		
		return array(
			'product'					=> $product_data,
			'product_images'	=> $this->ecommerce_model->getProductImages($product_id),
			'comments'				=> $this->ecommerce_model->getProductComments($product_id),
			'captcha'					=> $cap
		);
	}
	
	private function _save_comment()
	{
		$data = array();
		
		$data['comment'] = array(
			'product_ID'			=> $this->input->post('pid'),
			'author'					=> $this->input->post('name'),
			'author_email'		=> $this->input->post('email'),
			'author_url'			=> $this->input->post('web'),
			'author_IP'				=> $this->input->ip_address(),
			'date_added'			=> date('Y-m-d H:i:s'),
			'content' 				=> $this->input->post('message'),
			'approved'				=> 0,
			'agent'						=> $this->input->user_agent()
		);
		
		if ($this->registry->user()) {
			$data['comment']['user_ID'] = $this->registry->user('user_ID');
		}
		
		if ($this->ecommerce_model->addProductComment($data)) {
			//$this->session->set_flashdata('message', 'Nuevo artículo guardado correctamente.');
			//mp_redirect('admin/blog/');
		} else {
			//$this->session->set_flashdata('message', 'Error al guardar el nuevo artículo.');
			//mp_redirect('admin/blog/article/edit');
		}
	}
	
	public function _carrito()
	{
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Productos . Carrito de la Compra');
		return array(
			'cart_products_by_company'	=> $this->ecommerce_model->getCartProductsByCompany()
		);
	}
	
	public function _checkout($company_id)
	{
		if ($company_id) {
			$company_cart = $this->ecommerce_model->getCartProductsByCompany($company_id);
		} else {
			$company_cart = false;
		}
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Productos');
		return array(
			'company_cart'	=> $company_cart,
			'shipping'			=> $this->ecommerce_model->getCompanyShippingMethods($company_id),
			'payment'				=> $this->ecommerce_model->getCompanyPaymentGateways($company_id)
		);
	}
	
	public function _pedido()
	{
		/*
		echo '<pre>';
		print_r($this->input->post());
		echo '</pre>';
		*/
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Productos');
		$company_id = ($this->input->post('cid')) ? $this->input->post('cid') : 'hello';
		if ($company_id) {
			$company_cart = $this->ecommerce_model->getCartProductsByCompany($company_id);
		} else {
		  $company_cart = false;
		}
		
		//echo '<p>Company ID: ' . $company_id . '</p>';
		
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
			
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		
		$this->form_validation->set_rules('shipping_name', 'Nombre de envío', 'trim|required|xss_clean');
		$this->form_validation->set_rules('shipping_surname', 'Apellido de envío', 'trim|required|xss_clean');
		$this->form_validation->set_rules('shipping_address', 'Dirección de envío', 'trim|required|xss_clean');
		$this->form_validation->set_rules('shipping_zipcode', 'Código postal de envío', 'trim|required|xss_clean');
		$this->form_validation->set_rules('shipping_city', 'Ciudad de envío', 'trim|required|xss_clean');
		$this->form_validation->set_rules('shipping_state', 'Provincia de envío', 'trim|required|xss_clean');
		$this->form_validation->set_rules('shipping_country', 'Pais de envío', 'trim|required|xss_clean');
		$this->form_validation->set_rules('shipping_phone', 'Teléfono de envío', 'trim|required|xss_clean');
		
		$this->form_validation->set_rules('payment_name', 'Nombre de facturación', 'trim|required|xss_clean');
		$this->form_validation->set_rules('payment_surname', 'Apellido de facturación', 'trim|required|xss_clean');
		$this->form_validation->set_rules('payment_address', 'Dirección de facturación', 'trim|required|xss_clean');
		$this->form_validation->set_rules('payment_zipcode', 'Código postal de facturación', 'trim|required|xss_clean');
		$this->form_validation->set_rules('payment_city', 'Ciudad de facturación', 'trim|required|xss_clean');
		$this->form_validation->set_rules('payment_state', 'Provincia de facturación', 'trim|required|xss_clean');
		$this->form_validation->set_rules('payment_country', 'Pais de facturación', 'trim|required|xss_clean');
		$this->form_validation->set_rules('payment_nif', 'N.I.F. de facturación', 'trim|required|xss_clean');
		
		$this->form_validation->set_rules('payment_gateway', 'Forma de pago', 'trim|is_numeric|required');
		$this->form_validation->set_rules('shipping_method', 'Método de envío', 'trim|is_numeric|required');
		
		if ($this->form_validation->run() == false) {
		  $this->registry->set('section', 'checkout', 'request');
		  return array(
				'company_cart'	=> $company_cart,
				'shipping'			=> $this->ecommerce_model->getCompanyShippingMethods($company_id),
				'payment'				=> $this->ecommerce_model->getCompanyPaymentGateways($company_id)
			);
		} else {
			// delete items in this order in the cart
		  if ($company_cart) {
		  	foreach ($company_cart['products'] as $product) {
		  		$this->cart->update(array('rowid' => $product['rowid'], 'qty' => 0));
		  	}
		  }
			return array(
				'order_data'		=> $this->input->post(),
				'company_cart'	=> $company_cart,
				'shipping'			=> $this->ecommerce_model->getCompanyShippingMethods($company_id),
				'payment'				=> $this->ecommerce_model->getCompanyPaymentGateways($company_id)
			);
		}
	}
	
	public function _confirm($company_id)
	{
		$data_tmp = $this->input->post(null, true);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Productos');
		
		$this->load->model('companies_model');
		
		$company_data = $this->companies_model->getCompany($company_id);
		$payment_gateway = $this->ecommerce_model->getPaymentGateway($data_tmp['payment_gateway']);	// TODO
		$shipping_method = $this->ecommerce_model->getPaymentGateway($data_tmp['shipping_method']);	// TODO
		
		echo '<pre>';
		print_r($payment_gateway);
		echo '</pre>';
		
		$data = array(
			'order' => array(
				'company_id'					=> $company_id,
				'user_ID'							=> $this->companies_model->getCompanyOwner($company_id),
				'customer_ID'					=> $this->registry->user('user_ID'),
				'customer_email'			=> $this->registry->user('email'),
				'site_ID'							=> ($this->registry->site()) ? _reg('site_id') : 0,	// TODO
				'invoice_ID'					=> 0,																								// TODO
				'shipping_method_ID'	=> $data_tmp['shipping_method'],
				'payment_gateway_ID'	=> $data_tmp['payment_gateway'],
				'shipping_address_ID'	=> $data_tmp['shipment_address_ID'],
				'payment_address_ID'	=> $data_tmp['payment_address_ID'],
				'comment'							=> '',																							// TODO
				'coupon_ID'						=> 0,																								// TODO
				'order_status_ID'			=> 1,																								// TODO
				'language_ID'					=> 1,																								// TODO
				'date_added'					=> date('Y-m-d H:i:s'),
				'date_modified'				=> date('Y-m-d H:i:s'),
				'ip'									=> $this->input->ip_address()
			),
			'shipment_address' => ($data_tmp['shipment_address_ID']) ? false : array(
				'customer_ID'	=> $this->registry->user('user_ID'),
				'firstname'		=> $data_tmp['shipping_name'],
				'lastname'		=> $data_tmp['shipping_surname'],
				'address'			=> $data_tmp['shipping_address'],
				'zipcode'			=> $data_tmp['shipping_zipcode'],
				'city'				=> $data_tmp['shipping_city'],
				'state'				=> $data_tmp['shipping_state'],
				'country' 		=> $data_tmp['shipping_country'],
				'phone'				=> $data_tmp['shipping_phone']
			),
			'payment_address' => ($data_tmp['payment_address_ID']) ? false : array(
				'customer_ID'	=> $this->registry->user('user_ID'),
				'firstname'		=> $data_tmp['payment_name'],
				'lastname'		=> $data_tmp['payment_surname'],
				'address'			=> $data_tmp['payment_address'],
				'zipcode'			=> $data_tmp['payment_zipcode'],
				'city'				=> $data_tmp['payment_city'],
				'state'				=> $data_tmp['payment_state'],
				'country' 		=> $data_tmp['payment_country'],
				'nif'					=> $data_tmp['payment_nif']
			)
		);
		
		$order_subtotal = 0;
		$order_discount = 0;
		$order_shipping = 0;
		$order_tax = 0;
		$order_total = 0;
		
		foreach ($data_tmp['products_id'] as $key => $product_id) {
			$product_tmp = $this->ecommerce_model->getProduct($product_id, $company_id);
			$data['order_products'][$product_id] = array(
				'product_ID'	=> $product_id,
				'name'				=> $product_tmp['name'],
				'model'				=> $product_tmp['model'],
				'price'				=> $product_tmp['price'],
				'quantity'		=> $data_tmp['products_quantity'][$key],
				'tax_ID'			=> 0,
				'tax'					=> 0,
				'total'				=> floatval($product_tmp['price'] * $data_tmp['products_quantity'][$key])
			);
			
			$order_total = $order_total + ($product_tmp['price'] * $data_tmp['products_quantity'][$key]);
		}
		
		$data['order']['order_subtotal']	= $order_subtotal;	// TODO
		$data['order']['order_discount']	= $order_discount;	// TODO
		$data['order']['order_shipping']	= $order_shipping;	// TODO
		$data['order']['order_tax']				= $order_tax;				// TODO
		$data['order']['order_total']			= $order_total;
		
		if ($order_id = $this->ecommerce_model->addOrder($data)) {
			
			$datae											= $data['order'];
			$datae['order_id']					= $order_id;
			$datae['customer_phone']		= $data['shipment_address']['phone'];
			$datae['title']							= 'Pedido en la tienda ' . $company_data['name'];
			$datae['store_url']					=_reg('site_url') . 'empresas/' . $company_data['slug'];
			$datae['store_name']				= $company_data['name'];
			$datae['logo']							=_reg('site_url') . 'usrs/empresas/' . pathinfo($company_data['logo'], PATHINFO_FILENAME) . '_96x96.' . strtolower(pathinfo($company_data['logo'], PATHINFO_EXTENSION));
			$datae['date_added']				= strftime('%d/%m/%G a las %T', strtotime($data['order']['date_added']));
			$datae['payment_method']		= $payment_gateway['name'];
			$datae['shipping_method']		= $shipping_method['name'];
			$datae['shipment_address']	= array($data['shipment_address']);
			$datae['payment_address']		= array($data['payment_address']);
			foreach ($data['order_products'] as $order_product) {
				$datae['order_products'][] = array(
					'product_ID'	=> $order_product['product_ID'],
					'name'				=> $order_product['name'],
					'model'				=> $order_product['model'],
					'price'				=> number_format($order_product['price'], 2, ',', '.') . ' €',
					'quantity'		=> $order_product['quantity'],
					'tax'					=> number_format($order_product['tax'], 2, ',', '.') . ' €',
					'total'				=> number_format($order_product['total'], 2, ',', '.') . ' €'
				);
			}
			$datae['order_totals']			= array(
				array('total_title' => 'Subtotal', 'total_text' => number_format($order_subtotal, 2, ',', '.') . ' €'),
				array('total_title' => 'Descuento', 'total_text' =>  number_format($order_discount, 2, ',', '.') . ' €'),
				array('total_title' => 'Envío', 'total_text' => number_format($order_shipping, 2, ',', '.') . ' €'),
				array('total_title' => 'Impuestos', 'total_text' => number_format($order_tax, 2, ',', '.') . ' €'),
				array('total_title' => 'Total', 'total_text' => number_format($order_total, 2, ',', '.') . ' €')
			);
			
			$datae['text_greeting']					= 'Gracias por su compra en ' . $company_data['name'];
			$datae['text_order_detail']			= 'Detalles del Pedido';
			$datae['text_order_id']					= 'Número del Pedido:';
			$datae['text_date_added']				= 'Fecha del Pedido:';
			$datae['text_payment_method']		= 'Forma de pago:';
			$datae['text_shipping_method']	= 'Método de envío:';
			$datae['text_email']						= 'Email del cliente:';
			$datae['text_phone']						= 'Teléfono del cliente:';
			$datae['text_ip']								= 'IP del cliente:';
			$datae['text_shipping_address']	= 'Dirección de Envío';
			$datae['text_payment_address']	= 'Dirección de Facturación';
			$datae['column_product']				= 'Concepto';
			$datae['column_model']					= 'Modelo';
			$datae['column_price']					= 'Precio';
			$datae['column_quantity']				= 'Cantidad';
			$datae['column_total']					= 'Total';
			$datae['text_comment']					= 'Comentarios';
			$datae['text_invoice']					= 'Factura';
			$datae['text_powered_by']				= 'franquicia de +Portales';
		
			$this->ecommerce_model->sendOrderEmail($datae);
			
			$order									= $data['order'];
			$order['order_id']			= $order_id;
			$order['company_name']	= $company_data['name'];
			$order['logo']					=_reg('site_url') . 'usrs/empresas/' . pathinfo($company_data['logo'], PATHINFO_FILENAME) . '_96x96.' . strtolower(pathinfo($company_data['logo'], PATHINFO_EXTENSION));
			$order['date_added']				= strftime('%d/%m/%G a las %T', strtotime($data['order']['date_added']));
			
			unset($data);
			
			return array(
				'order_received'	=> true,
				'order'						=> $order,
			);
		} else {
		  $this->registry->set('section', 'fallido', 'request');
		}
	}

}

/* End of file tienda.php */
/* Location: ./application/controllers/tienda.php */