<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	
	
	public function getUser($user_id)
	{
		if (!$user_id) {
			return false;
		}
		if (is_numeric($user_id)) {
			$where = "user_ID = " . $this->db->escape($user_id);
		} else {
			$where = "username = " . $this->db->escape($user_id);
		}
		
		$sql = "SELECT *
						FROM users
							LEFT JOIN users_address USING(user_ID)
						WHERE $where
						LIMIT 1;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$user_data = $query->row_array();
		} else {
			$user_data = false;
		}
		
		if ($user_data) {
			// get user meta data
			$sql = "SELECT * FROM users_meta WHERE user_ID = '" . $user_data['user_ID'] . "'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$user_data[$row['meta_key']] = $row['meta_value'];
				}
			}
			// get user roles
			$sql = "SELECT r.* FROM users_roles as ur LEFT JOIN roles as r ON ur.role_ID = r.role_ID WHERE user_ID = '" . $user_data['user_ID'] . "'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$user_data['roles'][$row['role_ID']] = $row['name'];
				}
			} else {
				$user_data['roles'] = array();
			}
		}
		
		return $user_data;
	}
	
	/**
	 * users. getUsers
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $params
	 *
	 * @return bool
	 */
	public function getUsers($params = array())
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
		
		$sql = "SELECT * FROM users
						WHERE site_ID is NULL$where";
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
		
		
		
		
		
		/*
		$sql = "SELECT * FROM users ORDER BY date_added DESC";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
		*/
	}
	
	/**
	 * users. getNUsers
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $params
	 *
	 * @return int
	 */
	public function getNUsers()
	{
		$sql = "SELECT COUNT(user_ID) as n_users FROM users";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$query->free_result();
			return $row->n_users;
		} else {
			$query->free_result();
			return 0;
		}
	}
	
	public function getUserRoles($user_id = null)
	{
		$roles = array();
		$sql = "SELECT role_ID FROM users_roles WHERE user_ID = '$user_id'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			foreach ($result as $row) {
				$roles[] = $row['role_ID'];
			}
			return $roles;
		} else {
			return array();
		}
	}
	
	/**
	 * users. saveUser
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $data
	 * @param int $user_id
	 *
	 * @return int
	 */
	public function saveUser($data = array(), $user_id = null)
	{
		if ($user_id) {
			// update user
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
			// insert new user
			$data['users']['IP'] = $this->input->ip_address();
			$data['users']['date_added'] = date('Y-m-d H:i:s');
			if ($this->db->insert('users', $data['users'])) {
				$user_id = $this->db->insert_id();
				if (isset($data['users_address']) and is_array($data['users_address'])) {
					$data['users_address']['user_ID'] = $user_id;
					$this->db->insert('users_address', $data['users_address']);
				}
				if (isset($data['users_roles']) and is_array($data['users_roles'])) {
					foreach ($data['users_roles'] as $role) {
						$this->db->insert('users_roles', array('user_ID' => $user_id, 'role_ID' => $role));
					}
				}
				if (isset($data['users_meta']) and is_array($data['users_meta'])) {
					foreach ($data['users_meta'] as $key => $value) {
						$this->db->insert('users_meta', array('user_ID' => $user_id, 'meta_key' => $key, 'meta_value' => $value));
					}
				}
				return $user_id;
			} else {
				return false;
			}
		}
	}
	
	/**
	 * users. addUser
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $data
	 * @param int $user_id
	 *
	 * @return bool
	 */
	public function addUser($data = array())
	{
		if ($this->db->insert('users', $data['user'])) {
			$user_id = $this->db->insert_id();
			if (is_array($data['roles'])) {
				foreach ($data['roles'] as $role) {
					$this->db->insert('users_roles', array('user_ID' => $user_id, 'role_ID' => $role));
				}
			}
			if (is_array($data['user_meta'])) {
				foreach ($data['user_meta'] as $key => $value) {
					$this->db->insert('users_meta', array('user_ID' => $user_id, 'meta_key' => $key, 'meta_value' => $value));
				}
			}
			return $user_id;
		} else {
			return false;
		}
	}
	
	/**
	 * users. updateUser
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $data
	 * @param int $user_id
	 *
	 * @return bool
	 */
	public function updateUser($data = array(), $user_id = null)
	{
		$where = array('user_ID' => $user_id);
		if ($this->db->update('users', $data['user'], $where)) {
			if (isset($data['roles']) and is_array($data['roles'])) {
				$this->db->delete('users_roles', $where);
				foreach ($data['roles'] as $role) {
					$this->db->insert('users_roles', array('user_ID' => $user_id, 'role_ID' => $role));
				}
			}
			$this->db->delete('users_meta', $where);
			if (is_array($data['user_meta'])) {
				foreach ($data['user_meta'] as $key => $value) {
					$this->db->insert('users_meta', array('user_ID' => $user_id, 'meta_key' => $key, 'meta_value' => $value));
				}
			}
			return true;
		} else {
			return false;
		}
	}
	
	public function updatePassword($user_id = null, $psw = null)
	{
		if ($user_id != null and $psw != null) {
			$psw = sha1($psw.$this->config->item('encryption_key'));
			if ($this->db->update('users', array('password' => $psw), array('user_ID' => $user_id))) {
				return true;
			}	else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function isUserEmail($email)
	{
		$sql = "SELECT user_ID FROM users WHERE email='$email' LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->user_ID;
		} else {
			return false;
		}	
	}
	
	public function isUserName($username)
	{
		$sql = "SELECT user_ID FROM users WHERE username='$username' LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->user_ID;
		} else {
			return false;
		}	
	}
	
	/**
	 * users. activeUser
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $user_id
	 *
	 * @return bool
	 */
	public function activeUser($user_id)
	{
		if ($this->db->update('users', array('status' => 1), array('user_ID' => $user_id))) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * users. deactiveUser
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $user_id
	 *
	 * @return bool
	 */
	public function deactiveUser($user_id)
	{
		if ($this->db->update('users', array('status' => 0), array('user_ID' => $user_id))) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * users. deleteUser
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $user_id
	 *
	 * @return bool
	 */
	public function deleteUser($user_id)
	{
		$where = array('user_ID' => $user_id);
		if ($this->db->delete('users', $where)
				and $this->db->delete('users_roles', $where)
				and $this->db->delete('users_meta', $where)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * users. setUserMeta
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function setUserMeta($data)
	{
		if($this->db->insert('users_meta', $data)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * users. getUserMeta
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string|array $data
	 * @param string $search_on values: KEY | VALUE | USERID
	 *
	 * @return array|bool
	 */
	public function getUserMeta($needle, $search_on = 'KEY')
	{
		if ($search_on == 'VALUE') {
			$column = 'meta_value';
		} elseif ($search_on == 'USERID') {
			$column = 'user_ID';
		} else {
			$column = 'meta_key';
		}
		
		$sql = "SELECT * FROM users_meta WHERE $column = '$needle'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
		  return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * users. deleteUserMeta
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $hash
	 *
	 * @return bool
	 */
	public function deleteUserConfirmationHash($hash)
	{
		$where = array('meta_value' => $hash);
		if ($this->db->delete('users_meta', $where)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * users. getRoles
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @return bool|array
	 */
	function getRoles()
	{
		$sql = "SELECT * FROM roles ORDER BY name ASC";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * users. getRole
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $role_id
	 *
	 * @return bool|array
	 */
	public function getRole($role_id)
	{
		$sql = "SELECT * FROM roles WHERE role_ID = '$role_id' LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * users. addRole
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $data
	 *
	 * @return bool|array
	 */
	public function addRole($data = array())
	{
		if ($this->db->insert('roles', $data['role'])) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * users. addRole
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $data
	 * @param int $role_id
	 *
	 * @return bool|array
	 */
	public function updateRole($data = array(), $role_id = null)
	{
		$where = array('role_ID' => $role_id);
		if ($this->db->update('roles', $data['role'], $where)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * users. deleteRole
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $role_id
	 *
	 * @return bool
	 */
	public function deleteRole($role_id)
	{
		$where = array('role_ID' => $role_id);
		if ($this->db->delete('roles', $where)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * users. getUserComments
	 * return all user comments con Blog, Events, Products, etc.
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $user_id
	 *
	 * @return array
	 */
	public function getUserComments($user_id)
	{
		$comments = array();
		
		$sql = "SELECT bc.*, ba.`title` as article_title, ba.`slug` as article_slug FROM blog_comments bc
		  			LEFT JOIN blog_articles ba ON (bc.`article_ID` = ba.`article_ID`)
		  			WHERE bc.user_ID = $user_id";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$comments['blog'] = $query->result_array();
		} else {
			$comments['blog'] = false;
		}
		
		$sql = "SELECT pc.*, pd.`name` as name, pd.`slug` as slug FROM products_comments pc
		  			LEFT JOIN products_description pd ON (pc.`product_ID` = pd.`product_ID`)
		  			WHERE pc.user_ID = $user_id";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$comments['products'] = $query->result_array();
		} else {
			$comments['products'] = false;
		}
		
		return $comments;
	}
	
	/**
	 * users. getUserCompany
	 * return user company data or false if user have not create any company.
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $user_id
	 *
	 * @return array
	 */
	public function getUserCompany($user_id)
	{
		$sql = "SELECT * FROM companies WHERE user_ID = $user_id LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * users. getUserIP
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @return string
	 */
	function getUserIP()
	{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
       
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
   
    return $_SERVER['REMOTE_ADDR'];
  }

}

/* End of file users.php */
/* Location: ./application/models/users.php */