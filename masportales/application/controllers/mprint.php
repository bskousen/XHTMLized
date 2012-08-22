<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mprint extends Front_Controller {

	public function index()
	{
		global $class;
		
		
		$this->load->view('themes/default/print');
	}
	
	public function _remap($method, $arguments = array())
	{
		global $class;
		
		if ($method == 'index') show_404();
		$model = $method . '_model';
		$item_id = ($arguments[0]) ? $arguments[0] : 0;
		
		$this->load->model($model);
		
		$data = array(
			'item'			=> $this->$model->getForPrint($item_id),
			'comments'	=> $this->$model->getComments($item_id),
			'module'		=> $method
		);
		
		$this->registry->set_meta('title', $this->registry->site('name') . '+portales - ' . $data['item']['title']);
		
		$this->load->view('themes/default/print', $data);
	}

}

/* End of file mprint.php */
/* Location: ./application/controllers/mprint.php */