<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ecommerce_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * companies. getProducts
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $limit
	 *
	 * @return bool|array
	 */
	public function getProducts($params = array())
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 20,
			'order_by'	=> 'date_added DESC',
			'search_by'	=> false,
			'search'		=> '',
			'filter_by'	=> false,
			'filter'		=> ''
		);
		
		$params = array_merge($defaults, $params);
		$where = "";
		if ($params['filter_by']) {
			if (is_array($params['filter_by'])) {
				foreach ($params['filter_by'] as $key => $value) {
					$where.= " AND " . $value . " = '" . $params['filter'][$key] . "'";
				}
			} elseif (is_string($params['filter_by'])) {
				$where.= " AND " . $params['filter_by'] . " = '" . $params['filter'] . "'";
			}
		}
		if ($params['search_by']) {
			if (is_array($params['search_by'])) {
				$searh_fields = array();
				foreach ($params['search_by'] as $key => $value) {
					$searh_fields[] = $value . " LIKE '%" . $params['search'][$key] . "%'";
				}
				$where.= " AND (" . implode(" OR ", $searh_fields) . ")";
			} else {
				$where.= " AND " . $params['search_by'] . " LIKE '%" . $params['search'] . "%'";
			}
		}
		
		$sql = " SELECT p.*, pd.*, c.name AS company_name, pi.name as main_image, pi.ext as main_ext FROM products p";
		$sql.= "	LEFT JOIN products_description pd ON p.product_ID = pd.product_ID";
		$sql.= "	LEFT JOIN products_images pi ON p.image = pi.image_ID";
		$sql.= "	LEFT JOIN companies c USING (company_ID)";
		$sql.= " WHERE p.site_ID = '" . site_id() . "'" . $where;
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	public function getNProducts($params = array())
	{
		$defaults = array(
			'search_by'	=> false,
			'search'		=> '',
			'filter_by'	=> false,
			'filter'		=> ''
		);
		
		$params = array_merge($defaults, $params);
		$where = "";
		if ($params['search_by']) {
			$where.= " AND " . $params['search_by'] . " LIKE '%" . $params['search'] . "%'";
		}
		if ($params['filter_by']) {
			$where.= " AND " . $params['filter_by'] . " = '" . $params['filter'] . "'";
		} else {
			
		}
		
		$sql = " SELECT * FROM products p";
		$sql.= "	LEFT JOIN products_description pd ON p.product_ID = pd.product_ID";
		$sql.= " WHERE site_ID = '" . site_id() . "'" . $where . ";";
		
		$query = $this->db->query($sql);
		
		return count($query->result_array());
	}
	
	/**
	 * companies. getProduct
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $company_id
	 *
	 * @return bool|array
	 */
	public function getProduct($product_id, $company_id = null)
	{
		$and_company = '';
		if ($company_id !== null) {
			$and_company = "AND p.company_ID = '$company_id'";
		}
		
		$sql = "SELECT p.*, pd.*, pi.name as main_image, pi.ext as main_ext FROM products p
							LEFT JOIN products_description pd ON p.product_ID = pd.product_ID
							LEFT JOIN products_images pi ON p.image = pi.image_ID
						WHERE p.product_ID = '$product_id' $and_company
						LIMIT 1;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * companies. getForPrint
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $product_id
	 *
	 * @return array|bool
	 */
	public function getForPrint($product_id)
	{
		$item_tmp = $this->getProduct($product_id);
		
		$item = array(
			'title'					=> $item_tmp['name'],
			'content'				=> $item_tmp['description'],
			'image_uri'			=> $item_tmp['main_image'] . '.' . $item_tmp['main_ext'],
			'image_folder'	=> 'usrs/productos/',
			'date_added'		=> $item_tmp['date_added']
		);
		
		return $item;
	}
	
	/**
	 * companies. getProductImages
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $company_id
	 *
	 * @return bool|array
	 */
	public function getProductImages($product_id)
	{
		$sql = "SELECT * FROM products_images WHERE product_ID = '$product_id';";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * companies. addProduct
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function addProduct($data)
	{
		$main_image_id = null;
		$data['product']['site_ID'] = site_id();
		if ($this->db->insert('products', $data['product'])) {
			$product_id = $this->db->insert_id();
			$data['product_description']['product_ID'] = $product_id;
			if ($this->db->insert('products_description', $data['product_description'])) {
				if ($data['product_images']) {
					foreach ($data['product_images'] as $key => $value) {
						$value['product_ID'] = $product_id;
						$this->db->insert('products_images', $value);
						if ($key == $data['product_image_main']) {
							$main_image_id = $this->db->insert_id();
						}
					}
				}
				if ($main_image_id) {
					$this->db->update('products', array('image' => $main_image_id), array('product_ID' => $product_id));
				}
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. saveProduct
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $data
	 * @param int $product_id
	 *
	 * @return bool
	 */
	public function saveProduct($data, $product_id)
	{
		$main_image_id = null;
		$where = array('product_ID' => $product_id);
		if ($this->db->update('products', $data['product'], $where)) {
			$this->db->delete('products_description', $where);
			$this->db->delete('products_images', $where);
			$data['product_description']['product_ID'] = $product_id;
			if ($this->db->insert('products_description', $data['product_description'])) {
				if ($data['product_images'] != null) {
					foreach ($data['product_images'] as $key => $value) {
						$value['product_ID'] = $product_id;
						$this->db->insert('products_images', $value);
						if ($key == $data['product_image_main']) {
							$main_image_id = $this->db->insert_id();
						}
					}
				}
				if ($main_image_id) {
					$this->db->update('products', array('image' => $main_image_id), array('product_ID' => $product_id));
				}
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. deleteProduct
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $product_id
	 *
	 * @return bool
	 */
	public function deleteProduct($product_id)
	{
		$where = array('product_ID' => $product_id);
		if ($this->db->delete('products', $where)
				and $this->db->delete('products_description', $where)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getProductComments
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $product_id
	 *
	 * @return bool
	 */
	public function getProductComments($product_id)
	{
		$sql = "SELECT * FROM products_comments WHERE product_ID = '$product_id' AND approved = '1'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getComments
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $product_id
	 *
	 * @return array
	 */
	public function getComments($product_id)
	{
		return $this->getProductComments($product_id);
	}
	
	/**
	 * ecommerce. addProductComment
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function addProductComment($data)
	{
		$product_id = $data['comment']['product_ID'];
		if ($this->db->insert('products_comments', $data['comment'])) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. deleteProductComment
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $comment_id
	 *
	 * @return bool
	 */
	public function deleteProductComment($comment_id)
	{
		$where = array('comment_ID' => $comment_id);
		if ($this->db->delete('products_comments', $where)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. slugFor
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $slug
	 *
	 * @return int
	 */
	public function slugFor($slug)
	{
		$sql = "SELECT product_ID FROM products_description WHERE slug = '$slug' LIMIT 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['product_ID'];
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getCartProductsByCompany
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $company_id
	 *
	 * @return array|bool
	 */
	public function getCartProductsByCompany($company_id = null)
	{
		$products_by_company = array();
		
		$cart_items = array();
		if ($this->cart->total_items() > 0) {
			// if cart it is not empty
			$items_id = array();
			$cart_tmp = $this->cart->contents();
			foreach ($cart_tmp as $cart_item) {
				// we get products_id from the cart
				$item_id = $cart_item['id'];
				$items_id[] = $item_id;
				// we reorganize cart items by product_id instead of rowid
				$cart_items[$item_id] = array(
					'id'		=> $cart_item['id'],
					'rowid' => $cart_item['rowid'],
					'qty'		=> $cart_item['qty']
				);
			}
		} else {
			$items_id = 0;
		}
		unset($cart_tmp);
		
		// get from DB the compamies with products in the cart
		$this->db->select('companies.*');
		$this->db->distinct();
		$this->db->from('products');
		$this->db->join('companies', 'products.company_ID = companies.company_ID');
		$this->db->where_in('products.product_ID', $items_id);
		$this->db->group_by('company_ID');
		$query_companies = $this->db->get();
		
		if ($query_companies->num_rows() > 0) {
			foreach ($query_companies->result_array() as $company) {
				$tmp_company_id = $company['company_ID'];
				$products_by_company[$tmp_company_id] = $company;
			}
		} else {
			$products_by_company = false;
		}
		
		// get from DB all the info of the products in the cart
		$this->db->select('products.*, products_description.*, products_images.name as main_image, products_images.ext as main_ext');
		$this->db->from('products');
		$this->db->join('products_description', 'products.product_ID = products_description.product_ID', 'left');
		$this->db->join('products_images', 'products.image = products_images.image_ID', 'left');
		$this->db->where_in('products.product_ID', $items_id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $product) {
				$tmp_company_id = $product['company_ID'];
				$product_id = $product['product_ID'];
				$products_by_company[$tmp_company_id]['products'][$product_id] = $product;
				$products_by_company[$tmp_company_id]['products'][$product_id]['rowid'] = $cart_items[$product_id]['rowid'];
				$products_by_company[$tmp_company_id]['products'][$product_id]['qty'] = $cart_items[$product_id]['qty'];
			}
		} else {
			$products_by_company = false;
		}
		
		if ($company_id and !isset($products_by_company[$company_id])) {
			return false;
		} elseif ($company_id) {
			return $products_by_company[$company_id];
		}
		
		return $products_by_company;
	}
	
	/**
	 * ecommerce. activeEcommerce
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $company_id
	 *
	 * @return bool
	 */
	public function activeEcommerce($company_id)
	{
		if ($this->db->update('companies', array('ecommerce' => '1'), array('company_ID' => $company_id))) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getShippingMethod
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int|string $shipping_id
	 *
	 * @return array|bool
	 */
	public function getShippingMethod($method_id)
	{
		$sql = "SELECT * FROM shipping_methods WHERE keyword = '$method_id' LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getCompanyShippingMethods
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $company_id
	 *
	 * @return array|bool
	 */
	public function getCompanyShippingMethods($company_id)
	{
		$sql = "SELECT DISTINCT sm.shipping_method_ID, name, keyword, meta_key, meta_value FROM shipping_methods sm
							LEFT JOIN shipping_methods_settings sms USING (shipping_method_ID)
						WHERE sms.company_ID = '$company_id'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$shipping_methods = array();
			foreach ($result as $row) {
				$shipping_method_id = $row['shipping_method_ID'];
				$keyword = $row['keyword'];
				$setting_key = $row['meta_key'];
				$setting_key = str_replace($keyword . '_', '', $setting_key, $n);
				if ($n === 1) {
					$shipping_methods[$shipping_method_id]['shipping_method_ID'] = $shipping_method_id;
					$shipping_methods[$shipping_method_id]['name'] = $row['name'];
					$shipping_methods[$shipping_method_id]['keyword'] = $keyword;
					$shipping_methods[$shipping_method_id]['settings'][$setting_key] = $row['meta_value'];
				}
			}
			return $shipping_methods;
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getSiteShippingMethods
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @return array|bool
	 */
	public function getSiteShippingMethods()
	{
		$sql = "SELECT DISTINCT sm.shipping_method_ID, name, keyword, meta_key, meta_value FROM shipping_methods sm
							LEFT JOIN shipping_methods_settings sms USING (shipping_method_ID)
						WHERE sms.site_ID = '" . site_id() . "' AND sms.company_ID = '0'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$shipping_methods = array();
			foreach ($result as $row) {
				$shipping_method_id = $row['shipping_method_ID'];
				$keyword = $row['keyword'];
				$setting_key = $row['meta_key'];
				$setting_key = str_replace($keyword . '_', '', $setting_key, $n);
				if ($n === 1) {
					$shipping_methods[$shipping_method_id]['shipping_method_ID'] = $shipping_method_id;
					$shipping_methods[$shipping_method_id]['name'] = $row['name'];
					$shipping_methods[$shipping_method_id]['keyword'] = $keyword;
					$shipping_methods[$shipping_method_id]['settings'][$setting_key] = $row['meta_value'];
				}
			}
			return $shipping_methods;
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. saveShippingMethodConfig
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function saveShippingMethodConfig($data)
	{
		$shipping_method_ID = $data['keys']['shipping_method_ID'];
		$company_ID = $data['keys']['company_ID'];
		$keyword = $data['keys']['keyword'];
		$where = array('shipping_method_ID' => $shipping_method_ID, 'company_ID' => $company_ID);
		if ($this->db->delete('shipping_methods_settings', $where)) {
			foreach ($data['settings'] as $key => $value) {
				$setting = array(
					'shipping_method_ID'	=> $shipping_method_ID,
					'company_ID'					=> $company_ID,
					'meta_key'						=> $keyword . '_' . $key,
					'meta_value'					=> $value
				);
				$this->db->insert('shipping_methods_settings', $setting);
			}
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getPaymentGateway
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int|string $gateway_id
	 *
	 * @return array|bool
	 */
	public function getPaymentGateway($gateway_id)
	{
		$sql = "SELECT * FROM payment_gateways WHERE keyword = '$gateway_id' LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getPaymentGateways
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int|string $gateway_id
	 *
	 * @return array|bool
	 */
	public function getPaymentGateways($gateway_id = null, $owner_id = null)
	{
		if ($gateway_id) {
			$field = (is_integer($gateway_id)) ? 'p.payment_gateway_ID' : 'keyword';
			$where = " WHERE $field = '$gateway_id';";
		} else {
			$where = false;
		}
		
		
		if ($owner_id !== null) {
			$site_id = site_id();
			
			$sql = "SELECT p.payment_gateway_ID, p.name, p.keyword, pgs.payment_gateway_settings_ID as status FROM payment_gateways p ";
			$sql.= "LEFT JOIN ";
			$sql.= "	(SELECT * FROM payment_gateways_settings WHERE site_ID = '$site_id' AND company_ID = '$owner_id') pgs ";
			$sql.= "USING (payment_gateway_ID) GROUP BY keyword;";
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
		} else {
			$sql = "SELECT * FROM payment_gateways";
			$sql.= ($where) ? $where : ';';
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
		}
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getPaymentGatewayConfig
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int|string $gateway_id
	 * @param int|string $owner_id
	 * @param string $owner values: 'site'|'company'
	 *
	 * @return array|bool
	 */
	public function getPaymentGatewayConfig($gateway_id, $owner_id = 0, $owner = 'site')
	{
		if ($owner == 'site') {
			$owner_sql = "site_ID = '$owner_id' AND company_ID ='0'";
		} elseif ($owner == 'company') {
			$owner_sql = "site_ID = '" . site_id() . "' AND company_ID ='$owner_id'";
		} else {
			return false;
		}
		$field = (is_numeric($gateway_id)) ? 'p.payment_gateway_ID' : 'keyword';
		$site_id = site_id();
		
		//$sql = "SELECT p.name, p.keyword, pgs.* FROM payment_gateways p, payment_gateways_settings pgs ";
		//$sql.= "WHERE p.payment_gateway_ID = pgs.payment_gateway_ID AND $field = '$gateway_id' AND site_ID = '$site_id' AND company_ID = '$owner_id';";
		
		$sql = "SELECT p.payment_gateway_ID, p.name, p.keyword, pgs.meta_key, pgs.meta_value FROM payment_gateways p ";
		$sql.= "LEFT JOIN ";
		$sql.= "	(SELECT * FROM payment_gateways_settings WHERE site_ID = '$site_id' AND $owner_sql) pgs ";
		$sql.= "USING (payment_gateway_ID) ";
		$sql.= "WHERE $field = '$gateway_id';";
		//echo "<p>$sql</p>";
		//$sql = "SELECT * FROM payment_gateways WHERE keyword = '$gateway_id' LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$result = array();
			foreach ($query->result_array() as $row) {
				$setting_key = $row['meta_key'];
				$result['payment_gateway_ID'] = $row['payment_gateway_ID'];
				$result['name'] = $row['name'];
				$result['keyword'] = $row['keyword'];
				$result[$setting_key] = $row['meta_value'];
			}
			return $result;
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getCompanyPaymentGateways
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $company_id
	 *
	 * @return array|bool
	 */
	/*
	public function getCompanyPaymentGateways($company_id)
	{
		$sql = "SELECT DISTINCT pg.payment_gateway_ID, name, keyword, meta_key, meta_value FROM payment_gateways pg
							LEFT JOIN payment_gateways_settings pgs USING (payment_gateway_ID)
						WHERE pgs.company_ID = '$company_id'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$payment_gateways = array();
			foreach ($result as $row) {
				$payment_gateway_id = $row['payment_gateway_ID'];
				$keyword = $row['keyword'];
				$setting_key = $row['meta_key'];
				$setting_key = str_replace($keyword . '_', '', $setting_key, $n);
				if ($n === 1) {
					$payment_gateways[$payment_gateway_id]['payment_gateway_ID'] = $payment_gateway_id;
					$payment_gateways[$payment_gateway_id]['name'] = $row['name'];
					$payment_gateways[$payment_gateway_id]['keyword'] = $keyword;
					$payment_gateways[$payment_gateway_id]['settings'][$setting_key] = $row['meta_value'];
				}
			}
			return $payment_gateways;
		} else {
			return false;
		}
	}
	*/
	
	/**
	 * ecommerce. getSitePaymentGateways
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $company_id
	 *
	 * @return array|bool
	 */
	/*
	public function getSitePaymentGateways()
	{
		$sql = "SELECT DISTINCT pg.payment_gateway_ID, name, keyword, meta_key, meta_value FROM payment_gateways pg
							LEFT JOIN payment_gateways_settings pgs USING (payment_gateway_ID)
						WHERE pgs.site_ID = '" . site_id() . "' AND pgs.company_ID = '0'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$payment_gateways = array();
			foreach ($result as $row) {
				$payment_gateway_id = $row['payment_gateway_ID'];
				$keyword = $row['keyword'];
				$setting_key = $row['meta_key'];
				$setting_key = str_replace($keyword . '_', '', $setting_key, $n);
				if ($n === 1) {
					$payment_gateways[$payment_gateway_id]['payment_gateway_ID'] = $payment_gateway_id;
					$payment_gateways[$payment_gateway_id]['name'] = $row['name'];
					$payment_gateways[$payment_gateway_id]['keyword'] = $keyword;
					$payment_gateways[$payment_gateway_id]['settings'][$setting_key] = $row['meta_value'];
				}
			}
			return $payment_gateways;
		} else {
			return false;
		}
	}
	*/
	
	/**
	 * ecommerce. getFranchisePaymentGateways
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $gateway_id
	 *
	 * @return array|bool
	 */
	/*
	public function getFranchisePaymentGateway($gateway_id = null)
	{
		if ($gateway_id) {
			// return payment gateway by $gateway_id
			$sql = "SELECT * FROM payment_gateways WHERE payment_gateway_ID = '$gateway_id' LIMIT 1";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				$payment_gateway = $query->row();
				$sql = "SELECT * FROM settings WHERE  site_ID = '" . site_id() . "' AND meta_group = 'payment_gateway' AND meta_key LIKE '" . $payment_gateway->keyword . "_%';";
				$query = $this->db->query($sql);
				if ($query->num_rows() > 0) {
					foreach($query->result() as $setting) {
						$key = str_replace($payment_gateway->keyword . '_', '', $setting->meta_key);
						$payment_gateway->$key = $setting->meta_value;
					}
				}
				return $payment_gateway;
			} else {
				return false;
			}
		} else { 
			// $gateway_id not passed, return all payment gateways
			$payment_gateways = array();
			$sql = "SELECT * FROM payment_gateways";
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				$result = $query->result();
				foreach ($query->result() as $row) {
					$payment_gateways[$row->keyword] =  $row;
					$payment_gateways[$row->keyword]->status = 'desactivado';
				}
				$sql = "SELECT * FROM settings WHERE site_ID = '" . site_id() . "' AND meta_group = 'payment_gateway'";
				$query = $this->db->query($sql);
				if ($query->num_rows() > 0) {
					foreach($query->result() as $setting) {
						$meta_key = explode('_', $setting->meta_key);
						$keyword = $meta_key[0];
						$payment_gateways[$keyword]->status = $setting->meta_value;
					}
				}
				return $payment_gateways;
			} else {
				return false;
			}
		}
	}
	*/
	
	/**
	 * ecommerce. saveFranchisePaymentGateway
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param stdClass $data
	 *
	 * @return bool
	 */
	/*
	public function saveFranchisePaymentGateway($data)
	{
		$success = true;
		$keyword = $data->keyword;
		unset($data->keyword);
		foreach($data as $key => $value) {
			$sql = "INSERT INTO settings (site_ID, meta_group, meta_key, meta_value)
								VALUES (" . site_id() . ", 'payment_gateway', '" . $key . "', '" . $value ."')
							ON DUPLICATE KEY UPDATE meta_value = '" . $value . "';";
			if (!$query = $this->db->query($sql)) $success = false;
		}
		return $success;
	}
	*/
	
	/**
	 * ecommerce. savePaymentGatewayConfig
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function savePaymentGatewayConfig($data, $payment_gateway_id, $company_id = 0)
	{
		$success = true;
		$company_ID = $company_id;
		$site_id = site_id();
		
		foreach($data as $key => $value) {
			$sql = "INSERT INTO payment_gateways_settings (payment_gateway_ID, site_ID, company_ID, meta_key, meta_value)
								VALUES ('$payment_gateway_id', '$site_id', '$company_ID', '$key', '$value')
							ON DUPLICATE KEY UPDATE meta_value = '$value';";
			if (!$query = $this->db->query($sql)) $success = false;
		}
		return $success;
		
		
		$payment_gateway_ID = $data['keys']['payment_gateway_ID'];
		$company_ID = $data['keys']['company_ID'];
		$keyword = $data['keys']['keyword'];
		$site_ID = site_id();
		$where = array('payment_gateway_ID' => $payment_gateway_ID, 'company_ID' => $company_ID);
		if ($this->db->delete('payment_gateways_settings', $where)) {
			foreach ($data['settings'] as $key => $value) {
				$setting = array(
					'payment_gateway_ID'	=> $payment_gateway_ID,
					'company_ID'					=> $company_ID,
					'meta_key'						=> $keyword . '_' . $key,
					'meta_value'					=> $value
				);
				$this->db->insert('payment_gateways_settings', $setting);
			}
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getOrders
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $params
	 *
	 * @return bool|array
	 */
	public function getOrders($params = array())
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 20,
			'order_by'	=> 'date_added DESC',
			'search_by'	=> false,
			'search'		=> '',
			'filter_by'	=> false,
			'filter'		=> ''
		);
		
		$params = array_merge($defaults, $params);
		$where = "";
		if ($params['filter_by']) {
			if (is_array($params['filter_by'])) {
				foreach ($params['filter_by'] as $key => $value) {
					$where.= " AND " . $value . " = '" . $params['filter'][$key] . "'";
				}
			} elseif (is_string($params['filter_by'])) {
				$where.= " AND " . $params['filter_by'] . " = '" . $params['filter'] . "'";
			}
		}
		if ($params['search_by']) {
			if (is_array($params['search_by'])) {
				$searh_fields = array();
				foreach ($params['search_by'] as $key => $value) {
					$searh_fields[] = $value . " LIKE '%" . $params['search'][$key] . "%'";
				}
				$where.= " AND (" . implode(" OR ", $searh_fields) . ")";
			} else {
				$where.= " AND " . $params['search_by'] . " LIKE '%" . $params['search'] . "%'";
			}
		}
		
		$sql = " SELECT o.order_ID, o.company_ID, o.customer_email, u.display_name AS customer_name, o.order_total, o.date_added, os.name AS order_status
						 FROM orders o";
		$sql.= "	LEFT JOIN orders_status os USING (order_status_ID)";
		$sql.= "	LEFT JOIN users u ON u.user_ID = o.customer_ID";
		$sql.= " WHERE o.site_ID = '" . site_id() . "'" . $where;
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getOrder
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $params
	 * @param int $order_id
	 *
	 * @return bool|array
	 */
	public function getOrder($params = array(), $order_id = null)
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 1,
			'order_by'	=> false,
			'search_by'	=> false,
			'search'		=> '',
			'filter_by'	=> false,
			'filter'		=> ''
		);
		
		$params = array_merge($defaults, $params);
		$where = "";
		if ($params['filter_by']) {
			if (is_array($params['filter_by'])) {
				foreach ($params['filter_by'] as $key => $value) {
					$where.= " AND " . $value . " = '" . $params['filter'][$key] . "'";
				}
			} elseif (is_string($params['filter_by'])) {
				$where.= " AND " . $params['filter_by'] . " = '" . $params['filter'] . "'";
			}
		}
		if ($params['search_by']) {
			if (is_array($params['search_by'])) {
				$searh_fields = array();
				foreach ($params['search_by'] as $key => $value) {
					$searh_fields[] = $value . " LIKE '%" . $params['search'][$key] . "%'";
				}
				$where.= " AND (" . implode(" OR ", $searh_fields) . ")";
			} else {
				$where.= " AND " . $params['search_by'] . " LIKE '%" . $params['search'] . "%'";
			}
		}
		
		$sql = " SELECT o.order_ID, o.company_ID, o.customer_email, u.display_name AS customer_name, sm.name AS shipping_method, pg.name AS payment_gateway, 	o.order_subtotal, o.order_discount, o.order_shipping, o.order_tax, o.order_total, o.date_added, os.name AS order_status, o.comment
						 FROM orders o";
		$sql.= "	LEFT JOIN shipping_methods sm USING (shipping_method_ID)";
		$sql.= "	LEFT JOIN payment_gateways pg USING (payment_gateway_ID)";
		$sql.= "	LEFT JOIN orders_status os USING (order_status_ID)";
		$sql.= "	LEFT JOIN users u ON u.user_ID = o.customer_ID";
		$sql.= " WHERE o.site_ID = '" . site_id() . "'" . $where;
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getOrderShippingAddress
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $params
	 * @param int $order_id
	 *
	 * @return bool|array
	 */
	public function getOrderShippingAddress($params, $order_id = null)
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 1,
			'order_by'	=> false,
			'search_by'	=> false,
			'search'		=> '',
			'filter_by'	=> false,
			'filter'		=> ''
		);
		
		$params = array_merge($defaults, $params);
		$where = "";
		if ($params['filter_by']) {
			if (is_array($params['filter_by'])) {
				foreach ($params['filter_by'] as $key => $value) {
					$where.= " AND " . $value . " = '" . $params['filter'][$key] . "'";
				}
			} elseif (is_string($params['filter_by'])) {
				$where.= " AND " . $params['filter_by'] . " = '" . $params['filter'] . "'";
			}
		}
		if ($params['search_by']) {
			if (is_array($params['search_by'])) {
				$searh_fields = array();
				foreach ($params['search_by'] as $key => $value) {
					$searh_fields[] = $value . " LIKE '%" . $params['search'][$key] . "%'";
				}
				$where.= " AND (" . implode(" OR ", $searh_fields) . ")";
			} else {
				$where.= " AND " . $params['search_by'] . " LIKE '%" . $params['search'] . "%'";
			}
		}
		
		$sql = " SELECT oa.* FROM orders o, orders_address oa";
		$sql.= " WHERE o.site_ID = '" . site_id() . "' AND o.shipping_address_ID = oa.order_address_ID" . $where;
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getOrderPaymentAddress
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $params
	 * @param int $order_id
	 *
	 * @return bool|array
	 */
	public function getOrderPaymentAddress($params, $order_id = null)
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 1,
			'order_by'	=> false,
			'search_by'	=> false,
			'search'		=> '',
			'filter_by'	=> false,
			'filter'		=> ''
		);
		
		$params = array_merge($defaults, $params);
		$where = "";
		if ($params['filter_by']) {
			if (is_array($params['filter_by'])) {
				foreach ($params['filter_by'] as $key => $value) {
					$where.= " AND " . $value . " = '" . $params['filter'][$key] . "'";
				}
			} elseif (is_string($params['filter_by'])) {
				$where.= " AND " . $params['filter_by'] . " = '" . $params['filter'] . "'";
			}
		}
		if ($params['search_by']) {
			if (is_array($params['search_by'])) {
				$searh_fields = array();
				foreach ($params['search_by'] as $key => $value) {
					$searh_fields[] = $value . " LIKE '%" . $params['search'][$key] . "%'";
				}
				$where.= " AND (" . implode(" OR ", $searh_fields) . ")";
			} else {
				$where.= " AND " . $params['search_by'] . " LIKE '%" . $params['search'] . "%'";
			}
		}
		
		$sql = " SELECT oa.* FROM orders o, orders_address oa";
		$sql.= " WHERE o.site_ID = '" . site_id() . "' AND o.payment_address_ID = oa.order_address_ID" . $where;
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getOrderProducts
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $params
	 * @param int $order_id
	 *
	 * @return bool|array
	 */
	public function getOrderProducts($params, $order_id = null)
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 20,
			'order_by'	=> 'date_added DESC',
			'search_by'	=> false,
			'search'		=> '',
			'filter_by'	=> false,
			'filter'		=> ''
		);
		
		$params = array_merge($defaults, $params);
		$where = "";
		if ($params['filter_by']) {
			if (is_array($params['filter_by'])) {
				foreach ($params['filter_by'] as $key => $value) {
					$where.= " AND " . $value . " = '" . $params['filter'][$key] . "'";
				}
			} elseif (is_string($params['filter_by'])) {
				$where.= " AND " . $params['filter_by'] . " = '" . $params['filter'] . "'";
			}
		}
		if ($params['search_by']) {
			if (is_array($params['search_by'])) {
				$searh_fields = array();
				foreach ($params['search_by'] as $key => $value) {
					$searh_fields[] = $value . " LIKE '%" . $params['search'][$key] . "%'";
				}
				$where.= " AND (" . implode(" OR ", $searh_fields) . ")";
			} else {
				$where.= " AND " . $params['search_by'] . " LIKE '%" . $params['search'] . "%'";
			}
		}
		
		$sql = " SELECT op.* FROM orders o, orders_products op";
		$sql.= " WHERE o.site_ID = '" . site_id() . "' AND o.order_ID = op.order_ID" . $where;
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. getOrderHistory
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $params
	 * @param int $order_id
	 *
	 * @return bool|array
	 */
	public function getOrderHistory($params, $order_id = null)
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 20,
			'order_by'	=> 'date_added DESC',
			'search_by'	=> false,
			'search'		=> '',
			'filter_by'	=> false,
			'filter'		=> ''
		);
		
		$params = array_merge($defaults, $params);
		$where = "";
		if ($params['filter_by']) {
			if (is_array($params['filter_by'])) {
				foreach ($params['filter_by'] as $key => $value) {
					$where.= " AND " . $value . " = '" . $params['filter'][$key] . "'";
				}
			} elseif (is_string($params['filter_by'])) {
				$where.= " AND " . $params['filter_by'] . " = '" . $params['filter'] . "'";
			}
		}
		if ($params['search_by']) {
			if (is_array($params['search_by'])) {
				$searh_fields = array();
				foreach ($params['search_by'] as $key => $value) {
					$searh_fields[] = $value . " LIKE '%" . $params['search'][$key] . "%'";
				}
				$where.= " AND (" . implode(" OR ", $searh_fields) . ")";
			} else {
				$where.= " AND " . $params['search_by'] . " LIKE '%" . $params['search'] . "%'";
			}
		}
		
		$sql = " SELECT oh.* FROM orders o, orders_history oh";
		$sql.= " WHERE o.site_ID = '" . site_id() . "' AND o.order_ID = oh.order_ID" . $where;
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. addOrder
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function addOrder($data)
	{
		if ($data['shipment_address']) {
			if ($this->db->insert('orders_address', $data['shipment_address'])) $data['order']['shipping_address_ID'] = $this->db->insert_id();
		}
		
		if ($data['payment_address']) {
			if ($this->db->insert('orders_address', $data['payment_address'])) $data['order']['payment_address_ID'] = $this->db->insert_id();
		}
		
		$data['order']['site_ID'] = site_id(); 
		if ($this->db->insert('orders', $data['order'])) {
			$order_id = $this->db->insert_id();
			foreach ($data['order_products'] as $product) {
				$product['order_ID'] = $order_id;
				$this->db->insert('orders_products', $product);
			}
			$order_history = array(
				'order_ID'				=> $order_id,
				'order_status_ID'	=> 1,
				'notify'					=> 1,
				'comment'					=> '',
				'date_added'			=> $data['order']['date_added']
			);
			$this->db->insert('orders_history', $order_history);
			return $order_id;
		} else {
			return false;
		}
	}
	
	/**
	 * ecommerce. sendOrderEmail
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function sendOrderEmail($data)
	{
		$this->load->library('parser');
		
		$html_email = $this->parser->parse('themes/default/email/order_confirm.tpl', $data, TRUE);
		
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);
		
		$this->email->from('no-reply@' . $this->registry->core('base_domain'), $this->registry->site('name') . '+portales');
		$this->email->to($data['customer_email']);
		
		$this->email->subject('Pedido n. ' . $data['order_id'] . ' en ' . $data['store_name'] . ' - ' . $this->registry->site('name') . '+Portales');
		$this->email->message($html_email);
		
		$this->email->send();
	}

}

/* End of file ecommerce_model.php */
/* Location: ./application/models/ecommerce_model.php */