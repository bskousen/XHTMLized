<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Login controller that extends API Controller
 *
 * This Controller must AJAX user login
 *
 * @since 0.5
 *
 * @package masPortales
 * @subpackage API
 */
class Login extends API_Controller {

	public function index($params=null)
	{	
		/*
		echo '<pre>';
		print_r($this->input->post());
		echo '</pre>';
		*/
		$this->load->library('form_validation');
		$this->form_validation->set_rules('usr', 'Nombre de usuario', 'trim|required|xss_clean');
		$this->form_validation->set_rules('psw', 'Contraseña', 'trim|required|xss_clean');
		
		if ($this->form_validation->run() == false) {
			echo json_encode(array('login' => false, 'message' => 'Debe indicar su usuario y contraseña'));
			exit();
		} else {
			if ($user_data = $this->validate_login($this->input->post('usr'), $this->input->post('psw'))) {
				$this->session->set_userdata(array('user_logged' => $user_data['username']));
				$this->registry->set('section', 'welcome', 'request');
			} else {
				echo json_encode(array('login' => false, 'message' => 'Usuario o contraseña incorrecto'));
				exit();
			}
			echo json_encode(array('login' => true, 'message' => 'Usuario logueado correctamente'));
			exit();
		}
	}
	
	public function forgotpsw()
	{
		$this->load->model('users_model');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('usr', 'Nombre de usuario', 'trim|required|xss_clean');
		
		if ($this->form_validation->run() == false) {
			echo json_encode(array('sent' => false, 'message' => 'Debe indicar el usuario para el que no recuerda la contraseña'));
			exit();
		} else {
			if ($user_data = $this->users_model->getUser($this->input->post('usr')) and $user_data['status']) {
				$this->_send_email_newpassword($user_data);
				echo json_encode(array('sent' => true, 'message' => 'Se le ha enviado un email con su nueva contraseña.'));
				exit();
			} else {
				echo json_encode(array('sent' => false, 'message' => 'No existe el usuario.'));
				exit();
			}
		}
	}
	
	public function register()
	{
		$this->load->model('users_model');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required|xss_clean');
		$this->form_validation->set_rules('surname', 'Apellidos', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('username', 'Nombre de usuario', 'trim|required|is_unique[users.username]|xss_clean');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|matches[password2]');
		$this->form_validation->set_rules('password2', 'Repite contraseña', 'trim|required');
		
		if ($this->form_validation->run() == false) {
			echo json_encode(array('registered' => false, 'message' => validation_errors()));
			exit();
		} else {
			$data = array(
				'users' => array(
					'username'				=> $this->input->post('username'),
					'display_name'		=> $this->input->post('name') . ' ' . $this->input->post('surname'),
					'email'						=> $this->input->post('email'),
					'password'				=> sha1($this->input->post('password').$this->config->item('encryption_key')),
					'status'					=> '0',
					'IP'							=> $this->input->ip_address(),
					'date_modified' 	=> date('Y-m-d H:i:s'),
					'date_added' 			=> date('Y-m-d H:i:s')
				),
				'users_roles' => array('4'),
				'users_address' => array(
					'name' 		=> $this->input->post('name'),
					'surname'	=> $this->input->post('surname')
				)
			);
			if ($user_id = $this->users_model->saveUser($data)) {
				$data['users']['user_ID'] = $user_id;
				$this->_send_email_confirmation($data);
				echo json_encode(array('registered' => true, 'message' => 'Hemos recibido tu solicitud correctamente. En breve recibirá un email para confirmar su cuenta.'));
				exit();
			} else {
			  echo json_encode(array('registered' => false, 'message' => 'Ha habido un fallo al recibir su solicitud, intentelo de nuevo más tarde si es tan amable.'));
			  exit();
			}
			
		}
	}
	
	public function validemail()
	{
		$this->load->model('users_model');
		
		if ($this->users_model->isUserEmail($this->input->post('email'))) {
			echo json_encode(array('registered' => true));
			return true;
		} else {
			echo json_encode(array('registered' => false));
			return false;
		}
	}
	
	public function validusername()
	{
		$this->load->model('users_model');
		
		if ($this->users_model->isUserName($this->input->post('username'))) {
			echo json_encode(array('registered' => true));
			return true;
		} else {
			echo json_encode(array('registered' => false));
			return false;
		}
	}
	
	private function _send_email_confirmation($user)
	{
		$this->load->model('users_model');
		
		$data = array(
			'user_ID' => $user['users']['user_ID'],
			'meta_key' => 'confirmation_user_hash',
			'meta_value' => random_string('unique')
		);
		
		$this->users_model->setUserMeta($data);
		
		$email_html = '<p>Estimado ' . $user['users_address']['name'] . ' ' . $user['users_address']['surname'] . '</p>';
		$email_html.= '<p>Gracias por registrarse en +Portales.</p>';
		$email_html.= '<p>Para activar su cuenta debe pulsar en el siguiente enlace.</p>';
		$email_html.= '<p><a href="' . _reg('site_url') . 'registrarse/confirmation/' . $data['meta_value'] . '">Confirma tu cuenta en +Portales</a></p>';
		$email_html.= '<p>Un saludo,</p>';
		$email_html.= '<p>+Portales</p>';
		
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);

		$this->email->from('no-reply@masportales.es', '+portales');
		$this->email->to($user['users']['email']);
		
		$this->email->subject('Confirma tu cuenta en +Portales');
		$this->email->message($email_html);
		
		$this->email->send();
	}
	
	private function _send_email_newpassword($user)
	{
		$this->load->model('users_model');
		
		$new_password = random_string('alnum', 8);
		
		$this->users_model->updatePassword($user['user_ID'], $new_password);
		
		$email_html = '<p>Estimado ' . $user['display_name'] . '</p>';
		$email_html.= '<p>Le enviamos su nueva contraseña para acceder a +Portales.</p>';
		$email_html.= '<p>Nombre de usuario: ' . $user['username'] . '</p>';
		$email_html.= '<p>Contraseña: ' . $new_password . '</p>';
		$email_html.= '<p>Un saludo,</p>';
		$email_html.= '<p>+Portales</p>';
		
		$email_mssg = "Estimado " . $user['display_name'] . "\r\n
Le enviamos su nueva contraseña para acceder a +Portales.\r\n
Nombre de usuario: " . $user['username'] . ".\r\n
Contraseña: $new_password.\r\n
Un saludo,\r\n
+Portales";
		
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);

		$this->email->from('no-reply@masportales.es', '+portales');
		$this->email->to($user['email']);
		
		$this->email->subject('Nueva contraseña para acceder a +Portales');
		$this->email->message($email_html);
		
		$this->email->send();
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */