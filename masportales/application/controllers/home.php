<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Front_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function index()
	{
		$this->registry->set('module', 'home', 'request');
		$this->registry->set('section', 'index', 'request');
		
		// meta data for SEO
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Inicio');
		$this->registry->set_meta('keywords', $this->registry->site('meta_keywords'));
		$this->registry->set_meta('description', $this->registry->site('meta_description'));
		
		// Blog
		$this->load->model('blog_model');
		// get blog articles and categories
		$params = array(
			'start'			=> 0,
			'limit'			=> 5
		);
		$this->settings['blog']['categories'] = $this->blog_model->getBlogCategories();
		$this->settings['blog']['articles']		= $this->blog_model->getBlogArticles($params);
		
		// Events
		$this->load->model('event_model');
		// get events in this site
		$params = array(
			'start'			=> 0,
			'limit'			=> 10,
			'from'			=> date('Y-m-d'),
			'order_by'	=> 'event_start ASC'
		);
		$this->settings['events'] = $this->event_model->getEventsByDays($params);
		
		$this->columns(); // TODO
		$this->load->view('themes/default/layout', $this->settings);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */