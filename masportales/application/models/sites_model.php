<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sites_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * sites. getSites
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	public function getSites($params = array())
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
		
		$sql = "SELECT s.*, u.display_name as user_name, u.email as user_email FROM sites s
						LEFT JOIN users u ON (s.owner_ID = u.user_ID)
						WHERE s.subdomain is not null$where";
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
	 * sites. getNSites
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $params
	 *
	 * @return int
	 */
	public function getNSites()
	{
		$sql = "SELECT COUNT(site_ID) as n_sites FROM sites";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$query->free_result();
			return $row->n_sites;
		} else {
			$query->free_result();
			return 0;
		}
	}
	
	/**
	 * sites. getSiteInfo
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $site_id
	 *
	 * @return bool|array
	 */
	public function getSiteInfo($site_id, $owner_id = null)
	{
		$and_site = '';
		if ($owner_id !== null) {
			$and_site = "AND s.owner_ID = '$owner_id'";
		}
		
		$sql = "SELECT s.*, sa.address, sa.zipcode, sa.city, sa.state, sa.country, sa.phone FROM sites s
							LEFT JOIN sites_address sa USING (site_ID)
						WHERE s.site_ID = '$site_id' $and_site
						LIMIT 1;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * sites. saveUser
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $data
	 * @param int $site_id
	 *
	 * @return int
	 */
	public function saveSite($data = array(), $site_id = null)
	{
		if ($data['sites']['domain'] == '') unset($data['sites']['domain']);
		/*
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit();
		*/
		if ($site_id) {
			// update site
			$where = array('user_ID' => $user_id);
			if ($this->db->update('users', $data['users'], $where)) {
				if (isset($data['users_address']) and is_array($data['users_address'])) {
					$this->db->update('users_address', $data['users_address'], $where);
				}
				if (isset($data['users_roles']) and is_array($data['users_roles'])) {
					$this->db->delete('users_roles', $where);
					foreach ($data['users_roles'] as $role) {
						$this->db->insert('users_roles', array('user_ID' => $user_id, 'role_ID' => $role));
					}
				}
				if (isset($data['users_meta']) and is_array($data['users_meta'])) {
					$this->db->delete('users_meta', $where);
					foreach ($data['users_meta'] as $key => $value) {
						$this->db->insert('users_meta', array('user_ID' => $user_id, 'meta_key' => $key, 'meta_value' => $value));
					}
				}
				return $user_id;
			} else {
				return false;
			}
		} else {
			// create new site
			
			// first we create the new franchiser user that will manage the site
			$data['users']['IP'] = $this->input->ip_address();
			$data['users']['date_added'] = date('Y-m-d H:i:s');
			if ($this->db->insert('users', $data['users'])) {
				$user_id = $this->db->insert_id();
				if (isset($data['users_address']) and is_array($data['users_address'])) {
					$data['users_address']['user_ID'] = $user_id;
					$this->db->insert('users_address', $data['users_address']);
				}
				// the role of the user will be 'franquiciado'
				$this->db->insert('users_roles', array('user_ID' => $user_id, 'role_ID' => '2'));
				
				// once we created the user we create the franchise site
				$data['sites']['owner_ID'] = $user_id;
				$data['sites']['status'] = '1';
				$data['sites']['date_added'] = date('Y-m-d H:i:s');
				if ($this->db->insert('sites', $data['sites'])) {
					$site_id = $this->db->insert_id();
					$this->saveSiteSettings($site_id, 'theme', 'default');
					$sql = "INSERT INTO `banners_sites_positions` (`banner_position_ID`, `site_ID`) VALUES (1, $site_id),
									(2, $site_id),
									(6, $site_id),
									(7, $site_id),
									(9, $site_id),
									(10, $site_id),
									(15, $site_id);";
					$query = $this->db->query($sql);
					return $site_id;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}
	
	/**
	 * sites. getSiteOwner
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $company_id
	 *
	 * @return mixed
	 */
	public function getSiteOwner($site_id)
	{
		$sql = "SELECT owner_ID FROM sites WHERE site_ID = $site_id LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['owner_ID'];
		} else {
			return false;
		}
	}
	
	/**
	 * site. saveSiteSettings
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string|array $setting
	 * @param string $value
	 *
	 * @return array
	 */
	public function saveSiteSettings($site_id, $setting, $value = null)
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
								VALUES ($site_id, 'site', '" . $setting . "', '" . $value ."')
							ON DUPLICATE KEY UPDATE meta_value = '" . $value . "';";
			if (!$query = $this->db->query($sql)) {
				$error = true;
			}
		}
		
		return !$error;
	}

}

/* End of file sites_model.php */
/* Location: ./application/models/sites_model.php */