<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Admin_Controller
{

	public function _index_index($params = array())
	{
		$this->load->model('blog_model');
		
		// search
		$search = $this->input->post('search', true);
		$this->registry->set('search', $search, 'request');
		
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'article/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->blog_model->getBlogNArticles(),
			'per_page'		=> $per_page
		);
		
		$this->pagination->initialize($config_pagination); 
		
		$params = array(
			'start'			=> $pagination_start,
			'limit'			=> $per_page,
			'search_by'	=> ($search) ? 'name' : false,
			'search'		=> $search
		);
		
		return array(
			'articles'		=> $this->blog_model->getBlogArticles($params),
			'pagination'	=> $this->pagination->create_links()
		);
	}
	
	public function _article_index($params = array())
	{
		$this->load->model('blog_model');
		
		// search
		$search = $this->input->post('search', true);
		$this->registry->set('search', $search, 'request');
		
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'article/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->blog_model->getBlogNArticles(),
			'per_page'		=> $per_page
		);
		
		$this->pagination->initialize($config_pagination); 
		
		$params = array(
			'start'			=> $pagination_start,
			'limit'			=> $per_page,
			'search_by'	=> ($search) ? 'name' : false,
			'search'		=> $search
		);
		
		return array(
			'articles'		=> $this->blog_model->getBlogArticles($params),
			'pagination'	=> $this->pagination->create_links()
		);
	}
	
	public function _article_edit($params = array())
	{
		$this->load->model('blog_model');
		$article_id = (isset($params[1])) ? $params[1] : 0;
		$data = array();
		
		$data['form_action'] = 'article/save';
		$data['categories'] = $this->blog_model->getBlogCategories();
		
		$data['article'] = $this->blog_model->getBlogArticle($article_id);
		$data['article_categories'] = $this->blog_model->getBlogArticleCategories($article_id);
		$data['article_attachments'] = $this->blog_model->getBlogArticleAttachments($article_id);
		
		return $data;
	}
	
	public function _article_save($params = array())
	{
		$data = array();
		$article_id = $this->input->post('articleid');
		$this->load->model('blog_model');
		
		$data['blog_articles'] = array(
			'title'						=> $this->input->post('title'),
			'slug'						=> $this->input->post('slug'),
			'excerpt'					=> $this->input->post('excerpt'),
			'content'					=> $this->input->post('content'),
			'meta_keywords'		=> $this->input->post('meta_keywords'),
			'meta_description'	=> $this->input->post('meta_description'),
			'author'					=> $this->getUserLogged('user_ID'),
			'date_modified' 	=> date('Y-m-d H:i:s'),
			'status'					=> $this->input->post('status'),
			'comment_status'	=> $this->input->post('commentstatus'),
			'type'						=> 'article'
		);
		$data['attachment_main'] = $this->input->post('attachment_main');
		$data['blog_article_categories'] = $this->input->post('categories');
		
		if ($this->input->post('attachments_id')) {
			$tmp_attachments = array(
				'id' => $this->input->post('attachments_id'),
				'filename' => $this->input->post('attachments_filename'),
				'mime_type' => $this->input->post('attachments_type'),
				'ext' => $this->input->post('attachments_ext')
			);
			
			foreach ($tmp_attachments['id'] as $key => $attachment) {
				$data['blog_article_attachments'][] = array(
					'attachment_ID'	=> $attachment,
					'name'					=> '',
					'uri'						=> $tmp_attachments['filename'][$key] . '.' . $tmp_attachments['ext'][$key],
					'filename'			=> $tmp_attachments['filename'][$key],
					'ext'						=> $tmp_attachments['ext'][$key],
					'mime_type'			=> $tmp_attachments['mime_type'][$key],
					'status'				=> 'publicado',
					'date_added'		=> date('Y-m-d H:i:s')
				);
			}
		} else {
			$data['blog_article_attachments'] = false;
		}
		
		if ($article_id) {
			if ($this->blog_model->updateBlogArticle($data, $article_id)) {
				$this->registry->set_message(array(
					'class'		=> 'success',
					'content'	=> 'Artículo guardado correctamente.'
				));
			} else {
				$this->registry->set_message(array(
					'class'		=> 'error',
					'content'	=> 'Error al guardar el artículo.'
				));
			}
		} else {
			$data['blog_articles']['date_added'] = date('Y-m-d H:i:s');
			if ($article_id = $this->blog_model->addBlogArticle($data)) {
				$this->registry->set_message(array(
					'class'		=> 'success',
					'content'	=> 'Nuevo artículo guardado correctamente.'
				));
			} else {
				$this->registry->set_message(array(
					'class'		=> 'error',
					'content'	=> 'Error al guardar el nuevo artículo.'
				));
			}
		}
		$this->registry->set('action','edit', 'request');
		
		return array(
			'form_action'					=> 'article/save',
			'categories'					=> $this->blog_model->getBlogCategories(),
			'article'							=> $this->blog_model->getBlogArticle($article_id),
			'article_categories'	=> $this->blog_model->getBlogArticleCategories($article_id),
			'article_attachments'	=> $this->blog_model->getBlogArticleAttachments($article_id)
		);
	}
	
	public function _article_delete($params = array())
	{
		$this->load->model('blog_model');
		$article_id = (isset($params[1])) ? $params[1] : 0;
		
		if ($this->blog_model->deleteBlogArticle($article_id)) {
			$this->session->set_flashdata('message', 'Artículo borrado correctamente.');
		} else {
			$this->session->set_flashdata('message', 'Error al borrar el artículo.');
		}
		
		mp_redirect('admin/blog/article');
	}
	
	public function _category_index($params = array())
	{
		$this->load->model('blog_model');
		
		// search
		$search = $this->input->post('search', true);
		$this->registry->set('search', $search, 'request');
		
		// pagination
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 100;
		
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'category/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->blog_model->getBlogNCategories(),
			'per_page'		=> $per_page
		);
		
		$this->pagination->initialize($config_pagination);
		
		$params = array(
			'start'			=> $pagination_start,
			'limit'			=> $per_page,
			'search_by'	=> ($search) ? 'name' : false,
			'search'		=> $search
		);
		
		return array(
			'categories'	=> $this->blog_model->getBlogCategories($params),
			'pagination'	=> $this->pagination->create_links()
		);
	}
	
	public function _category_edit($params = array())
	{
		$this->load->model('blog_model');
		$category_id = (isset($params[1])) ? $params[1] : 0;
		
		return array(
			'form_action'	=> 'category/save',
			'categories'	=> $this->blog_model->getBlogCategories(),
			'category'		=> $this->blog_model->getBlogCategory($category_id)
		);
	}
	
	public function _category_save($params = array())
	{
		$data = array();
		$category_id = $this->input->post('categoryid');
		$this->load->model('blog_model');
		
		$data['blog_category'] = array(
			'name'						=> $this->input->post('name'),
			'slug'						=> $this->input->post('slug'),
			'parent'					=> $this->input->post('parent'),
			'meta_keywords'		=> $this->input->post('meta_keywords'),
			'meta_description'	=> $this->input->post('meta_description')
		);
		
		if ($category_id) {
			if ($this->blog_model->updateBlogCategory($data, $category_id)) {
				$this->registry->set_message(array(
					'class'		=> 'success',
					'content'	=> 'Categoría guardada correctamente.'
				));
			} else {
				$this->registry->set_message(array(
					'class'		=> 'error',
					'content'	=> 'Error al guardar la categoría.'
				));
			}
		} else {
			if ($category_id = $this->blog_model->addBlogCategory($data)) {
				$this->registry->set_message(array(
					'class'		=> 'success',
					'content'	=> 'Nueva categoría guardada correctamente.'
				));
			} else {
				$this->registry->set_message(array(
					'class'		=> 'error',
					'content'	=> 'Error al crear la nueva categoría..'
				));
			}
		}
		$this->registry->set('action','edit', 'request');
		
		return array(
			'form_action'	=> 'category/save',
			'categories'	=> $this->blog_model->getBlogCategories(),
			'category'		=> $this->blog_model->getBlogCategory($category_id)
		);
	}
	
	public function _category_delete($params = array())
	{
		$this->load->model('blog_model');
		$category_id = (isset($params[1])) ? $params[1] : 0;
		
		if ($this->blog_model->deleteBlogCategory($category_id)) {
			$this->session->set_flashdata('message', 'Categoría borrada correctamente.');
		} else {
			$this->session->set_flashdata('message', 'Error al borrar la categoría.');
		}
		
		mp_redirect('admin/blog/category');
	}
	
	public function _comment_index($params = array())
	{
		$this->load->model('blog_model');
		$data = array();
		
		$pagination = (isset($params[1]) and $params[1] == 'page') ? true : false;
		
		$pagination_start = (isset($params[2])) ? $params[2] : 0;
		$per_page = 10;
		
		// pagination for all comments
		$config_pagination = array(
			'base_url'		=> _reg('module_url') . 'comment/index/page/',
			'uri_segment'	=> 6,
			'total_rows'	=> $this->blog_model->getBlogNComments(),
			'per_page'		=> $per_page
		);
		$this->pagination->initialize($config_pagination);
		
		return array(
			'notapproved'		=> $this->blog_model->getBlogComments('NOTAPPROVED'),
			'all_comments'	=> $this->blog_model->getBlogComments('ALL', $pagination_start, $per_page),
			'pagination'		=> $this->pagination->create_links()
		);
	}
	
	public function _comment_desapprove($params = array())
	{
		$this->load->model('blog_model');
		$comment_id = (isset($params[1])) ? $params[1] : 0;
		$article_id = (isset($params[2])) ? $params[2] : 0;
		$data = array();
		
		if ($this->blog_model->approveBlogComment($comment_id, $article_id, '0')) {
			$this->session->set_flashdata('message', 'Comentario desaprobado correctamente.');
		} else {
			$this->session->set_flashdata('message', 'Error al desaprobar el comentario.');
		}
		
		mp_redirect('admin/blog/comment');
	}
	
	public function _comment_approve($params = array())
	{
		$this->load->model('blog_model');
		$comment_id = (isset($params[1])) ? $params[1] : 0;
		$article_id = (isset($params[2])) ? $params[2] : 0;
		$data = array();
		
		if ($this->blog_model->approveBlogComment($comment_id, $article_id, '1')) {
			$this->session->set_flashdata('message', 'Comentario aprobado correctamente.');
		} else {
			$this->session->set_flashdata('message', 'Error al aprobar el comentario.');
		}
		
		mp_redirect('admin/blog/comment');
	}

}

/* End of file blog.php */
/* Location: ./application/controllers/admin/blog.php */