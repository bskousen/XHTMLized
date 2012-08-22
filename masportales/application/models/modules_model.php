<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modules_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * modules. getModule
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $module_ID
	 *
	 * @return mixed
	 */
	public function getModule($module_ID)
	{
		if (is_numeric($module_ID)) {
			$where = "m.module_ID = " . $this->db->escape($module_ID);
		} else {
			$where = "m.module_url = " . $this->db->escape($module_ID);
		}
		
		$sql = "SELECT m.*, mp.name AS parent_name FROM modules m
							LEFT JOIN modules mp ON m.parent_ID = mp.module_ID
						WHERE $where LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$module_data = $query->row_array();
		} else {
			$module_data = false;
		}
		
		
		if ($module_data) {
			/*
			$sql = "SELECT * FROM modules_meta WHERE module_ID = '" . $module_data['user_ID'] . "'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$module_data[$row['meta_key']] = $row['meta_value'];
				}
			}
			*/
			// get modules roles
			$sql = "SELECT r.* FROM modules_roles as mr LEFT JOIN roles as r ON mr.role_ID = r.role_ID WHERE module_ID = '" . $module_data['module_ID'] . "'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$module_data['roles'][$row['role_ID']] = $row['name'];
				}
			} else {
				$module_data['roles'] = array();
			}
		}
		
		return $module_data;
	}
	
	/**
	 * modules. getModules
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $parent_ID
	 *
	 * @return mixed
	 */
	public function getModules($parent_ID = 0)
	{
		$sql = "SELECT * FROM modules WHERE parent_ID = '$parent_ID' ORDER BY menu_order, name";
		$query = $this->db->query($sql);
		
		/*
		echo '<pre>';
		print_r($query->num_rows());
		echo '</pre>';
		*/
		
		if ($query->num_rows() > 0) {
			$modules_menu = array();
			foreach ($query->result_array() as $module) {
				$module_ID = $module['module_ID'];
				$modules_menu[$module_ID] = $module;
				//$modules_menu['sub_modules'] = $this->getMenus($module_ID);
			}
			return $modules_menu;
		} else {
			return false;
		}
	}
	
	/**
	 * modules. getModulesPermission
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $parent_ID
	 *
	 * @return mixed
	 */
	public function getModulesPermission($parent_ID = 0, $roles = array())
	{
		$roles_clauses = array();
		foreach ($roles as $role) {
			$roles_clauses[] = "mr2.name = '$role'";
		}
		$clauses_and = "AND (" . implode(" OR ", $roles_clauses) . ")";
		
		$sql = "SELECT m.* FROM modules m
							LEFT JOIN ( SELECT mr.module_ID, r.* FROM modules_roles AS mr 
														LEFT JOIN roles AS r 
														ON mr.role_ID = r.role_ID ) mr2
							ON m.module_ID = mr2.module_ID
						WHERE m.parent_ID = '$parent_ID' $clauses_and
						ORDER BY m.menu_order, m.name";
		
		//echo '<p>' . $sql . '</p><br /> <br />';
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$modules_menu = array();
			foreach ($query->result_array() as $module) {
				$module_ID = $module['module_ID'];
				$modules_menu[$module_ID] = $module;
				//$modules_menu['sub_modules'] = $this->getMenus($module_ID);
			}
			return $modules_menu;
		} else {
			return false;
		}
	}

}

/* End of file modules_model.php */
/* Location: ./application/models/modules_model.php */