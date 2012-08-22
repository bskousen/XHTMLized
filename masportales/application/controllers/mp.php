<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mp extends Front_Controller {

	public function _remap($method, $arguments = array())
	{
		global $class;
		
		$this->load->model('mp_model');
		
		$this->registry->set('module', $class, 'request');
		//$this->settings['module_url']	= _reg('site_url') . $class . '/';
		
		if ($method == 'index' and !$arguments) {
			mp_redirect();
		} elseif ($legal_text_id = $this->mp_model->slugFor($method)) {
			$this->registry->set('section', 'legal_text', 'request');
			$this->registry->set('arguments', $legal_text_id, 'request');
		} elseif ($method == 'sitemap' or $method == 'contacto') {
			$this->registry->set('section', $method, 'request');
			$this->registry->set('arguments', $arguments, 'request');
		} else {
			show_404();
		}
		
		$function = '_' . $this->registry->request('section');
		if (method_exists($this, $function)) {
			$this->settings['data'] = $this->$function($this->registry->request('arguments'));
		} else {
			show_404();
		}
		$this->columns(); // TODO
		$this->load->view('themes/default/layout', $this->settings);
	}
	
	public function _legal_text($legal_text_id)
	{
		$legal_text = $this->mp_model->getLegalText($legal_text_id);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . ' . $legal_text['title']);
		$this->registry->set_meta('keywords', $legal_text['meta_keywords']);
		$this->registry->set_meta('description', $legal_text['meta_description']);
		return array(
			'legal_text'	=> $legal_text
		);
	}
	
	public function _sitemap()
	{
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Mapa de la Web');
		$this->registry->set_meta('keywords', $this->registry->site('sitemap_keywords'));
		$this->registry->set_meta('description', $this->registry->site('sitemap_description'));
		return $this->mp_model->getSitemap();
	}
	
	public function _contacto()
	{
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Contacto');
		$this->registry->set_meta('keywords', $this->registry->site('contact_keywords'));
		$this->registry->set_meta('description', $this->registry->site('contact_description'));
	}

}

/* End of file mp.php */
/* Location: ./application/controllers/mp.php */