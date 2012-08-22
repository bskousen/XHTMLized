<?php

class Login extends Admin_Controller
{

	public function _index_index()
	{
		/*
		echo '<pre>';
		print_r($this);
		echo '</pre>';
		*/
		
		if ($user_data = $this->validate_login($this->input->post('user_login'), $this->input->post('password'))) {
			$this->session->set_userdata(array('user_logged' => $user_data['username']));
			mp_redirect('admin/dashboard');
		} else {
			$this->session->set_flashdata('login_error', 'Los datos de usuario/contraseña indicados no son correctos.');
			mp_redirect('admin');
		}
	}
	
	public function _logout_index()
	{
		$this->session->sess_destroy();
		mp_redirect('admin');
	}

}

/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */