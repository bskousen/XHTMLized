<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Companies_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * companies. getCompany
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $company_id
	 *
	 * @return mixed
	 */
	public function getCompany($company_id)
	{
		$sql = "SELECT * FROM companies WHERE company_ID = '$company_id' AND site_ID = '" . site_id() . "' LIMIT 1";
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
	 * @param int $company_id
	 *
	 * @return array|bool
	 */
	public function getForPrint($company_id)
	{
		$item_tmp = $this->getCompany($company_id);
		
		$item = array(
			'title'					=> $item_tmp['name'],
			'content'				=> $item_tmp['description'],
			'image_uri'			=> $item_tmp['logo'],
			'image_folder'	=> 'usrs/empresas/',
			'date_added'		=> $item_tmp['date_added']
		);
		
		return $item;
	}
	
	/**
	 * companies. getCompanyImages
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $basicad_id
	 *
	 * @return bool|array
	 */
	public function getCompanyImages($company_id)
	{
		$sql = "SELECT * FROM companies_images WHERE company_ID = '$company_id';";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * companies. getCompanies
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $limit
	 *
	 * @return mixed
	 */
	public function getCompanies($params = array())
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 20,
			'order_by'	=> 'name DESC',
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
		
		$sql = " SELECT * FROM companies";
		$sql.= " WHERE site_ID = '" . site_id() . "'" . $where;
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
	 * companies. getNCompanies
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @return int
	 */
	public function getNCompanies($params = array())
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
		
		$sql = "SELECT COUNT(company_ID) as n_companies FROM companies WHERE site_ID = '" . site_id() .  "'$where;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$query->free_result();
			return $row->n_companies;
		} else {
			$query->free_result();
			return 0;
		}
	}
	
	/**
	 * companies. getCompanyCategories
	 *
	 * @access public
	 * @since 0.9
	 *
	 *
	 * @return mixed
	 */
	public function getCompanyCategories()
	{
		$sql = "SELECT * FROM companies_categories WHERE parent=0";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * companies. getCompanySubcategories
	 *
	 * @access public
	 * @since 0.9
	 *
	 *
	 * @param int $category_ID
	 *
	 * @return mixed
	 */
	public function getCompanySubcategories($category_ID)
	{
		$sql = "SELECT * FROM companies_categories WHERE parent=".$category_ID;
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * companies. getCompanyCategories
	 *
	 * @access public
	 * @since 0.9
	 *
	 *
	 * @param int $category_ID
	 *
	 * @return mixed
	 */
	public function getCompanyCategoriesBy($category_ID)
	{
		$sql = "SELECT * FROM companies_categories WHERE category_id=".$category_ID;
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * companies. getCompanySubcategories
	 *
	 * @access public
	 * @since 0.9
	 *
	 *
	 * @param int $category_ID
	 *
	 * @return mixed
	 */
	public function getCompanySubcategoriesBy($company_ID)
	{
		$sql = "SELECT cc.company_ID, cc.category_id,c.name,ccat.name,ccat.parent FROM company_category_categories as cc
			INNER JOIN companies as c ON c.company_ID = cc.company_ID
			INNER JOIN  companies_categories as ccat on ccat.category_ID = cc.category_ID
			 WHERE cc.company_ID=".$company_ID;
		$query = $this->db->query($sql);
		echo $sql;
		echo "QUERY"; var_dump($query->result_array());
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * companies. getCompanySubcategories
	 *
	 * @access public
	 * @since 0.9
	 *
	 *
	 * @param int $category_ID
	 *
	 * @return mixed
	 */
	public function getCompanySubcategoriesByname($category_name)
	{
		$sql = "SELECT * FROM companies_categories WHERE name='".$category_name."'";
		$query = $this->db->query($sql);
	
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	/**
	 * companies. addCompany
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function addCompany($data)
	{
		$data['company']['site_ID'] = site_id();
		if ($this->db->insert('companies', $data['company'])) {
			if ($data['category']) {
				$res["company_id"] = $this->db->insert_id();
				for ($y=1;$y <= $data['category']['category_contador']; $y++) {
					$key = "category".$y;
					$res["category_id"] = $data['category'][$key];
					$subcategory = $this->getCompanySubcategoriesByname($res["category_id"]);
					$res["category_id"] = $subcategory['category_ID'];
					$this->db->insert('company_category_categories', $res);
				}
				return true;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	/**
	 * companies. deleteCompany
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param id $company_id
	 *
	 * @return bool
	 */
	public function deleteCompany($company_id)
	{
		$where = array('company_ID' => $company_id);
		if ($this->db->delete('companies', $where)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * companies. deleteCompanyImages
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param id $company_id
	 *
	 * @return bool
	 */
	public function deleteCompanyImages($company_id)
	{
		$where = array('company_ID' => $company_id);
		if ($this->db->delete('companies_images', $where)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * companies. saveCompany
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $data
	 * @param int $company_id
	 *
	 * @return bool
	 */
	public function saveCompany($data, $company_id = null)
	{
		if ($company_id) {
			// update company
			$where = array('company_ID' => $company_id);
			if ($this->db->update('companies', $data['company'], $where)) {
				$this->db->delete('companies_images', $where);
				//return $company_id;
			} else {
				$company_id = false;
			}
		} else {
			// or create a new company
			$data['company']['site_ID'] = site_id();
			$data['company']['date_added'] = date('Y-m-d H:i:s');
			//$data['company']['status'] = 'pendiente';
			if ($this->db->insert('companies', $data['company'])) {
				$company_id = $this->db->insert_id();
			} else {
				$company_id = false;
			}
		}
		if (isset($data['companies_images']) and $data['companies_images'] and $company_id) {
			foreach ($data['companies_images'] as $image) {
		  	$image['company_ID'] = $company_id;
		  	$this->db->insert('companies_images', $image);
		  }
		}
		return $company_id;
	}
	
	/**
	 * companies. isPremium
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $company_id
	 *
	 * @return mixed
	 */
	public function isPremium($company_id)
	{
		$sql = "SELECT premium FROM companies WHERE company_ID = '$company_id' LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['premium'];
		} else {
			return false;
		}
	}
	
	/**
	 * companies. getCompanyOwner
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $company_id
	 *
	 * @return mixed
	 */
	public function getCompanyOwner($company_id)
	{
		$sql = "SELECT user_ID FROM companies WHERE company_ID = $company_id LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['user_ID'];
		} else {
			return false;
		}
	}
	
	/**
	 * companies. getCompanyMicrosite
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $microsite_page_id
	 *
	 * @return mixed
	 */
	public function getCompanyMicrosite($company_id)
	{
		$sql = "SELECT * FROM microsites_pages WHERE company_ID = '$company_id' AND site_ID = '" . site_id() . "'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * companies. getMicrositePage
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $microsite_page_id
	 *
	 * @return mixed
	 */
	public function getMicrositePage($microsite_page_id)
	{
		$sql = "SELECT * FROM microsites_pages WHERE microsite_page_ID = '$microsite_page_id' AND site_ID = '" . site_id() . "' LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * companies. getMicrositePages
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function getMicrositePages($params = array())
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 20,
			'order_by'	=> 'title DESC',
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
		
		$sql = " SELECT * FROM microsites_pages";
		$sql.= " WHERE site_ID = '" . site_id() . "'" . $where;
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
	 * companies. saveMicrositePage
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $data
	 * @param int $microsite_page_id
	 *
	 * @return mixed
	 */
	public function saveMicrositePage($data, $microsite_page_id)
	{
		if ($microsite_page_id) {
			// update company
			$where = array('microsite_page_ID' => $microsite_page_id);
			if ($this->db->update('microsites_pages', $data['microsites_pages'], $where)) {
				//$this->db->delete('companies_images', $where);
				//return $company_id;
			} else {
				$microsite_page_id = false;
			}
		} else {
			// or create a new company
			$data['microsites_pages']['site_ID'] = site_id();
			$data['microsites_pages']['date_added'] = date('Y-m-d H:i:s');
			$data['microsites_pages']['status'] = 'publish';
			if ($this->db->insert('microsites_pages', $data['microsites_pages'])) {
				$microsite_page_id = $this->db->insert_id();
			} else {
				$microsite_page_id = false;
			}
		}
		
		return $microsite_page_id;
	}
	
	/**
	 * companies. getMicrositeBanner
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $microsite_banner_id
	 *
	 * @return mixed
	 */
	public function getMicrositeBanner($microsite_banner_id)
	{
		$sql = "SELECT * FROM microsites_banners WHERE microsite_banner_ID = '$microsite_banner_id' AND site_ID = '" . site_id() . "' LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * companies. getMicrositeBanners
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function getMicrositeBanners($params = array())
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
		
		$sql = " SELECT * FROM microsites_banners";
		$sql.= " WHERE site_ID = '" . site_id() . "'" . $where;
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
	 * companies. saveMicrositeBanner
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $data
	 * @param int $microsite_banner_id
	 *
	 * @return mixed
	 */
	public function saveMicrositeBanner($data, $microsite_banner_id)
	{
		if ($microsite_banner_id) {
			// update company
			$where = array('microsite_banner_ID' => $microsite_banner_id);
			if ($this->db->update('microsites_banners', $data['microsites_banners'], $where)) {
				//$this->db->delete('companies_images', $where);
				//return $company_id;
			} else {
				$microsite_banner_id = false;
			}
		} else {
			// or create a new company
			$data['microsites_banners']['site_ID'] = site_id();
			$data['microsites_banners']['date_added'] = date('Y-m-d H:i:s');
			$data['microsites_banners']['status'] = 'publicado';
			if ($this->db->insert('microsites_banners', $data['microsites_banners'])) {
				$microsite_banner_id = $this->db->insert_id();
			} else {
				$microsite_banner_id = false;
			}
		}
		
		return $microsite_banner_id;
	}
	
	/**
	 * companies. slugFor
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
		$sql = "SELECT company_ID FROM companies WHERE slug = '$slug' LIMIT 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['company_ID'];
		} else {
			return false;
		}
	}
	
	/**
	 * companies. activeEcommerce
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
	 * companies. getComments
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $company_id
	 *
	 * @return array
	 */
	public function getComments($company_id)
	{
		return false;
	}
	
	/**
	 * basicads. sendRegistrationEmail
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $basicad_contact
	 * @param array $basicad_answer
	 *
	 * @return bool
	 */
	public function sendRegistrationEmail($reg_info) // $basicad_contact, $basicad_answer = null)
	{
		$this->load->library('parser');
		
		$data = array(
			'title'							=> 'Confirma tu cuenta en ' . $this->registry->site('name') . '+Portales',
			'site_url'					=> $this->registry->site_url(),
			'site_name'					=> $this->registry->site('name'),
			'logo'							=> $this->registry->site('logo'),
			'recipient_name'		=> $reg_info['users_address']['name'] . ' ' . $reg_info['users_address']['surname'],
			'confirmation_link'	=> $this->registry->site_url() . 'registrarse/confirmation/' . $reg_info['confirmation_hash']['meta_value'],
			'conmpany_profile'	=> $this->registry->site_url() . 'micuenta/empresa'
		);
		
		$html_email = $this->parser->parse('themes/default/email/company_registration.tpl', $data, TRUE);
		
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);
		
		$sender_email = 'no-reply@';
		$sender_email.= ($this->registry->site('domain')) ? $this->registry->site('domain') : $this->registry->core('base_domain');
		
		$this->email->from($sender_email, $this->registry->site('name') . '+portales');
		//$this->email->reply_to($sender_info['author_email'], $sender_info['author']);
		$this->email->to($reg_info['users']['email']);
		
		$this->email->subject('Confirma tu cuenta en ' . $this->registry->site('name') . '+Portales');
		$this->email->message($html_email);
		
		return $this->email->send();
	}

}

/* End of file companies_model.php */
/* Location: ./application/models/companies_model.php */