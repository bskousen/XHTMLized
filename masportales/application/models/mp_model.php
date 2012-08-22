<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mp_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * mp. saveSiteSettings
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string|array $setting
	 * @param string $value
	 *
	 * @return array
	 */
	public function saveSiteSettings($setting, $value = null)
	{
		$error = false;
		
		if (is_string($setting) and $value != null) {
			$settings = array($setting => $value);
		} elseif (is_array($setting)) {
			$settings = $setting;
		} else {
			return false;
		}
		
		foreach ($settings as $setting => $value) {
			$sql = "INSERT INTO settings (site_ID, meta_group, meta_key, meta_value)
								VALUES (" . site_id() . ", 'site', '" . $setting . "', '" . $value ."')
							ON DUPLICATE KEY UPDATE meta_value = '" . $value . "';";
			if (!$query = $this->db->query($sql)) {
				$error = true;
			}
		}
		
		return !$error;
	}
	
	/**
	 * mp. getLegalTexts
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function getLegalTexts($params = array())
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 20,
			'order_by'	=> 'order_by DESC',
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
		
		$sql = " SELECT * FROM legal_texts";
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
	 * mp. getLegalText
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $legal_text_id
	 *
	 * @return mixed
	 */
	public function getLegalText($legal_text_id)
	{
		//TODO. diferent legal texts for each site
		//$sql = "SELECT * FROM legal_texts WHERE company_ID = '$legal_text_id' AND site_ID = '" . site_id() . "' LIMIT 1";
		$sql = "SELECT * FROM legal_texts WHERE legal_text_ID = '$legal_text_id' LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * mp. slugFor
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
		$sql = "SELECT legal_text_ID FROM legal_texts WHERE slug = '$slug' LIMIT 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['legal_text_ID'];
		} else {
			return false;
		}
	}
	
	/**
	 * mp. getSitemap
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function getSitemap($params = array())
	{
		$sitemap = array();
		// main sections to build sitemap
		$sitemap['sections'] = array(
			'blog_articles' => array(
				'title'	=> 'Noticias',
				'slug'	=> _reg('site_url') . 'noticias',
			),
			'companies' => array(
				'title'	=> 'Guía Comercial',
				'slug'	=> _reg('site_url') . 'empresas'
			),
			'products' => array(
				'title'	=> 'Productos',
				'slug'	=> _reg('site_url') . 'tienda'
			),
			'basicads' => array(
				'title'	=> 'Clasificados',
				'slug'	=> _reg('site_url') . 'clasificados'
			),
			'events' => array(
				'title'	=> 'Agenda',
				'slug'	=> _reg('site_url') . 'agenda'
			)
		);
		
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 999,
			'order_by'	=> 'order_by DESC',
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
		
		// legal texts
		$sql = " SELECT legal_text_ID, title, slug FROM legal_texts";
		//$sql.= " WHERE site_ID = '" . site_id() . "'" . $where;
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$sitemap['legal_texts'] = $query->result_array();
		} else {
			$sitemap['legal_texts'] = false;
		}
		
		// blog articles
		$sql = " SELECT article_ID, title, slug FROM blog_articles";
		$sql.= " WHERE site_ID = '" . site_id() . "'";
		$sql.= " ORDER BY date_added";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$sitemap['blog_articles'] = $query->result_array();
		} else {
			$sitemap['blog_articles'] = false;
		}
		
		// companies
		$sql = " SELECT company_ID, name AS title, slug FROM companies";
		$sql.= " WHERE site_ID = '" . site_id() . "'";
		$sql.= " ORDER BY name";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$sitemap['companies'] = $query->result_array();
		} else {
			$sitemap['companies'] = false;
		}
		
		// events
		$sql = " SELECT event_ID, title, slug FROM events";
		$sql.= " WHERE site_ID = '" . site_id() . "'";
		$sql.= " ORDER BY event_start";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$sitemap['events'] = $query->result_array();
		} else {
			$sitemap['events'] = false;
		}
		
		// products
		$sql = " SELECT p.product_ID, pd.name AS title, pd.slug FROM products p";
		$sql.= "	LEFT JOIN products_description pd ON p.product_ID = pd.product_ID";
		$sql.= " WHERE p.site_ID = '" . site_id() . "'";
		$sql.= " ORDER BY date_added";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$sitemap['products'] =  $query->result_array();
		} else {
			$sitemap['products'] =  false;
		}
		
		// basicads
		$sql = " SELECT basicad_ID, title, slug FROM basicads";
		$sql.= " WHERE site_ID = '" . site_id() . "'";
		$sql.= " ORDER BY date_added";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$sitemap['basicads'] = $query->result_array();
		} else {
			$sitemap['basicads'] = false;
		}
		/*
		echo '<pre>';
		print_r($sitemap);
		echo '</pre>';
		*/
		
		return $sitemap;
	}

}

/* End of file mp_model.php */
/* Location: ./application/models/mp_model.php */