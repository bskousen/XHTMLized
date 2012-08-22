<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends Front_Controller {

	public function index()
	{
		$this->registry->set('module', 'search', 'request');
		$this->registry->set('section', 'search', 'request');
		
		$search_query = $this->input->post('searchquery', true);
		
		$this->load->model('blog_model');
		$this->load->model('event_model');
		$this->load->model('ecommerce_model');
		$this->load->model('companies_model');
		$this->load->model('basicads_model');
		
		$params_articles = array(
			'start'			=> 0,
			'limit'			=> 5,
			'search_by'	=> ($search_query) ? array('title', 'content') : false,
			'search'		=> array($search_query, $search_query),
			'filter_by'	=> array('type', 'ba.status'),
			'filter'		=> array('article', 'publish')
		);
		$params_events = array(
			'start'			=> 0,
			'limit'			=> 5,
			'search_by'	=> ($search_query) ? array('title', 'content') : false,
			'search'		=> array($search_query, $search_query),
			'filter_by'	=> 'type',
			'filter'		=> 'event'
		);
		$params_products = array(
			'start'			=> 0,
			'limit'			=> 5,
			'search_by'	=> ($search_query) ? array('pd.name', 'pd.description') : false,
			'search'		=> array($search_query, $search_query),
			'filter_by'	=> 'p.status',
			'filter'		=> '1'
		);
		$params_companies = array(
			'start'			=> 0,
			'limit'			=> 5,
			'search_by'	=> ($search_query) ? array('name', 'description') : false,
			'search'		=> array($search_query, $search_query),
			'filter_by'	=> 'status',
			'filter'		=> 'publicado'
		);
		$params_basicads = array(
			'start'			=> 0,
			'limit'			=> 5,
			'search_by'	=> ($search_query) ? array('title', 'content') : false,
			'search'		=> array($search_query, $search_query),
			'filter_by'	=> 'b.status',
			'filter'		=> 'publicado'
		);
		
		$data = array(
			's_query'		=> $search_query,
			'articles'	=> $this->blog_model->getBlogArticles($params_articles),
			'events'		=> $this->event_model->getEventsByDays($params_events),
			'products'	=> $this->ecommerce_model->getProducts($params_products),
			'companies'	=> $this->companies_model->getCompanies($params_companies),
			'basicads'	=> $this->basicads_model->getBasicAds($params_basicads)
		);
		
		
		$this->columns(); // TODO
		
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Resultados de la búsqueda: ' . $search_query);
		$this->registry->set_meta('keywords', $this->registry->site('search_keywords'));
		$this->registry->set_meta('description', $this->registry->site('search_description'));
		
		$this->load->view('themes/default/layout', $data);
	}

}

/* End of file search.php */
/* Location: ./application/controllers/search.php */