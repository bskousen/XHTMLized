<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * blog. getBlogArticles
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $params
	 *
	 * @return bool
	 */
	public function getBlogArticles($params = array())
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 20,
			'order_by'	=> 'date_added DESC',
			'search_by'	=> false,
			'search'		=> '',
			'filter_by'	=> false,
			'filter'		=> ''
		);
		
		$params = array_merge($defaults, $params);
		$where = "";
		if ($params['filter_by']) {
			if (is_array($params['filter_by'])) {
				foreach ($params['filter_by'] as $key => $value) {
					$where.= " AND " . $value . " = '" . $params['filter'][$key] . "'";
				}
			} elseif (is_string($params['filter_by'])) {
				$where.= " AND " . $params['filter_by'] . " = '" . $params['filter'] . "'";
			}
		}
		if ($params['search_by']) {
			if (is_array($params['search_by'])) {
				$searh_fields = array();
				foreach ($params['search_by'] as $key => $value) {
					$searh_fields[] = $value . " LIKE '%" . $params['search'][$key] . "%'";
				}
				$where.= " AND (" . implode(" OR ", $searh_fields) . ")";
			} else {
				$where.= " AND " . $params['search_by'] . " LIKE '%" . $params['search'] . "%'";
			}
		}
		
		$sql = "SELECT DISTINCT ba.*, bam.name as photo_name, bam.uri as photo_uri, u.display_name as author_name FROM blog_articles ba
							LEFT JOIN
								(SELECT bt.* FROM blog_attachments bt
									LEFT JOIN blog_article_attachments baa USING (attachment_ID)
								WHERE baa.main = '1') bam
							ON (ba.article_ID = bam.article_ID)
							LEFT JOIN users u ON (ba.author = u.user_ID)
						WHERE ba.site_ID = '" . site_id() . "'$where";
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * blog. getBlogNArticles
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @return int
	 */
	public function getBlogNArticles()
	{
		$sql = "SELECT COUNT(article_ID) as n_articles FROM blog_articles";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$query->free_result();
			return $row->n_articles;
		} else {
			$query->free_result();
			return 0;
		}
	}
	
	public function getBlogArticle($article_id)
	{
		$sql = "SELECT ba.*, baa.attachment_ID, baa.name AS attachment_name, baa.uri AS attachment_uri, baa.mime_type AS attachment_mime_type
						FROM blog_articles ba
							LEFT JOIN
								(SELECT * FROM blog_article_attachments WHERE main = '1') bat USING (article_ID)
							LEFT JOIN blog_attachments baa USING (attachment_ID)
						WHERE ba.article_ID = '$article_id' LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * blog. getForPrint
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $article_id
	 *
	 * @return array|bool
	 */
	public function getForPrint($article_id)
	{
		$item_tmp = $this->getBlogArticle($article_id);
		
		$item = array(
			'title'					=> $item_tmp['title'],
			'content'				=> $item_tmp['content'],
			'image_uri'			=> $item_tmp['attachment_uri'],
			'image_folder'	=> 'usrs/blog/',
			'date_added'		=> $item_tmp['date_added']
		);
		
		return $item;
	}
	
	public function getBlogArticleComments($article_id)
	{
		$sql = "SELECT * FROM blog_comments WHERE article_ID = '$article_id' AND approved = '1'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	public function getBlogArticleCategories($article_id)
	{
		$categories = array();
		$sql = "SELECT category_id FROM blog_article_categories WHERE article_ID = '$article_id'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			foreach ($result as $row) {
				$categories[] = $row['category_id'];
			}
			return $categories;
		} else {
			return array();
		}
	}
	
	public function getBlogArticleAttachments($article_id)
	{
		$attachments = array();
		$sql = "SELECT ba.* FROM blog_attachments ba
							LEFT JOIN blog_article_attachments baa ON (ba.attachment_ID = baa.attachment_ID)
						WHERE baa.article_ID = '$article_id'
						ORDER by mime_type DESC";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	public function addBlogArticle($data = array())
	{
		$data['blog_articles']['site_ID'] = site_id();
		if ($this->db->insert('blog_articles', $data['blog_articles'])) {
			$article_id = $this->db->insert_id();
			// process attachments
			if ($data['blog_article_attachments']) {
				foreach ($data['blog_article_attachments'] as $key => $attachment) {
					$attachment['article_ID'] = $article_id;
					// add attachments
					$this->db->insert('blog_attachments', $attachment);
					$attachment_id = $this->db->insert_id();
					// add attachment of the article
					$this->db->insert(
						'blog_article_attachments',
						array(
							'article_ID' => $article_id,
							'attachment_ID' => $attachment_id,
							'main' => ($data['attachment_main'] == $attachment['filename']) ? 1 : 0
						)
					);
				}
			}
			// add categories of the article
			if ($data['blog_article_categories']) {
				foreach ($data['blog_article_categories'] as $category) {
					$this->db->insert('blog_article_categories', array('article_ID' => $article_id, 'category_ID' => $category));
				}
			}
			return $article_id;
		} else {
			return false;
		}
	}
	
	public function updateBlogArticle($data = array(), $article_id = null)
	{
		$where = array('article_ID' => $article_id);
		// update the article content
		if ($this->db->update('blog_articles', $data['blog_articles'], $where)) {
			// update done ok
			// then whe delete dependencies: attachments, categories
			$this->db->delete('blog_article_attachments', $where);
			$this->db->delete('blog_attachments', $where);
			$this->db->delete('blog_article_categories', $where);
			// process attachments
			if ($data['blog_article_attachments']) {
				foreach ($data['blog_article_attachments'] as $key => $attachment) {
					$attachment['article_ID'] = $article_id;
					// add attachments
					$this->db->insert('blog_attachments', $attachment);
					$attachment_id = $this->db->insert_id();
					// add attachment of the article
					$this->db->insert(
						'blog_article_attachments',
						array(
							'article_ID' => $article_id,
							'attachment_ID' => $attachment_id,
							'main' => ($data['attachment_main'] == $attachment['filename']) ? 1 : 0
						)
					);
				}
			}
			// add categories of the article
			if ($data['blog_article_categories']) {
				foreach ($data['blog_article_categories'] as $category) {
					$this->db->insert('blog_article_categories', array('article_ID' => $article_id, 'category_ID' => $category));
				}
			}
			
			/*
			if(is_array($data['blog_article_files']['ids'])) {
				foreach($data['blog_article_files']['ids'] as $attachment_id) {
					$this->db->delete('blog_attachments', array('attachment_ID' => $attachment_id));
				}
			}
			if(is_array($data['blog_article_files']['files'])) {
				foreach($data['blog_article_files']['files'] as $index => $file_url) {
					$attachment = array(
						'name' => $data['blog_article_files']['names'][$index],
						'uri' => $file_url,
						'mime_type' => $data['blog_article_files']['mime_types'][$index],
						'status' => 'publish',
						'date_added' => date('Y-m-d H:i:s')
					);
					$this->db->insert('blog_attachments', $attachment);
					$attachment_id = $this->db->insert_id();
					$this->db->insert('blog_article_attachments', array('article_ID' => $article_id, 'attachment_ID' => $attachment_id));
				}
			}
			$this->db->delete('blog_article_categories', $where);
			if (is_array($data['blog_article_categories'])) {
				foreach ($data['blog_article_categories'] as $category) {
					$this->db->insert('blog_article_categories', array('article_ID' => $article_id, 'category_ID' => $category));
				}
			}
			*/
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * blog. deleteBlogArticle
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $article_id
	 *
	 * @return bool
	 */
	public function deleteBlogArticle($article_id)
	{
		$where = array('article_ID' => $article_id);
		if ($this->db->delete('blog_articles', $where)
				and $this->db->delete('blog_article_categories', $where)
				and $this->db->delete('blog_comments', $where)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * blog. getBlogCategories
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $params
	 * @param int $category_id
	 *
	 * @return bool
	 */
	public function getBlogCategories($params = array(), $category_id = 0) // $start = 0, $limit = 20)
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 100,
			'order_by'	=> 'name ASC',
			'search_by'	=> false,
			'search'		=> '',
			'filter_by'	=> false,
			'filter'		=> ''
		);
		
		$params = array_merge($defaults, $params);
		$where = "";
		if ($params['filter_by']) {
			if (is_array($params['filter_by'])) {
				foreach ($params['filter_by'] as $key => $value) {
					$where.= " AND " . $value . " = '" . $params['filter'][$key] . "'";
				}
			} elseif (is_string($params['filter_by'])) {
				$where.= " AND " . $params['filter_by'] . " = '" . $params['filter'] . "'";
			}
		}
		if ($params['search_by']) {
			if (is_array($params['search_by'])) {
				$searh_fields = array();
				foreach ($params['search_by'] as $key => $value) {
					$searh_fields[] = $value . " LIKE '%" . $params['search'][$key] . "%'";
				}
				$where.= " AND (" . implode(" OR ", $searh_fields) . ")";
			} else {
				$where.= " AND " . $params['search_by'] . " LIKE '%" . $params['search'] . "%'";
			}
		}
		
		$sql = "SELECT * FROM blog_categories
						WHERE parent = '$category_id'$where";
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$categories = array();
			foreach ($query->result_array() as $category) {
				$category_id = $category['category_ID'];
				$categories[$category_id] = $category;
				$categories[$category_id]['childs'] = $this->getBlogCategories($params, $category_id);
			}
			return $categories;
		} else {
			return false;
		}
		
		// -----------------------------------
		if ($query->num_rows() > 0) {
			echo "<p>hello world</p>";
			$categories = array();
			foreach ($query->result_array() as $category) {
				$category_id = $category['category_ID'];
				$categories[$category_id] = $category;
				$categories[$category_id]['childs'] = $this->getBlogCategories($params, $categories['category_ID']);
			}
			//$categories = $this->getBlogCategories($params, $categories['category_ID']);
			return $categories;
		} else {
			return false;
		}
	}
	
	/**
	 * blog. getBlogNCategories
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @return int
	 */
	public function getBlogNCategories()
	{
		$sql = "SELECT COUNT(category_ID) as n_categories FROM blog_categories";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$query->free_result();
			return $row->n_categories;
		} else {
			$query->free_result();
			return 0;
		}
	}
	
	public function getBlogCategory($category_id)
	{
		$sql = "SELECT * FROM blog_categories WHERE category_ID = '$category_id' LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	public function getBlogCategoryArticles($category_id, $limit = 20)
	{
		/*
		$sql = "SELECT ba.* FROM blog_articles ba
							LEFT JOIN blog_article_categories bac ON (ba.article_ID =  bac.article_ID)
						WHERE bac.category_ID = '$category_id'";
		*/
		$sql = "SELECT ba.*, baa.name as photo_name, baa.uri as photo_uri FROM blog_articles ba
							LEFT JOIN blog_article_categories bac ON (ba.article_ID = bac.article_ID)
							LEFT JOIN blog_attachments baa ON (ba.article_ID = baa.article_ID)
						WHERE bac.category_ID = '$category_id' ORDER BY date_added DESC LIMIT $limit";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}	
	}
	
	public function addBlogCategory($data = array())
	{
		if ($this->db->insert('blog_categories', $data['blog_category'])) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function updateBlogCategory($data = array(), $category_id = null)
	{
		$where = array('category_ID' => $category_id);
		if ($this->db->update('blog_categories', $data['blog_category'], $where)) {
			//$this->db->delete('blog_article_categories', $where);
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * blog. deleteBlogCategory
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $category_id
	 *
	 * @return bool
	 */
	public function deleteBlogCategory($category_id)
	{
		$where = array('category_ID' => $category_id);
		if ($this->db->delete('blog_categories', $where)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * blog. addBlogComments
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function addBlogComment($data)
	{
		$article_id = $data['comment']['article_ID'];
		if ($this->db->insert('blog_comments', $data['comment'])) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * blog. getBlogComments
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $type values: ALL | APPROVED | NOTAPPROVED
	 * @param int $start
	 * @param int $limit
	 *
	 * @return array
	 */
	public function getBlogComments($type = 'ALL', $start = 0, $limit = 20)
	{
		if ($type == 'APPROVED') {
			$sql = "SELECT bc.*, ba.`title` as article_title FROM blog_comments bc
								LEFT JOIN blog_articles ba ON (bc.`article_ID` = ba.`article_ID`)
							WHERE bc.approved = '1'
							LIMIT $start, $limit;";
		} elseif ($type == 'NOTAPPROVED') {
			$sql = "SELECT bc.*, ba.`title` as article_title FROM blog_comments bc
								LEFT JOIN blog_articles ba ON (bc.`article_ID` = ba.`article_ID`)
							WHERE bc.approved = '0'
							LIMIT $start, $limit;";
		} else {
			$sql = "SELECT bc.*, ba.`title` as article_title FROM blog_comments bc
								LEFT JOIN blog_articles ba ON (bc.`article_ID` = ba.`article_ID`)
							LIMIT $start, $limit;";
		}
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * blog. getComments
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $article_id
	 *
	 * @return array
	 */
	public function getComments($article_id)
	{
		/*
		$comments_tmp = $this->getBlogArticle($article_id);
		
		$item = array(
			'title'					=> $comments_tmp['title'],
			'content'				=> $item_tmp['content'],
			'image_uri'			=> $item_tmp['attachment_uri'],
			'image_folder'	=> 'usrs/blog/',
			'date_added'		=> $item_tmp['date_added']
		);
		
		return $comments_tmp;
		*/
		return $this->getBlogArticleComments($article_id);
	}
	
	/**
	 * blog. getBlogNCategories
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $type values: ALL | APPROVED | NOTAPPROVED
	 *
	 * @return int
	 */
	public function getBlogNComments($type = 'ALL')
	{
		if ($type == 'APPROVED') {
			$sql = "SELECT COUNT(comment_ID) as n_comments FROM blog_comments WHERE approved = '1';";
		} elseif ($type == 'NOTAPPROVED') {
			$sql = "SELECT COUNT(comment_ID) as n_comments FROM blog_comments WHERE approved = '0';";
		} else {
			$sql = "SELECT COUNT(comment_ID) as n_comments FROM blog_comments;";
		}
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$query->free_result();
			return $row->n_comments;
		} else {
			$query->free_result();
			return 0;
		}
	}
	
	/**
	 * blog. approveBlogComment
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $comment_id
	 * @param int $status values: 0 (desaprove) | 1 (approve)
	 *
	 * @return bool
	 */
	public function approveBlogComment($comment_id, $article_id, $status = '1')
	{
		if ($comment_id != 0 and $article_id != 0) {
			$where = array('comment_ID' => $comment_id);
			if ($this->db->update('blog_comments', array('approved' => $status), $where)) {
				//echo $this->db->last_query();
				if ($status == 1) {
					$query = $this->db->query("UPDATE blog_articles SET comment_count = comment_count + 1 WHERE article_ID = $article_id");
				} elseif ($status == 0) {
					$query = $this->db->query("UPDATE blog_articles SET comment_count = comment_count - 1 WHERE article_ID = $article_id");
				}
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * blog. deleteBlogComment
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $comment_id
	 *
	 * @return bool
	 */
	public function deleteBlogComment($comment_id)
	{
		$where = array('comment_ID' => $comment_id);
		if ($this->db->delete('blog_comments', $where)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * blog. slugFor
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $slug
	 *
	 * @return string
	 */
	public function slugFor($slug)
	{
		$sql_article = "SELECT * FROM blog_articles WHERE slug = '$slug' LIMIT 1";
		$query_article = $this->db->query($sql_article);
		$sql_category = "SELECT * FROM blog_categories WHERE slug = '$slug' LIMIT 1";
		$query_category = $this->db->query($sql_category);
		if ($query_article->num_rows() > 0) {
			$result = $query_article->row_array();
			return array('section' => 'article', 'id' => $result['article_ID']);
		} elseif ($query_category->num_rows() > 0) {
			$result = $query_category->row_array();
			return array('section' => 'category', 'id' => $result['category_ID']);
		} else {
			return false;
		}
	}

}

/* End of file blog_model.php */
/* Location: ./application/models/blog_model.php */