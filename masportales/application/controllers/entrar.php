<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entrar extends Front_Controller {

	public function _remap($method, $arguments = array())
	{
		global $class;
		
		//$this->load->model('users_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
		
		$this->registry->set('module', $class, 'request');
		$this->settings['module_url']	= _reg('site_url') . $class . '/';
		$this->registry->set('section', ($method == 'index' ? 'login' : $method), 'request');
		
		$function = '_' . $this->registry->request('section');
		
		if (method_exists($this, $function)) {
			$this->settings['data'] = $this->$function($arguments);
		} else {
			show_404();
		}
		
		if ($this->user_logged()) mp_redirect('micuenta');
		$this->columns(); // TODO
		$this->load->view('themes/default/layout', $this->settings);
	}
	
	public function _login()
	{
		$this->form_validation->set_rules('username', 'Nombre de usuario', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|xss_clean');
		
		if ($this->form_validation->run() == false) {
			return true;
		} else {
			if ($user_data = $this->validate_login($this->input->post('username'), $this->input->post('password'))) {
				$this->session->set_userdata(array('user_logged' => $user_data['username']));
				$this->registry->set('section', 'welcome', 'request');
			} else {
				return false;
			}
			return true;
		}
	}
	
	public function _welcome() {}
	
	public function _logout()
	{
		$this->session->sess_destroy();
		mp_redirect();
	}

}

/* End of file noticias.php */
/* Location: ./application/controllers/registrarse.php */