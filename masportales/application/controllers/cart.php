<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Cart controller that extends API Controller
 *
 * This Controller must manage adding, modifing and deleting products to the cart
 *
 * @since 0.5
 *
 * @package masPortales
 * @subpackage API
 */
class Cart extends API_Controller {

	private $cart_items;
	private $cart_n_items;
	private $cart_total;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
		$this->cart_items = $this->cart->contents();
		$this->cart_n_items = $this->cart->total_items();
		$this->cart_total = $this->cart->total();
	}
	
	public function index()
	{
		echo "Hello World!";
		echo '<pre>';
		print_r($this->input->post());
		echo '</pre>';
	}
	
	public function add()
	{
		$data = array();
		$this->load->model('ecommerce_model');
		$product_id = $this->input->post('pid', true);
		
		if ($this->_is_product_in_cart($product_id)) {
			$rowid = false;
			$message = 'El producto ya ha sido añadido al carrito.';
		} else {
			$product_data = $this->ecommerce_model->getProduct($this->input->post('pid'));
			$data = array(
    		'id'      => $product_data['product_ID'],
    		'qty'     => 1,
    		'price'   => $product_data['price'],
    		'name'    => $product_data['name']
    	);
    	$rowid = $this->cart->insert($data);
    	$data['cart_total'] = number_format($this->cart_total + $product_data['price'], 2, ',', '.');
    	$message = '';
    }
    	
    header('Content-type: application/json');
    echo json_encode(array('rowid' => $rowid, 'rowinfo' => $data, 'message' => $message));
	}
	
	public function addqty()
	{
		$data = array();
		$rowid = $this->input->post('rid', true);
		
		if (array_key_exists($rowid, $this->cart_items)) {
			$data = array(
				'rowid' => $rowid,
				'qty'   => $this->cart_items[$rowid]['qty'] + 1
			);
			$this->cart->update($data);
			$data['price'] = number_format($data['qty'] * $this->cart_items[$rowid]['price'], 2, ',', '.');
			$data['cart_total'] = number_format($this->cart_total + $this->cart_items[$rowid]['price'], 2, ',', '.');
			$message = 'Ok'; 
			header('Content-type: application/json');
    	echo json_encode(array('rowid' => $rowid, 'rowinfo' => $data, 'message' => $message));
		} else {
			$message = 'KO';
			$data = array();
			header('Content-type: application/json');
    	echo json_encode(array('rowid' => false, 'rowinfo' => false, 'message' => 'No existe producto en el carrito.'));
		}
	}
	
	public function subqty()
	{
		$data = array();
		$rowid = $this->input->post('rid', true);
		
		if (array_key_exists($rowid, $this->cart_items)) {
			$data = array(
				'rowid' => $rowid,
				'qty'   => $this->cart_items[$rowid]['qty'] - 1
			);
			$this->cart->update($data);
			if ($data['qty']) {
				$data['price'] = number_format($data['qty'] * $this->cart_items[$rowid]['price'], 2, ',', '.');
				$data['cart_total'] = number_format($this->cart_total - $this->cart_items[$rowid]['price'], 2, ',', '.');
				$message = 'Ok'; 
			} else {
				$data = false;
				$message = 'delete';
			}
			
			header('Content-type: application/json');
    	echo json_encode(array('rowid' => $rowid, 'rowinfo' => $data, 'message' => $message));
		} else {
			$data = array();
			header('Content-type: application/json');
    	echo json_encode(array('rowid' => false, 'rowinfo' => false, 'message' => 'No existe producto en el carrito.'));
		}
	}
	
	public function setqty()
	{
		$data = array();
		$rowid = $this->input->post('rid', true);
		$qty = $this->input->post('qty', true);
		//$old_qty = $this->input->post('old_qty', true);
		
		// check if we recieve a real rowid
		if (array_key_exists($rowid, $this->cart_items)) {
			$old_qty = $this->cart_items[$rowid]['qty'];
			// check if it has really been changed the quantity 
			if ($this->cart_items[$rowid]['qty'] == $qty) {
				$data = array();
				$rowinfo = false;
				$message = 'Quantity not changed';
			} else {
				$data = array(
					'rowid' => $rowid,
					'qty'   => $qty
				);
				$this->cart->update($data);
				$data['difference'] = $qty - $this->cart_items[$rowid]['qty'];
				$data['price'] = number_format($data['qty'] * $this->cart_items[$rowid]['price'], 2, ',', '.');
				$data['cart_total'] = number_format($this->cart_total + ($this->cart_items[$rowid]['price'] *  $data['difference']), 2, ',', '.');
				$message = 'Ok';
			}
		} else {
			$data = array();
			$rowid = false;
			$rowinfo = false;
			$message = 'No existe producto en el carrito.';
		}
		header('Content-type: application/json');
    echo json_encode(array('rowid' => $rowid, 'rowinfo' => $data, 'message' => $message));
	}
	
	public function delete()
	{
		$rowid = $this->input->post('rid', true);
		$data = array(
			'rowid'	=> $rowid,
			'qty'		=> 0
		);
		
		$this->cart->update($data);
		
		header('Content-type: application/json');
    echo json_encode(array('cart_total' => number_format($this->cart_total - $this->cart_items[$rowid]['price'], 2, ',', '.')));
	}
	
	private function _is_product_in_cart($product_id)
	{
		foreach ($this->cart_items as $rowid => $cart_item) {
			if ($cart_item['id'] == $product_id) return $rowid;
		}
		return false;
	}

}

/* End of file cart.php */
/* Location: ./application/controllers/cart.php */