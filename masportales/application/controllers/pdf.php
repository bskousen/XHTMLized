<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pdf extends Front_Controller {

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
		
		$html = utf8_decode($this->load->view('themes/default/print', $data, true));
		
		$this->load->helper(array('mp_pdf', 'file'));
		
		$filename = date('YmdHis') . '_' . $this->registry->site('name') . '-masportales';
		
		pdf_create($html, $filename);
	}

}

/* End of file pdf.php */
/* Location: ./application/controllers/pdf.php */


