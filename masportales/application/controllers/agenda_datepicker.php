<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agenda extends Front_Controller {

	public function _remap($method, $arguments = array())
	{
		global $class;
		
		$this->load->model('event_model');
		$this->load->model('companies_model');
		$this->load->library('form_validation');
		
		$this->registry->set('module', $class, 'request');
		$this->settings['module_url']	= _reg('site_url') . $class . '/';
		/*
		if (isset($_POST['pid'])) {
			$this->form_validation->set_error_delimiters('<div class="message error">', '</div>');
			
			$this->form_validation->set_message('required', 'Debe rellenar el campo: %s');
			$this->form_validation->set_message('valid_email', 'El campo \'%s\' debe contener un email válido.');
			
			$this->form_validation->set_rules('name', 'Nombre', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('web', 'Web', 'trim|prep_url|xss_clean');
			$this->form_validation->set_rules('message', 'Mensaje', 'trim|xss_clem|strip_tags');
			
			if ($this->form_validation->run()) {
				$this->_save_comment();
			}
		}
		*/
		if ($method == 'index' and !$arguments) {
			$this->registry->set('section', 'eventos', 'request');
			$this->registry->set('event_id', false, 'request');
		} elseif ($event_id = $this->event_model->slugFor($method)) {
			$this->registry->set('section', 'evento', 'request');
			$this->registry->set('event_id', $event_id, 'request');
		} elseif (method_exists($this, '_' . $method) and is_callable(array($this, '_' . $method))) {
			$this->registry->set('section', $method, 'request');
			$this->registry->set('event_id', ($arguments) ? $arguments[0] : null, 'request');
		} else {
			show_404();
		}
		
		$function = '_' . $this->registry->request('section');
		if (method_exists($this, $function)) {
			$this->settings['data'] = $this->$function($this->registry->request('event_id'));
		} else {
			show_404();
		}
		$this->columns(); // TODO
		if ($this->uri->segment(2) != 'calendar') {
			$this->load->view('themes/default/layout', $this->settings);
		}
	}
	
	public function _evento($event_id)
	{
		$this->load->helper('captcha');
		$vals = array(
			'img_path'	=> _reg('base_path') . 'usrs/captcha/',
			'img_url'		=> _reg('base_url') .  'usrs/captcha/'
		);
		
		$cap = create_captcha($vals);
		
		$data = array(
			'captcha_time'	=> $cap['time'],
			'ip_address'		=> $this->input->ip_address(),
			'word'					=> $cap['word']
		);
		
		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);
		
		$event_data = $this->event_model->getEventEvent($event_id);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Agenda . ' . $event_data['title']);
		$this->registry->set_meta('keywords', $event_data['meta_keywords']);
		$this->registry->set_meta('description', $event_data['meta_description']);
		
		$comments_number = $this->event_model->getAgendaOwnComments($event_id, 'APPROVED');

		$comments = $this->event_model->getAgendaOwnCommentsDetail($event_id,'APPROVED');

		//var_dump($comments);exit();

		return array(
			'event'		=> $event_data,
			'captcha'	=> $cap,
			'comments'	=> $comments,
			'comments_number'	=> $comments_number
		);
	}
	
	public function _eventos()
	{
		$params = array(
			'start'			=> 0,
			'limit'			=> 10,
			'from'			=> date('Y-m-d')
		);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Agenda');
		$this->registry->set_meta('keywords', $this->registry->site('event_keywords'));
		$this->registry->set_meta('description', $this->registry->site('event_description'));

		$comments_number = $this->event_model->getAgendaNComments('APPROVED');

		return array(
			'events'				=> $this->event_model->getEventsByDays($params),
			'search_query'	=> false,
			'comments_number'	=> $comments_number
		);
	}
	
	public function _dia($date)
	{
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Agenda . ' . fecha($date));
		$this->registry->set_meta('keywords', $this->registry->site('event_keywords'));
		$this->registry->set_meta('description', $this->registry->site('event_description'));
		
		return array(
			'events'	=> $this->event_model->getEventsFromDate($date),
			'dia'			=> $date
		);
	}
	
	public function _search()
	{
		$this->registry->set('section', 'eventos', 'request');
		$search_query = $this->input->post('searchquery', true);
		
		$params_events = array(
			'start'			=> 0,
			'limit'			=> 10,
			'search_by'	=> ($search_query) ? array('title', 'content') : false,
			'search'		=> array($search_query, $search_query),
			'filter_by'	=> 'type',
			'filter'		=> 'event'
		);
		
		$events = $this->event_model->getEventsByDays($params_events);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Agenda . Resultado para la búsqueda: ' . $search_query);
		$this->registry->set_meta('keywords', $this->registry->site('event_keywords'));
		$this->registry->set_meta('description', $this->registry->site('event_description'));
		
		return array(
			'events'				=> $events,
			'search_query'	=> $search_query
		);
	}

	private function _save_comment()
	{
		$data = array();
		
		$data['comment'] = array(
			'agenda_ID'			=> $this->input->post('agenda_id'),
			'author'					=> $this->input->post('name'),
			'author_email'		=> $this->input->post('email'),
			'author_url'			=> $this->input->post('web'),
			'author_IP'				=> $this->input->ip_address(),
			'date_added'			=> date('Y-m-d H:i:s'),
			'content' 				=> $this->input->post('message'),
			'approved'				=> 1,
			'agent'						=> $this->input->user_agent()
		);
		
		if ($this->registry->user()) {
			$data['comment']['user_ID'] = $this->registry->user('user_ID');
		}
		$agenda = $this->event_model->getEventEvent($data['comment']["agenda_ID"]);
		if ($this->event_model->addAgendaComment($data)) {
			$this->event_model->updateNumberComment($data['comment']["agenda_ID"]);
			$this->session->set_flashdata('message', 'Nuevo comentario guardado correctamente.');
			
			mp_redirect('agenda/'.$agenda["slug"]);
		} else {
			$this->session->set_flashdata('message', 'Error al guardar el nuevo comentario.');
			mp_redirect('agenda/'.$agenda["slug"]);
		}
	}

	//http://www.php.net/manual/en/function.json-encode.php#95667
	public function _calendar()
	{
		$i = 0; // counter prevents infinite loop
		$cutoff = '31'; // limit on timespan (in days)
		$result = array();
		 
		// if date is provided, use it, otherwise default to today
		$start_date = (!empty($start_date)) ? mysql_real_escape_string($start_date) : date('Y-m-d');
		$check_date = $start_date;
		$end_date = date('Y-m-d', strtotime("$start_date +$cutoff days")); // never retrieve more than 2 months
		 
		//$result = "array (";
		$x=0;
		while ($check_date != $end_date)
		{
		    // check if any incomplete todos exist on this date
		   // if (mysql_result(mysql_query("SELECT COUNT(id) FROM " . DB_TODOS . " WHERE date_due = '$check_date'"), 0) == 0)
			if ($this->event_model->getEventEvents())
		    {
		        $result .=  $check_date;
		        $x++;

		    }
		 
		    // +1 day to the check date
		    $check_date = date('Y-m-d', strtotime("$check_date +1 day"));
		 
		    // break from loop if its looking like an infinite loop
		    $i++;
		    if ($i > $cutoff) break;
		}
		//$result .= ")";
		$result = explode(',', $result);
//echo "AQUI";var_dump($result);
	//	header('Content-type: application/json');
	//	header ('Access-Control-Allow-Origin: *');
		//echo "llega"; var_dump($result);
		$arr = array ('freedate-1'=>"2012-06-29 00:00:00",'freedate-2'=>"2012-06-30 00:00:00",'freedate-3'=>"2012-07-01 00:00:00", 'freedate-1'=>"2012-06-28 00:00:00");
//echo "ASI SI!";
		//$this->autoRender = false;
		$this->output
   ->set_content_type('application/json')
   ->set_output(json_encode($arr));
		//return json_encode($arr);
//echo '(' . json_encode($result) . ')';
		//echo "FIN";
		//return '('.json_encode($result).');'; 
    	//print_r($_GET['callback'].$json);
		//return json_encode($result);
	}

}

/* End of file agenda.php */
/* Location: ./application/controllers/agenda.php */