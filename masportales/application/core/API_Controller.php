<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * API Controller that extends CodeIgniter Controller
 *
 * This Controller must manage all request in the background
 *
 * @since 0.5
 *
 * @package masPortales
 * @subpackage API
 */
class API_Controller extends MP_Controller {

	/**
	 * API Controller construct
	 *
	 * @access public
	 * @since 0.5
	 *
	 */
	public function __construct()
	{
		global $class;
		parent::__construct();
		
		$this->settings['base_path']			= $_SERVER{'DOCUMENT_ROOT'} . '/';
		$this->settings['css_path']				= 'application/views/themes/default/css/';
		$this->settings['js_path']				= 'application/views/themes/default/js/';
		$this->settings['theme_path']			= 'application/views/themes/default/';
		$this->settings['myaccount']			= true;
		
		if ($class == 'cart' or $class = 'login') {
			if (!IS_AJAX) show_error('You don\'t have permisson.', 401);
		} elseif (!$this->user_logged() or !IS_AJAX) {
			show_error('You don\'t have permisson.', 401);
		}
	}
	
	/*
	public function _remap($method, $arguments = array())
	{
		global $class;
		
		$this->load->model('modules_model');
		
		$this->settings['section']		= $method;
		
		$this->registry->set('module', $class, 'request');
		$this->settings['module_url']	= base_url() . 'micuenta/' . $class . '/';
		
		(isset($arguments[0])) ? $this->settings['action'] = $arguments[0] : $this->settings['action'] = 'index';
		
		if ($this->user_logged()) {
			$this->settings['module_data'] = $this->modules_model->getModule(($method == 'index') ? $class : $method); // TODO
			//if (!$this->_have_permissions()) show_error('No tiene permisos.');
			//$this->getMenu();
		} else {
			show_error('You don\'t have permisson.' , 401);
		}
		
		$function = '_' . $this->settings['section'] . '_' . $this->settings['action'];
		
		if (method_exists($this, $function)) {
		  $this->settings['data'] = $this->$function($arguments);
		} else {
		  show_404('method ' . $function . ' in class ' . $class . ' doesn\'t exist.');
		  //this->settings['message'] = 'NO existe el metodo.';
		}
		
		//$this->load->view($view, $this->settings);
		$this->load->view('themes/default/layout', $this->settings);
	}
	*/

}

/* End of file Account_Controller.php */
/* Location: ./application/core/Account_Controller.php */