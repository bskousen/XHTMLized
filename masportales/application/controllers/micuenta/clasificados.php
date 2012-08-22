<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clasificados extends Account_Controller
{

	public function _index_index()
	{
		$this->load->model('basicads_model');
		
		return $this->basicads_model->getUserBasicAds($this->registry->user('user_ID'));
	}
	
	public function _ad_edit($basicad_id)
	{
		$this->load->model('basicads_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		return array(
			'basicad'						=> $this->basicads_model->getBasicAd($basicad_id, $this->registry->user('user_ID')),
			'basicad_images'		=> $this->basicads_model->getBasicAdImages($basicad_id),
			'categories'				=> $this->basicads_model->getBasicAdsCategories(),
			'basicad_contacts'	=> $this->basicads_model->getBasicAdsContacts($basicad_id)
		);
	}
	
	public function _ad_save()
	{
		$this->load->model('basicads_model');
		$basic_id = $this->input->post('bid', true);
		//$basicad = $this->basicads_model->getBasicAd($basicad_id);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_rules('content', 'Anuncio', 'trim|xss_clean');
		$this->form_validation->set_rules('meta_keywords', 'Palabras claves', 'trim|xss_clean|strip_tags');
		$this->form_validation->set_rules('meta_description', 'Descripción buscadores', 'trim|xss_clean|strip_tags');
		
		if ($this->form_validation->run() == false) {
			$this->registry->set('action', 'edit', 'request');
		} else {
			$this->registry->set('section', 'index', 'request');
			$this->registry->set('action', 'index', 'request');
			
			$data['basicad'] = array(
				'user_ID'						=> $this->registry->user('user_ID'),
				'title'							=> $this->input->post('title'),
				'slug'							=> $this->input->post('slug'),
				'content'						=> strip_tags($this->input->post('content'), '<p><ul><ol><li><br><b><i><u>'),
				'price'							=> $this->input->post('price'),
				'date_modified' 		=> date('Y-m-d H:i:s'),
				'category_ID'				=> $this->input->post('category'),
				'meta_keywords'			=> $this->input->post('meta_keywords'),
				'meta_description'	=> $this->input->post('meta_description')
			);
			$image_main = $this->input->post('image_main', true);
			$tmp_images = array(
				'name'	=> $this->input->post('images_name', true),
				'uri'		=> $this->input->post('images_uri', true),
				'type'	=> $this->input->post('images_type', true)
			);
			$data['basicad_images'] = array();
			if ($tmp_images['name']) {
				foreach ($tmp_images['name'] as $key => $image_name) {
					$data['basicad_images'][$image_name] = array(
						'name'				=> $image_name,
						'uri'					=> $tmp_images['uri'][$key],
						'mime_type'		=> $tmp_images['type'][$key],
						'status'			=> 'publish',
						'main'				=> ($image_name == $image_main) ? 1 : 0,
						'date_added'	=> date('Y-m-d H:i:s')
					);
				}
			} else {
				$data['basicad_images'] = false;
			}
			
			if (!$this->basicads_model->saveBasicAd($data, $basic_id)) {
				$this->registry->set('action', 'edit', 'request');
			} else {
				return $this->basicads_model->getUserBasicAds($this->registry->user('user_ID'));
			}
		}
	}
	
	public function _ad_sendcontact()
	{
		$this->load->model('basicads_model');
		$basicad_contact_id = $this->input->post('cid', true);
		
		$basicad_contact = $this->basicads_model->getBasicAdsContact($basicad_contact_id);
		
		$data['basicads_contacts'] = array(
			'basicad_ID'			=> $basicad_contact['basicad_ID'],
			'author'					=> $this->registry->user('display_name'),
			'author_email'		=> $this->registry->user('email'),
			'author_phone'		=> $this->registry->user('phone'),
			'author_IP'				=> $this->input->ip_address(),
			'date_added'			=> date('Y-m-d H:i:s'),
			'content' 				=> $this->input->post('message'),
			'agent'						=> $this->input->user_agent(),
			'status'					=> 'respuesta',
			'parent'					=> $basicad_contact['basicad_contact_ID'],
			'user_ID'					=> $this->registry->user('user_ID')
		);
		
		if ($this->basicads_model->sendBasicAdContactEmail($data['basicads_contacts'], $basicad_contact, $data['basicads_contacts']['content'], $data['basicads_contacts']['basicad_ID'])) {
			if ($basicad_contact_id = $this->basicads_model->saveBasicAdContact($data)) {
				$this->registry->set_message(array(
					'class'		=> 'success',
				  'content'	=> 'Respuesta enviada correctamente.'
				));
			} else {
				$this->registry->set_message(array(
					'class'		=> 'error',
				  'content'	=> 'Error al guardar la respuesta.'
				));
			}
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al enviar la respuesta.'
			));
		}
		
		$this->registry->set('action', 'message', 'request');
		
		return $data['basicads_contacts'];
	}

	public function _ad_renovar($basicad_id = null)
	{
		//echo "ESTAMOS";
		$this->load->model('basicads_model');

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
		
		$this->form_validation->set_rules('time', 'Tiempo', 'require');
		if ($this->input->post('time')) {
		if ($this->form_validation->run() == false) {
			$this->registry->set('action', 'edit', 'request');
		} else {
		if ($this->input->post('time') == "moredays") {
			$basicAd= $this->basicads_model->getBasicAd($basicad_id);	

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
			$this->registry->set('action', 'edit', 'request');

			return array(
			'basicad'						=> $this->basicads_model->getBasicAd($basicad_id, $this->registry->user('user_ID')),
			'basicad_images'		=> $this->basicads_model->getBasicAdImages($basicad_id),
			'categories'				=> $this->basicads_model->getBasicAdsCategories(),
			'basicad_contacts'	=> $this->basicads_model->getBasicAdsContacts($basicad_id)
		);
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
				
				$this->registry->set('section', 'index', 'request');
				$this->registry->set('action', 'index', 'request');


			}
		}

		//$this->load->model('basicads_model');
		if ($basicad_id) {
			return array(
				'basicad'		=> $this->basicads_model->getBasicAd($basicad_id)
			);
		} else {
			$user_basicads = $this->basicads_model->getUserBasicAds($this->registry->user('user_ID'));
			if ($user_basicads) {
				return array(
				'basicad'		=> $user_basicads
			);
			}
		}
	}
} else {
	$user_basicads = $this->basicads_model->getUserBasicAds($this->registry->user('user_ID'));
	if ($user_basicads) {
		return array(
		'basicad'		=> $user_basicads
		);
	}
}
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

	private function _delete_files($file)
	{
		$file = explode('.', $file);
		unlink(_reg('base_path') ."usrs/empresas/".$file[0].".".$file[1]);
		unlink(_reg('base_path') ."usrs/empresas/".$file[0]."_96x96.".$file[1]);
		unlink(_reg('base_path') ."usrs/empresas/".$file[0]."_210x96.".$file[1]);
		unlink(_reg('base_path') ."usrs/empresas/".$file[0]."_210x210.".$file[1]);
	}


}

/* End of file clasificados.php */
/* Location: ./application/controllers/micuenta/clasificados.php */