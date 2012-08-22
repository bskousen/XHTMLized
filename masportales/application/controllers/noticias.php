<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noticias extends Front_Controller {

	public function _remap($method, $arguments = array())
	{
		global $class;
		
		$this->load->model('blog_model');
		$this->load->model('companies_model');
		
		$this->registry->set('module', $class, 'request');
		//$this->settings['module_url']	= _reg('site_url') . $class . '/';
		
		if ($method == 'index' and !$arguments) {
			$this->registry->set('section', 'articles', 'request');
			$this->registry->set('arguments', false, 'request');
		} elseif ($slug_data = $this->blog_model->slugFor($method)) {
			$this->registry->set('section', $slug_data['section'], 'request');
			$this->registry->set('arguments', $slug_data['id'], 'request');
		} elseif (method_exists($this, '_' . $method) and is_callable(array($this, '_' . $method))) {
			$this->registry->set('section', $method, 'request');
			$this->registry->set('item_id', ($arguments) ? $arguments[0] : null, 'request');
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
	
	public function _articles()
	{
		$categories = $this->blog_model->getBlogCategories();
		
		$params = array(
			'start'			=> 0,
			'limit'			=> 10
		);
		
		$categories_name = array();
		foreach ($categories as $category) {
			$categories_name[] = $category['name'];
		}
		
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Noticias');
		$this->registry->set_meta('keywords', implode(', ', $categories_name));
		$this->registry->set_meta('description', $this->registry->site('blog_description'));
		$this->registry->set_column('blog_categories', $categories);
		
		return array(
			'articles'			=> $this->blog_model->getBlogArticles($params),
			'categories'		=> $categories,
			'search_query'	=> false
		);
	}
	
	public function _search()
	{
		$categories = $this->blog_model->getBlogCategories();
		$search_query = $this->input->post('searchquery', true);
		
		$params_articles = array(
			'start'			=> 0,
			'limit'			=> 10,
			'search_by'	=> ($search_query) ? array('title', 'content') : false,
			'search'		=> array($search_query, $search_query),
			'filter_by'	=> array('type', 'ba.status'),
			'filter'		=> array('article', 'publish')
		);
		
		$categories_name = array();
		foreach ($categories as $category) {
			$categories_name[] = $category['name'];
		}
		
		$articles	= $this->blog_model->getBlogArticles($params_articles);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Noticias . Resultado para la búsqueda: ' . $search_query);
		$this->registry->set_meta('keywords', implode(', ', $categories_name));
		$this->registry->set_meta('description', $this->registry->site('blog_description'));
		$this->registry->set_column('blog_categories', $categories);
		$this->registry->set('section', 'articles', 'request');
		
		return array(
			'articles'			=> $articles,
			'categories'		=> $categories,
			'search_query'	=> $search_query
		);
	}
	
	public function _category($id)
	{	
		$this->registry->set_column('blog_categories', $this->blog_model->getBlogCategories());
		
		$category_data = $this->blog_model->getBlogCategory($id);
		$this->registry->set_meta('keywords', $category_data['meta_keywords']);
		$this->registry->set_meta('description', $category_data['meta_description']);
		
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Noticias . Categorías . ' . $category_data['name']);
		//$this->registry->set_column('empresas', $this->companies_model->getCompanies());
		return array(
			'category'		=> $category_data,
			'articles'		=> $this->blog_model->getBlogCategoryArticles($id),
			'categories'	=> $this->blog_model->getBlogCategories()
		);
	}
	
	public function _article($id)
	{
		$this->load->library('form_validation');
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
		
		if (isset($_POST['aid'])) {
			if (check_captcha()) {
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
		}
		
		$this->registry->set_column('blog_attachments', $this->blog_model->getBlogArticleAttachments($id));
		$this->registry->set_column('blog_categories', $this->blog_model->getBlogCategories());
		//$this->registry->set_column('empresas', $this->companies_model->getCompanies());
		$article_data = $this->blog_model->getBlogArticle($id);
		$this->registry->set_meta('title', $this->registry->site_name() . ' . Noticias . ' . $article_data['title']);
		$this->registry->set_meta('keywords', $article_data['meta_keywords']);
		$this->registry->set_meta('description', $article_data['meta_description']);
		$this->registry->set_meta('open_graph', true);
		$this->registry->set_meta('og_title', $article_data['title']);
		$this->registry->set_meta('og_type', 'website');
		$this->registry->set_meta('og_url', $this->registry->site_url() . 'noticias/' . $article_data['slug']);
		$this->registry->set_meta('og_image', get_image_url($article_data['attachment_uri'], '210x210', _reg('site_url') . 'usrs/blog/'));
		$this->registry->set_meta('og_site_name', $this->registry->site_name());
		
		return array(
			'article'							=> $article_data,
			'article_attachments'	=> $this->blog_model->getBlogArticleAttachments($id),
			'comments'						=> $this->blog_model->getBlogArticleComments($id),
			'captcha'							=> $cap
		);
	}
	
	private function _save_comment()
	{
		$data = array();
		
		$data['comment'] = array(
			'article_ID'			=> $this->input->post('aid'),
			'author'					=> $this->input->post('name'),
			'author_email'		=> $this->input->post('email'),
			'author_url'			=> $this->input->post('web'),
			'author_IP'				=> $this->input->ip_address(),
			'date_added'			=> date('Y-m-d H:i:s'),
			'content' 				=> $this->input->post('message'),
			'approved'				=> 0,
			'agent'						=> $this->input->user_agent()
		);
		
		if ($this->registry->user()) {
			$data['comment']['user_ID'] = $this->registry->user('user_ID');
		}
		
		if ($this->blog_model->addBlogComment($data)) {
			//$this->session->set_flashdata('message', 'Nuevo artículo guardado correctamente.');
			//mp_redirect('admin/blog/');
		} else {
			//$this->session->set_flashdata('message', 'Error al guardar el nuevo artículo.');
			//mp_redirect('admin/blog/article/edit');
		}
	}
	/*
	private function _columns()
	{
		$columns = array('blog_categories', 'products')
	}
	*/

}

/* End of file noticias.php */
/* Location: ./application/controllers/noticias.php */