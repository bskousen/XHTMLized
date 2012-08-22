<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registry_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * registry. get
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $keyword
	 *
	 * @return mixed
	 */
	public function get($keyword)
	{
		$sql = "SELECT value FROM settings WHERE meta_key = '$keyword' LIMIT 1;";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['value'];
		} else {
			return false;
		}
	}
	
	/**
	 * registry. get
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $group
	 *
	 * @return mixed
	 */
	public function get_group($group, $site_id = 0)
	{
		$sql = "SELECT meta_key, meta_value
						FROM settings
						WHERE meta_group = '$group' AND site_ID = '$site_id';";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}
	
	/**
	 * registry. set
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $keyword
	 *
	 * @return mixed
	 */
	public function set($site_ID, $group, $key, $value)
	{
		$this->db->insert('settings', array(
			'site_ID' => $site_ID,
			'group'		=> $group,
			'key'			=> $key,
			'value'		=> $value
		));
	}
	
	/**
	 * registry. get_site_id
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $http_host
	 * @param string $look_by
	 *
	 * @return mixed
	 */
	public function get_site_id($http_host, $look_by = 'subdomain')
	{
		$sql = "SELECT site_ID FROM sites WHERE $look_by = '$http_host' LIMIT 1;";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->site_ID;
		} else {
			return false;
		}
	}
	
	/**
	 * registry. get_site
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $site_id
	 *
	 * @return mixed
	 */
	public function get_site($site_id)
	{
		$sql = "SELECT * FROM sites WHERE site_ID = '$site_id' LIMIT 1;";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$site_data = $query->row();
			$sql = "SELECT *
							FROM users
								LEFT JOIN users_address USING(user_ID)
							WHERE user_ID = '" . $site_data->owner_ID . "'
							LIMIT 1;";
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				$site_data->owner_data = $query->row();
			} else {
				$site_data->owner_data = false;
			}
			return $site_data;
		} else {
			return false;
		}
	}

}

/* End of file registry_model.php */
/* Location: ./application/models/registry_model.php */