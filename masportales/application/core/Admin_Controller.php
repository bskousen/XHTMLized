<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Administration Controller that extends CodeIgniter Controller
 *
 * This Controller must manage all the routing and security and permisons
 *
 * @since 0.5
 *
 * @package masPortales
 * @subpackage Administration
 */
class Admin_Controller extends MP_Controller {

	/**
	 * mpAdmin Controller construct
	 *
	 * @access public
	 * @since 0.5
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->registry->set('environment', 'back-end', 'request');
	}
	
	public function _remap($method, $arguments = array())
	{
		global $class;
		
		$this->load->model('modules_model');
		$this->load->model('sites_model');
		
		$this->registry->set('section', $method, 'request');
		$this->registry->set('module', $class, 'request');
		
		(isset($arguments[0])) ? $this->registry->set('action', $arguments[0], 'request') : $this->registry->set('action','index', 'request');
		
		if ($this->user_logged()) {
			$view = 'admin_layout';
			if ($this->registry->user('user_ID') != $this->sites_model->getSiteOwner(site_id()) and !in_array('administrador', $this->registry->user('roles'))) {
				echo "<p>No es el propietario de este sitio. Acceda a su sitio.</p>";
				echo '<pre>';
				exit();
			}
			$this->registry->set_module($this->modules_model->getModule(($method == 'index') ? $class : $method)); // TODO
			if (!$this->_have_permissions()) mp_redirect('admin/login/logout'); // show_error('No tiene permisos.'); // TODO: error when no permissons
			$this->getMenu();
		} else {
			$view = 'login';
			$this->settings['form_action'] = _reg('site_url') . 'admin/login';
		}
		
		$function = '_' . _reg('section') . '_' . _reg('action');
		
		if (method_exists($this, $function)) {
		  $this->settings['data'] = $this->$function($arguments);
		} else {
		  show_404('method ' . $function . ' in class ' . $class . ' doesn\'t exist.');
		  //this->settings['message'] = 'NO existe el metodo.';
		}
		$this->load->view($view, $this->settings);
	}
	
	private function _set_defaults()
	{
		$this->settings = array(
			'css_path'				=> 'application/views/admin/css/',
			'base_url'				=> base_url(),
			'base_admin_url'	=> base_url() . 'admin/',
			'message'					=> false
		);
	}
	
	public function _have_permissions()
	{
		$user_roles = $this->registry->user('roles');
		$module_roles = $this->registry->module('roles');
		
		if ($this->registry->request('module') == 'dashboard' or $this->registry->request('module') == 'login') return true;
		
		if (count(array_intersect($user_roles, $module_roles)) > 0) {
			return true;
		} else {
			return false;
		}
		
		//return true;
	}
	
	/**
	 * set an array with the menu tree on $this->settings['menu']
	 *
	 * @access public
	 * @since 0.5
	 */
	public function getMenu()
	{
		$menu_ops = array();
		$this->load->model('modules_model');
		
		$this->settings['left_menu'] = $this->modules_model->getModulesPermission(0, $this->registry->user('roles'));
		
		foreach ($this->settings['left_menu'] as $module_ID => $module) {
			$this->settings['left_menu'][$module_ID]['sub_menu'] = $this->modules_model->getModulesPermission($module_ID, $this->registry->user('roles'));
		}
	}

}

/* End of file Admin_Controller.php */
/* Location: ./application/core/Admin_Controller.php */