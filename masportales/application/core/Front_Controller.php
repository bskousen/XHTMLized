<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * FrontEnd Controller that extends CodeIgniter Controller
 *
 * This Controller must manage all the routing and security and permisons
 *
 * @since 0.5
 *
 * @package masPortales
 * @subpackage FrontEnd
 */
class Front_Controller extends MP_Controller {

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
		
		$this->load->library('cart');
		$this->registry->set_cart($this->cart->contents(), 'items');
		$this->registry->set_cart($this->cart->total_items(), 'n_items');
		$this->registry->set_cart($this->cart->total(), 'total');
		
		
		$this->user_logged();
	}
	
	protected function columns()
	{
		$this->load->model('ecommerce_model');
		$this->load->model('companies_model');
		$this->load->model('basicads_model');
		
		$this->registry->set_column(
			'productos',
			$this->ecommerce_model->getProducts(
				array(
					'start'			=> 0,
					'limit'			=> 10,
					'filter_by'	=> 'p.status',
					'filter'		=> '1',
					'order_by'	=> 'RAND()'
				)
			),
			1
		);
		$this->registry->set_column(
			'clasificados',
			$this->basicads_model->getBasicAds(
				array(
					'start'			=> 0,
					'limit'			=> 10,
					'filter_by'	=> 'b.status',
					'filter'		=> 'publicado',
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
					'limit'			=> 6,
					'filter_by'	=> 'status',
					'filter'		=> 'publicado',
					'order_by'	=> 'RAND()'
				)
			),
			2
		);
		
	}

}

/* End of file Front_Controller.php */
/* Location: ./application/core/Front_Controller.php */