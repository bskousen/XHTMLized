<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banners_model extends CI_Model
{

	/**
	 * banners
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param
	 *
	 * @return
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * banners. getBanners
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $limit
	 *
	 * @return array
	 */
	public function getBanners($params = array())
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 20,
			'order_by'	=> false,
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
			if (is_array($params['filter_by'])) {
				foreach ($params['filter_by'] as $key => $value) {
					$where.= " AND " . $value . " = '" . $params['filter'][$key] . "'";
				}
			} elseif (is_string($params['filter_by'])) {
				$where.= " AND " . $params['filter_by'] . " = '" . $params['filter'] . "'";
			}
		} else {
			
		}
		$sql = "SELECT b.*, bp.name AS position_name, bt.name AS type_name, bt.width, bt.height FROM banners b
							LEFT JOIN banners_positions bp USING(banner_position_ID)
							LEFT JOIN banners_types bt USING(banner_type_ID)
						WHERE site_ID = '" . site_id() . "'$where";
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
	 * banners. getNBanners
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @return int
	 */
	public function getNBanners($params = array())
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
		
		$sql = "SELECT COUNT(banner_ID) as n_banners FROM banners WHERE site_ID = '" . site_id() .  "'$where;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$query->free_result();
			return $row->n_banners;
		} else {
			$query->free_result();
			return 0;
		}
	}
	
	/**
	 * banners. getBanner
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $banner_id
	 *
	 * @return bool|array
	 */
	public function getBanner($banner_id)
	{
		//$sql = "SELECT * FROM banners WHERE banner_ID = '$banner_id' AND site_ID = '" . site_id() . "' LIMIT 1";
		$sql = "SELECT b.*, bc.name AS contract_name, bc.quantity as contract_qty, bc.contract_type, bp.name AS position_name, bt.name AS type_name, bt.width, bt.height, bsr.prints, bsr.clicks FROM banners b
							LEFT JOIN 
								(SELECT banners_contracts.*, banners_contracts_types.keyword AS contract_type FROM banners_contracts
								 LEFT JOIN banners_contracts_types USING(banner_contract_type_ID)) bc
								USING(banner_contract_ID)
							LEFT JOIN banners_positions bp USING(banner_position_ID)
							LEFT JOIN banners_types bt USING(banner_type_ID)
							LEFT JOIN banners_stats_resume bsr USING(banner_ID)
						WHERE banner_ID = '$banner_id' AND b.site_ID = '" . site_id() . "';";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
		/*
		$and_banner = '';
		if ($banner_id !== null) {
			$and_banner = "AND b.banner_ID = '$banner_id'";
		}
		
		$sql = "SELECT b.*, bi.uri as main_image FROM banners b
							LEFT JOIN banners_images bi USING (banner_ID)
						WHERE b.banner_ID = '$banner_id' $and_banner
						LIMIT 1;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
		*/
	}
	
	/**
	 * banners. getBannerImages
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $banner_id
	 *
	 * @return bool|array
	 */
	/*
	public function getBannerImages($banner_id)
	{
		$sql = "SELECT * FROM banners_images WHERE banner_ID = '$banner_id';";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	*/
	
	/**
	 * banners. getUserBanners
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $user_id
	 * @param int $limit
	 *
	 * @return array
	 */
	/*
	public function getUserBanners($user_id, $limit = 20)
	{
		$sql = "SELECT b.*, bi.uri FROM banners b
						LEFT JOIN
							(SELECT uri, banner_ID FROM banners_images WHERE main = '1') bi USING (banner_ID)
						WHERE user_ID = '$user_id'
						ORDER BY date_added DESC LIMIT $limit;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	*/
	
	/**
	 * banners. saveBanner
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $data
	 * @param int $banner_id
	 *
	 * @return bool
	 */
	public function saveBanner($data, $banner_id = false)
	{
		if ($banner_id) {
			// update banner
			$where = array('banner_ID' => $banner_id);
			if ($this->db->update('banners', $data['banners'], $where)) {
				//$this->db->delete('banners_images', $where);
			} else {
				$banner_id = false;
			}
		} else {
			// or create banner
			$data['banners']['site_ID'] = site_id();
			$data['banners']['date_added'] = date('Y-m-d H:i:s');
			if ($this->db->insert('banners', $data['banners'])) {
				$banner_id = $this->db->insert_id();
				$sql = "INSERT INTO banners_sites_positions (banner_position_ID, site_ID, quantity)
									VALUES (" . $data['banners']['banner_position_ID'] .", " . site_id() . ", 1)
								ON DUPLICATE KEY UPDATE quantity = quantity+1;";
				$query = $this->db->query($sql);
			} else {
				$banner_id = false;
			}
		}
		
		return $banner_id;
	}
	
	/**
	 * banners. deleteBanner
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $banner_id
	 *
	 * @return bool
	 */
	public function deleteBanner($banner_id)
	{
		$where = array('banner_ID' => $banner_id);
		if ($this->db->delete('banners', $where) and
				$this->db->delete('banners_stats_resume', $where) and
				$this->db->delete('banners_stats', $where)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * banners. updateBannerStatus
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $banner_id
	 * @param string $status (activo|inactivo|pendiente)
	 *
	 * @return bool
	 */
	public function updateBannerStatus($banner_id, $status)
	{
		$where = array('banner_ID' => $banner_id);
		if ($this->db->update('banners', array('status' => $status), $where)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * banners. getBannersPositions
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $start
	 * @param int $limit
	 *
	 * @return bool
	 */
	public function getBannersPositions($start = 0, $limit = 20)
	{
		//$sql = "SELECT * FROM banners_positions ORDER BY name ASC LIMIT $start, $limit";
		$sql = "SELECT bp.*, bt.name AS type_name, bt.width, bt.height, bsp.site_ID, bsp.quantity AS posted FROM banners_positions bp
							LEFT JOIN banners_sites_positions bsp USING(banner_position_ID)
							LEFT JOIN banners_types bt USING(banner_type_ID)
						WHERE site_ID = '" . site_id() . "' or site_ID IS NULL
						LIMIT $start, $limit;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * banners. getBannersContract
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $contract_id
	 *
	 * @return array
	 */
	public function getBannersContract($contract_id)
	{
		$sql = "SELECT bc.*, bct.name AS contract_name, bct.keyword FROM banners_contracts bc
							LEFT JOIN banners_contracts_types bct USING(banner_contract_type_ID)
						WHERE site_ID = '" . site_id() . "' AND banner_contract_ID = '$contract_id'
						LIMIT 1;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * banners. getBannersContracts
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @return bool
	 */
	public function getBannersContracts()
	{
		$sql = "SELECT bc.*, bct.name AS contract_name, bct.keyword FROM banners_contracts bc
							LEFT JOIN banners_contracts_types bct USING(banner_contract_type_ID)
						WHERE site_ID = '" . site_id() . "' or site_ID IS NULL;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * banners. saveBannersContract
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $data
	 * @param int $contract_id
	 *
	 * @return bool
	 */
	public function saveBannersContract($data, $contract_id = false)
	{
		if ($contract_id) {
			// update banner contract
			$where = array('banner_contract_ID' => $contract_id);
			if ($this->db->update('banners_contracts', $data['banners_contracts'], $where)) {
				//$this->db->delete('banners_images', $where);
			} else {
				$contract_id = false;
			}
		} else {
			// or create banner contract
			$data['banners_contracts']['site_ID'] = site_id();
			if ($this->db->insert('banners_contracts', $data['banners_contracts'])) {
				$contract_id = $this->db->insert_id();
			} else {
				$contract_id = false;
			}
		}
		return $contract_id;
	}
	
	/**
	 * banners. deleteBannersContract
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $contract_id
	 *
	 * @return bool
	 */
	public function deleteBannersContract($contract_id)
	{
		$where = array('banner_contract_ID' => $contract_id);
		if ($this->db->delete('banners_contracts', $where)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * banners. getBannersContractsTypes
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @return bool
	 */
	public function getBannersContractsTypes()
	{
		$sql = "SELECT * FROM banners_contracts_types;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * banners. getBannersStats
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $banner_id
	 * @param string $resume_key = null
	 *
	 * @return array
	 */
	public function getBannerStats($banner_id, $resume_key = null)
	{
		$stats = false;
		$sql = "SELECT * FROM banners_stats
						WHERE banner_id = '$banner_id' AND site_id = '" . site_id() . "';";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$stats['log'] = $query->result_array();
			$sql = "SELECT * FROM banners_stats_resume
							WHERE banner_id = '$banner_id' AND site_id = '" . site_id() . "'
							LIMIT 1;";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				$stats['resume'] = $query->row();
			}
		}
		if ($resume_key and $stats) {
			return $stats['resume']->$resume_key;
		}
		return $stats;
	}
	
	/**
	 * banners. getBannersSetting
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @return array
	 */
	public function getBannersSetting()
	{
		$settings = false;
		$sql = "SELECT * FROM settings
						WHERE meta_group = 'banners' AND site_id = '" . site_id() . "';";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $setting) {
				$settings[$setting->meta_key] = $setting->meta_value;
			}
		}
		return $settings;
	}
	
	/**
	 * banners. saveBannersSetting
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $setting
	 * @param string $value
	 *
	 * @return array
	 */
	public function saveBannersSetting($setting, $value = null)
	{
		$sql = "INSERT INTO settings (site_ID, meta_group, meta_key, meta_value)
							VALUES (" . site_id() . ", 'banners', '" . $setting . "', '" . $value ."')
						ON DUPLICATE KEY UPDATE meta_value = '" . $value . "';";
		if ($query = $this->db->query($sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	
	/**
	 * banners. logBannerPrinted
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $banner_id
	 *
	 * @return bool
	 */
	public function logBannerPrinted($banner_id)
	{
		$data = array(
			'banner_id'	=> $banner_id,
			'site_ID'		=> site_id(),
			'action'		=> 'print',
			'date_added'	=> date('Y-m-d H:i:s'),
			'IP'					=> $this->input->ip_address()
		);
		if ($this->db->insert('banners_stats', $data)) {
			$sql = "INSERT INTO banners_stats_resume (banner_ID, site_ID, prints)
								VALUES ('$banner_id', '" . site_id() . "', '1')
							ON DUPLICATE KEY UPDATE prints = prints+1;";
			$query = $this->db->query($sql);
			// check if exceed the quota change the banner to inactive
			$n_prints = $this->getBannerStats($banner_id, 'prints');
			$banner_data = $this->getBanner($banner_id);
			if ($banner_data['contract_type'] == 'prints' and $n_prints > $banner_data['contract_qty']) {
			  $this->updateBannerStatus($banner_id, 'inactivo');
			}
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * banners. logBannerClicked
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $banner_id
	 *
	 * @return bool
	 */
	public function logBannerClicked($banner_id)
	{
		$data = array(
			'banner_id'	=> $banner_id,
			'site_ID'		=> site_id(),
			'action'		=> 'click',
			'date_added'	=> date('Y-m-d H:i:s'),
			'IP'					=> $this->input->ip_address()
		);
		if ($this->db->insert('banners_stats', $data)) {
			$sql = "INSERT INTO banners_stats_resume (banner_ID, site_ID, clicks)
								VALUES ('$banner_id', '" . site_id() . "', '1')
							ON DUPLICATE KEY UPDATE clicks = clicks+1;";
			$query = $this->db->query($sql);
			// check if exceed the quota change the banner to inactive
			$n_clicks = $this->getBannerStats($banner_id, 'clicks');
			$banner_data = $this->getBanner($banner_id);
			if ($banner_data['contract_type'] == 'clicks' and $n_clicks > $banner_data['contract_qty']) {
			  $this->updateBannerStatus($banner_id, 'inactivo');
			}
			return true;
		} else {
			return false;
		}
	}

}

/* End of file banners_model.php */
/* Location: ./application/models/banners_model.php */