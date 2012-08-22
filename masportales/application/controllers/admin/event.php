<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends Admin_Controller
{

	public function _index_index($params = array())
	{
		$this->load->model('event_model');
		
		// search
		$search = $this->input->post('search', true);
		$this->registry->set('search', $search, 'request');
		
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'event/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->event_model->getEventNEvents(),
			'per_page'		=> $per_page
		);
		
		$this->pagination->initialize($config_pagination);
		
		$params = array(
			'start'			=> $pagination_start,
			'limit'			=> $per_page,
			'search_by'	=> ($search) ? 'title' : false,
			'search'		=> $search
		);
		
		return array(
			'events'	=> $this->event_model->getEventEvents($params),
			'pagination'	=> $this->pagination->create_links()
		);
	}
	
	public function _index_edit($params = array())
	{
		$this->load->model('event_model');
		$event_id = (isset($params[1])) ? $params[1] : 0;
		
		return array(
			'form_action'	=> 'event/save',
			'event'				=> $this->event_model->getEventEvent($event_id)
		);
	}
	
	public function _index_save($params = array())
	{
		$data = array();
		$event_id = $this->input->post('eid');
		$this->load->model('event_model');
		if ($this->input->post('have_comment') == "true") 
			$has_comment = 1;
		else 
			$has_comment = 0;

		$data['events'] = array(
			'title'							=> $this->input->post('title'),
			'slug'							=> $this->input->post('slug'),
			'content'						=> $this->input->post('content'),
			'meta_keywords'			=> $this->input->post('meta_keywords'),
			'meta_description'	=> $this->input->post('meta_description'),
			'author'						=> $this->getUserLogged('user_ID'),
			'event_start'				=> $this->input->post('event_start'),
			'event_finish'			=> $this->input->post('event_finish'),
			'image'							=> $this->input->post('image'),
			'image_mime_type'		=> $this->input->post('image_mime_type'),
			'date_added'				=> date('Y-m-d H:i:s'),
			'date_modified' 		=> date('Y-m-d H:i:s'),
			'type'							=> 'event',
			'have_comment'					=> $has_comment
		);
		
		if ($event_id = $this->event_model->saveEventEvent($data, $event_id)) {
			$this->registry->set_message(array(
				'class'		=> 'success',
			  'content'	=> 'Evento guardado correctamente.'
			));
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al guardar el evento.'
			));
		}
		$this->registry->set('action','edit', 'request');
		
		return array(
			'form_action'	=> 'event/save',
			'event'				=> $this->event_model->getEventEvent($event_id)
		);
	}
	
	public function _index_delete($params = array())
	{
		$this->load->model('event_model');
		$event_id = (isset($params[1])) ? $params[1] : 0;
		
		if ($this->event_model->deleteEventEvent($event_id)) {
			$this->registry->set_message(array(
				'class'		=> 'success',
			  'content'	=> 'Evento creado con éxito.'
			));
		} else {
			$this->registry->set_message(array(
				'class'		=> 'error',
			  'content'	=> 'Error al borrar el evento.'
			));
		}
		$this->registry->set('action','index', 'request');
		
		return $this->_index_index($params);
	}

	public function _comment_index($params = array())
	{
		$this->load->model('event_model');
		$data = array();
		
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		// pagination for all comments
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'event/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->event_model->getAgendaNComments(),
			'per_page'		=> $per_page
		);
		$this->pagination->initialize($config_pagination);
		
		return array(
			'notapproved'		=> $this->event_model->getAgendaComments('NOTAPPROVED'),
			'all_comments'	=> $this->event_model->getAgendaComments('ALL', $pagination_start, $per_page),
			'pagination'		=> $this->pagination->create_links()
		);
	}

	public function _comment_desapprove($params = array())
	{
		$this->load->model('event_model');
		$comment_id = (isset($params[1])) ? $params[1] : 0;
		$event_id = (isset($params[2])) ? $params[2] : 0;
		$data = array();
		
		if ($this->event_model->approveAgendaComment($comment_id, $event_id, '0')) {
			$this->session->set_flashdata('message', 'Comentario desaprobado correctamente.');
		} else {
			$this->session->set_flashdata('message', 'Error al desaprobar el comentario.');
		}
		
		mp_redirect('admin/event/comment');
	}
	
	public function _comment_approve($params = array())
	{
		$this->load->model('event_model');
		$comment_id = (isset($params[1])) ? $params[1] : 0;
		$event_id = (isset($params[2])) ? $params[2] : 0;
		$data = array();
		
		if ($this->event_model->approveAgendaComment($comment_id, $event_id, '1')) {
			$this->session->set_flashdata('message', 'Comentario aprobado correctamente.');
		} else {
			$this->session->set_flashdata('message', 'Error al aprobar el comentario.');
		}
		
		mp_redirect('admin/event/comment');
	}

	public function _comment_delete($comment_id = null)
	{	
		$this->load->model('event_model');
		if ($this->event_model->deleteAgendaComment($comment_id)) {
			$this->session->set_flashdata('message', 'Comentario borrado correctamente.');
		} else {
			$this->session->set_flashdata('message', 'Error al borrar el comentario.');
		}

		mp_redirect('admin/event/comment');
	}
}

/* End of file event.php */
/* Location: ./application/controllers/admin/event.php */