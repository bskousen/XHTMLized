<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * FrontEnd Controller that extends CodeIgniter Controller
 *
 * This Controller must manage all the routing and security and permisons
 *
 * @since 0.5
 *
 * @package masPortales
 * @subpackage MyAccount
 */
class Account_Controller extends MP_Controller {

	/**
	 * mpFront Controller construct
	 *
	 * @access public
	 * @since 0.5
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->registry->set('environment', 'front-end', 'request');
		$this->registry->set('myaccount', true, 'request');
		
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Mi Cuenta');
		//$this->settings['account_url']		=_reg('site_url') . 'micuenta/';
		//$this->settings['base_path']			= $_SERVER{'DOCUMENT_ROOT'} . '/';
		//$this->settings['css_path']				= 'application/views/themes/default/css/';
		//$this->settings['js_path']				= 'application/views/themes/default/js/';
		//$this->settings['theme_path']			= 'application/views/themes/default/';
		//$this->settings['myaccount']			= true;
		//$this->settings['message']				= $this->session->flashdata('message');
		
		$this->load->library('cart');
		
		/*
		$this->settings['cart'] = $this->cart->contents();
		$this->settings['cart_n_items'] = $this->cart->total_items();
		$this->settings['cart_total'] = $this->cart->total();
		*/
		$this->registry->set_cart($this->cart->contents(), 'items');
		$this->registry->set_cart($this->cart->total_items(), 'n_items');
		$this->registry->set_cart($this->cart->total(), 'total');
		
		$this->user_logged();
	}
	
	public function _remap($method, $arguments = array())
	{
		global $class;
		
		$this->load->model('modules_model');
		
		$this->registry->set('section', $method, 'request');
		$this->registry->set('module', $class, 'request');
		$this->settings['module_url']	= base_url() . 'micuenta/' . $class . '/';
		
		$this->registry->set('action', (isset($arguments[0])) ? $arguments[0] : 'index', 'request');
		
		if ($this->user_logged()) {
			$this->settings['module_data'] = $this->modules_model->getModule(($method == 'index') ? $class : $method); // TODO
			//if (!$this->_have_permissions()) show_error('No tiene permisos.');
			//$this->getMenu();
		} else {
			mp_redirect('entrar');
		}
		
		$function = '_' . _reg('section') . '_' . _reg('action');
		
		if (method_exists($this, $function) and is_callable(array($this, $function))) {
		  $this->settings['data'] = $this->$function((isset($arguments[1]) ? $arguments[1] : null));
		} else {
		  show_404('method ' . $function . ' in class ' . $class . ' doesn\'t exist.');
		  //this->settings['message'] = 'NO existe el metodo.';
		}
		
		$this->columns(); // TODO
		$this->load->view('themes/default/layout', $this->settings);
	}
	
	protected function columns()
	{
		$this->load->model('ecommerce_model');
		$this->load->model('companies_model');
		
		$this->registry->set_column(
			'productos',
			$this->ecommerce_model->getProducts(
				array(
					'start'			=> 0,
					'limit'			=> 2,
					'filter_by'	=> 'p.status',
					'filter'		=> '1',
					'order_by'	=> 'RAND()'
				)
			),
			1
		);
		$this->registry->set_column(
			'empresas',
			$this->companies_model->getCompanies(
				array(
					'start'			=> 0,
					'limit'			=> 3,
					'filter_by'	=> 'status',
					'filter'		=> 'publicado',
					'order_by'	=> 'RAND()'
				)
			),
			2
		);
	}

}

/* End of file Account_Controller.php */
/* Location: ./application/core/Account_Controller.php */