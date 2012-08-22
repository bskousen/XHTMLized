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
class MP_Controller extends CI_Controller {

	protected $settings = array();
	
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
		//$this->_set_defaults();
	}
	
	private function _set_defaults()
	{
		$this->settings = array(
			'base_url'				=> base_url(),
			'base_path'				=> '/Users/eloypineda/Dropbox/workspace/www/masportales/',
			'user_data'				=> false,
			'site_data'				=> false
		);
	}
	
	/**
	 * check if there is any user logged
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @return string $username
	 */
	public function user_logged()
	{
		$this->load->model('users_model');
		
		if ($username = $this->session->userdata('user_logged')) {
			$this->registry->set_user($this->users_model->getUser($username));
			$this->registry->set_company($this->users_model->getUserCompany($this->registry->user('user_ID')));
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * validate user login
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $username
	 * @param string $password
	 *
	 * @return bool|array
	 */
	public function validate_login($username, $password)
	{
		$this->load->model('users_model');
		
		if ($user_data = $this->users_model->getUser($username)) {
			if ($user_data['password'] === sha1($password.$this->config->item('encryption_key')) and $user_data['status'] == 1) {
				// login correcto
				return $user_data;
			} else {
				// password incorrecto
				return false;
			}
		} else {
			// usuario incorrecto
			return false;
		}
		
	}
	
	public function getUserLogged($key = null)
	{
		if ($key === null) {
			return $this->registry->user();
		} elseif (is_string($key)) {
			return $this->registry->user($key);
		} else {
			return false;
		}
	}

}

/* End of file mp_Admin_Controller.php */
/* Location: ./application/core/mp_Admin_Controller.php */