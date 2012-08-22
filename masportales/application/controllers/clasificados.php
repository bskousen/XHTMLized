<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clasificados extends Front_Controller {

	public function _remap($method, $arguments = array())
	{
		global $class;
		
		$this->load->model('basicads_model');
		
		$this->registry->set('module', $class, 'request');
		$this->settings['module_url']	= _reg('site_url') . $class . '/';
		
		if ($method == 'index' and !$arguments) {
			$this->registry->set('section', 'anuncios', 'request');
			$this->registry->set('basicad_id', false, 'request');
		} elseif ($basicad_id = $this->basicads_model->slugFor($method)) {
			$this->registry->set('section', 'anuncio', 'request');
			$this->registry->set('basicad_id', $basicad_id, 'request');
		} elseif (method_exists($this, '_' . $method) and is_callable(array($this, '_' . $method))) {
			$this->registry->set('section', $method, 'request');
			$this->registry->set('basicad_id', ($arguments) ? $arguments[0] : null, 'request');
		} else {
			show_404();
		}
		
		$function = '_' . $this->registry->request('section');
		if (method_exists($this, $function)) {
			$this->settings['data'] = $this->$function($this->registry->request('basicad_id'));
		} else {
			show_404();
		}
		$this->columns(); // TODO
		$this->load->view('themes/default/layout', $this->settings);
	}
	
	public function _anuncios()
	{
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Clasificados');
		$this->registry->set_meta('keywords', $this->registry->site('basicads_keywords'));
		$this->registry->set_meta('description', $this->registry->site('basicads_description'));
		
		$params_basicads = array(
			'start'			=> 0,
			'limit'			=> 10,
			'filter_by'	=> 'b.status',
			'filter'		=> 'publicado',
			'order_by'	=> 'RAND()'
		);
		
		$basicads	= $this->basicads_model->getBasicAds($params_basicads);
		
		return array(
			'basicads'			=> $basicads,
			'search_query'	=> false
		);
	}
	
	public function _search()
	{
		$this->registry->set('section', 'anuncios', 'request');
		$search_query = $this->input->post('searchquery', true);
		
		$params_basicads = array(
			'start'			=> 0,
			'limit'			=> 10,
			'search_by'	=> ($search_query) ? array('title', 'content') : false,
			'search'		=> array($search_query, $search_query),
			'filter_by'	=> 'b.status',
			'filter'		=> 'publicado'
		);
		
		$basicads	= $this->basicads_model->getBasicAds($params_basicads);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Clasificados . Resultado para la búsqueda: ' . $search_query);
		$this->registry->set_meta('keywords', $this->registry->site('basicads_keywords'));
		$this->registry->set_meta('description', $this->registry->site('basicads_description'));
		
		return array(
			'basicads'			=> $basicads,
			'search_query'	=> $search_query
		);
	}
	
	public function _anuncio($basicad_id)
	{
		$this->load->library('form_validation');
		$this->load->helper('captcha');
		$vals = array(
			'img_path'	=> _reg('base_path') . 'usrs/captcha/',
			'img_url'		=> _reg('base_url') .  'usrs/captcha/'
		);
		#https://salinasjavi.wordpress.com/2010/06/15/convertir-time-a-timestamp-en-php/
		/*setlocale(LC_TIME, "es_ES");
		echo strtotime("now").'<br />';
		$mesesmas= strtotime("-2 month 5 days");
		var_dump($mesesmas);
		echo "ESTE ".date("r",$mesesmas);
		echo date("r","1340279908");*/
		
		$cap = create_captcha($vals);
		
		$data = array(
			'captcha_time'	=> $cap['time'],
			'ip_address'		=> $this->input->ip_address(),
			'word'					=> $cap['word']
		);
		
		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);
		
		if (isset($_POST['bid'])) {
			//if (check_captcha()) {
				$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
				
				$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
				$this->form_validation->set_message('valid_email', 'El campo \'%s\' debe contener un email válido.');
				
				$this->form_validation->set_rules('name', 'Nombre', 'trim|required|xss_clean');
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
				$this->form_validation->set_rules('phone', 'Teléfono', 'trim|xss_clean');
				$this->form_validation->set_rules('message', 'Mensaje', 'trim|xss_clem|strip_tags');
				
				if ($this->form_validation->run() and check_captcha()) {
					/*
					$this->_save_comment();
					$this->registry->set_message(array(
						'class'		=> 'success',
					  'content'	=> 'Formulario enviado al usuario. Gracias por su interés'
					));
					*/
					$this->registry->set_message($this->_save_comment($basicad_id));
				} else {
					$this->registry->set_message(array(
						'class'		=> 'error',
					  'content'	=> 'Debe indicar el texto de la imagen.'
					));
				}
			//}
		}
		$basicad = $this->basicads_model->getBasicAd($basicad_id);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Clasificados . ' . $basicad['title']);
		$this->registry->set_meta('keywords', $basicad['meta_keywords']);
		$this->registry->set_meta('description', $basicad['meta_description']);
		
		return array(
			'basicad'					=> $basicad,
			'basicad_images'	=> $this->basicads_model->getBasicAdImages($basicad_id),
			'basicad_owner'		=> $this->users_model->getUser($basicad['user_ID']),
			'captcha'					=> $cap
		);
	}
	
	private function _save_comment($basicad_id)
	{
		$data = array();
		
		$data['basicads_contacts'] = array(
			'basicad_ID'			=> $this->input->post('bid'),
			'author'					=> $this->input->post('name', true),
			'author_email'		=> $this->input->post('email', true),
			'author_phone'		=> $this->input->post('phone', true),
			'author_IP'				=> $this->input->ip_address(),
			'date_added'			=> date('Y-m-d H:i:s'),
			'content' 				=> $this->input->post('message', true),
			'agent'						=> $this->input->user_agent(),
			'status'					=> 'nuevo'
		);
		
		if ($this->registry->user()) {
			$data['basicads_contacts']['user_ID'] = $this->registry->user('user_ID');
		}
		
		if ($this->basicads_model->sendBasicAdContactEmail($data['basicads_contacts'], false, $data['basicads_contacts']['content'], $basicad_id)) {
			if ($basicad_contact_id = $this->basicads_model->saveBasicAdContact($data)) {
				return array(
					'class'		=> 'success',
				  'content'	=> 'Mensaje enviado correctamente.'
				);
			} else {
				return array(
					'class'		=> 'error',
				  'content'	=> 'Error al guardar el mensaje.'
				);
			}
		} else {
			return array(
				'class'		=> 'error',
			  'content'	=> 'Error al enviar el mensaje.'
			);
		}
	}

	# http://localhost/masportales/index.php/clasificados/refreshBasicads
	private function _refreshBasicads()
	{
		$basicAds = $this->basicads_model->getBasicAds();
	//	var_dump($basicAds);
		foreach ($basicAds as $basicAd) {
			$date_activation_timestamp = strtotime($basicAd["date_activation"]);
			//$date_activation_2months = $date_activation_timestamp + "5184000";
			$date_activation_2months = strtotime("+2 months", $date_activation_timestamp);
			$date_activation_5days = $date_activation_timestamp + 4752000;
			$date_activation_4days = $date_activation_timestamp + 4838400;
			$now = strtotime("now");
			/*echo "4 DAYS ".$date_activation_4days;
			echo "<br />";
			echo "5 DAYS ".$date_activation_5days;
			echo "<br />";
			echo "TIMESTAMP ".$date_activation_2months;
			echo "<br />";
			echo "HORA ".$basicAd["date_activation"];
			echo "<br />";
			echo "NOW ".$now;
			echo "<br />";
			echo $date_activation_timestamp;*/
			//echo "5 DAYS ".$date_expiration_5days;
			if ($now >= $date_activation_2months and $date_activation_timestamp != null ) {
				//borra basicAds
				if($this->basicads_model->deleteBasicAd($basicAd["basicad_ID"]))
				{
					$this->_delete_basicAd($basicAd["basicad_ID"]);
				}
			} elseif ($now >= $date_activation_5days and $now <= $date_activation_4days and $date_activation_timestamp != null) {
				//manda email
				$this->basicads_model->sendEmail($basicAd);
			}
		}
		//exit();
	}

	/*private function _updateMail($basicad_id)
	{
		$basicAd = $this->basicads_model->getBasicAd($basicad_id);
		if (!$basicAd) {
   			//ERROR
		}
		if ($this->input->post('time') == "moredays") {
			$now = strtotime("now");
			
			$date_activation_timestamp = strtotime($basicAd["date_activation"]);
			$date_activation = strtotime("+2 months", $now);
			//var_dump($date_activation);
			$date_activation = date("Y-m-d H:i:s",$date_activation);
		    //var_dump($date_activation); exit();
			$where = array('basicad_ID' => $basicad_id);
			if ($this->db->update('basicads', array('date_activation' => $date_activation), $where)) {
				$this->registry->set_message(array(
				  'class'		=> 'success',
				  'content'	=> 'Anuncio actualizado 60 dias más.'
				));

				$this->registry->set('action','anuncios', 'request');
			}
		} elseif ($this->input->post('time') == "delete") {
			// borra el anuncio
			if($this->basicads_model->deleteBasicAd($basicad_id))
			{
				$this->_delete_basicAd($basicad_id);

				$this->registry->set_message(array(
				  'class'		=> 'success',
				  'content'	=> 'Anuncio borrado.'
				));

				$this->registry->set('action','anuncios', 'request');
			}
		}

		return array(
			'basicad'		=> $this->basicads_model->getBasicAd($basicad_id)
		);
	}*/

	private function _delete_files($file)
	{
		$file = explode('.', $file);
		unlink(_reg('base_path') ."usrs/empresas/".$file[0].".".$file[1]);
		unlink(_reg('base_path') ."usrs/empresas/".$file[0]."_96x96.".$file[1]);
		unlink(_reg('base_path') ."usrs/empresas/".$file[0]."_210x96.".$file[1]);
		unlink(_reg('base_path') ."usrs/empresas/".$file[0]."_210x210.".$file[1]);
	}

	private function _delete_basicAd($basicad_id)
	{
		// borra basicAdContact si tiene algo
		if($this->basicads_model->getBasicAdsContacts($basicad_id)) 
		{
			$this->basicads_model->deleteBasicAdContact($basicad_id);
		}

		// borra basicAdImages y sus ficheros si tiene algo
		if($this->basicads_model->getBasicAdImages($basicad_id)) 
		{
			$this->basicads_model->deleteBasicAdImages($basicad_id);

			$basicAdImages = $this->basicads_model->getBasicAdImages($basicad_id);
			if ($basicAdImages) {
				foreach ($basicAdImages as $basicAdImage) {
					$this->_delete_files($basicAdImage["uri"]);
				}
			}
		}
	}

}

/* End of file clasificados.php */
/* Location: ./application/controllers/clasificados.php */