<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Callback controller that extends API Controller
 *
 * This Controller must AJAX user login
 *
 * @since 0.5
 *
 * @package masPortales
 * @subpackage API
 */
class Callback extends API_Controller {
	
	public function sendbyemail()
	{
		$this->load->library('form_validation');
		$this->load->helper('captcha');
		
		$this->form_validation->set_rules('byname', 'Tu nombre', 'trim|required|xss_clean');
		$this->form_validation->set_rules('byemail', 'Tu email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('toname', 'Nombre de tu amigo', 'trim|required|xss_clean');
		$this->form_validation->set_rules('toemail', 'Email de tu amigo', 'trim|required|valid_email|xss_clean');
		
		if (check_captcha()) {
			if ($this->form_validation->run() == false) {
				echo json_encode(array('sentemail' => false, 'message' => validation_errors()));
				exit();
			} else {
				$data = array(
					'sentemails' => array(
						'byname'		=> $this->input->post('byname'),
						'byemail'		=> $this->input->post('byemail'),
						'toname'		=> $this->input->post('toname'),
						'toemail'		=> $this->input->post('toemail'),
						'title'			=> $this->input->post('title'),
						'permalink' => $this->input->post('permalink'),
						'IP'				=> $this->input->ip_address(),
						'date_sent' => date('Y-m-d H:i:s')
					)
				);
				if ($this->_send_by_email($data)) {
					echo json_encode(array('sentemail' => true, 'message' => 'Email enviado correctamente.'));
					exit();
				} else {
				  echo json_encode(array('sentemail' => false, 'message' => 'Ha habido un fallo al enviar el email, inténtelo de nuevo más tarde si es tan amable.'));
				  exit();
				}
				/*
				TODO: estadisticas internas del sitio.
							registrar en la DB todas las noticias, productos, eventos, etc. que se envían por email.
				if ($sentemails_id = $this->stats_model->sentEmail($data)) {
					$data['user']['user_ID'] = $user_id;
					$this->_send_by_email($data);
					echo json_encode(array('registered' => true, 'message' => 'Email enviado correctamente.'));
					exit();
				} else {
				  echo json_encode(array('registered' => false, 'message' => 'Ha habido un fallo al enviar el email, inténtelo de nuevo más tarde si es tan amable.'));
				  exit();
				}
				*/
			}
		} else {
			echo json_encode(array('sentemail' => false, 'message' => 'El texto introducido no corresponde con el de la imagen.'));
			exit();
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
	
	private function _send_by_email($data)
	{
		$email_html = '<p>Estimado/a ' . $data['sentemails']['toname'] . '</p>';
		$email_html.= '<p>Su amigo/a ' . $data['sentemails']['byname'] . ' piensa que la siguiente noticia le puede interesar:</p>';
		$email_html.= '<p><a href="' . $data['sentemails']['permalink'] . '">' . $data['sentemails']['title'] . '</a></p>';
		$email_html.= '<p>Un saludo,</p>';
		$email_html.= '<p>' . $data['sentemails']['byname'] . '</p>';
		
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);

		$this->email->from($data['sentemails']['byemail'], $data['sentemails']['byname']);
		$this->email->to($data['sentemails']['toemail']);
		
		$this->email->subject($data['sentemails']['byname'] . ' te envía una noticia de +Portales');
		$this->email->message($email_html);
		
		if($this->email->send())
			return true;
		else
			return false;
	}
}

/* End of file callback.php */
/* Location: ./application/controllers/callback.php */