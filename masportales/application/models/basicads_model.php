<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Basicads_model extends CI_Model
{

	/**
	 * basicads
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param
	 *
	 * @return
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * basicads. getBasicAds
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	public function getBasicAds($params = array())
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
		
		$sql = "SELECT b.*, bi.uri, u.display_name as user_name, u.email as user_email FROM basicads b
						LEFT JOIN
							(SELECT uri, basicad_ID FROM basicads_images WHERE main = '1') bi USING (basicad_ID)
						LEFT JOIN users u USING (user_ID)
						WHERE b.site_ID = '" . site_id() . "'$where";
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
	 * basicads. getNBasicAds
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @return int
	 */
	public function getNBasicAds($search = null)
	{
		if ($search) {
			$search_where = "AND title LIKE '%$search%' ";
		} else {
			$search_where = "";
		}
		$sql = "SELECT COUNT(basicad_ID) as n_basicads FROM basicads WHERE site_ID = '" . site_id() .  "' $search_where;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$query->free_result();
			return $row->n_basicads;
		} else {
			$query->free_result();
			return 0;
		}
	}
	
	/**
	 * basicads. getBasicAd
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $basicad_id
	 *
	 * @return bool|array
	 */
	public function getBasicAd($basicad_id, $user_id = null)
	{
		$and_basicad = '';
		if ($user_id !== null) {
			$and_basicad = "AND b.user_ID = '$user_id'";
		}
		
		$sql = "SELECT b.*, bi.uri as main_image FROM basicads b
							LEFT JOIN basicads_images bi USING (basicad_ID)
						WHERE b.basicad_ID = '$basicad_id' $and_basicad
						LIMIT 1;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * basicads. getForPrint
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $basicad_id
	 *
	 * @return array|bool
	 */
	public function getForPrint($basicad_id)
	{
		$item_tmp = $this->getBasicAd($basicad_id);
		
		$item = array(
			'title'					=> $item_tmp['title'],
			'content'				=> $item_tmp['content'],
			'image_uri'			=> $item_tmp['main_image'],
			'image_folder'	=> 'usrs/clasificados/',
			'date_added'		=> $item_tmp['date_added']
		);
		
		return $item;
	}
	
	/**
	 * basicads. getBasicAdImages
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $basicad_id
	 *
	 * @return bool|array
	 */
	public function getBasicAdImages($basicad_id)
	{
		$sql = "SELECT * FROM basicads_images WHERE basicad_ID = '$basicad_id';";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * basicads. getUserBasicAds
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $user_id
	 * @param int $limit
	 *
	 * @return array
	 */
	public function getUserBasicAds($user_id, $limit = 20)
	{
		$sql = "SELECT b.*, bi.uri, bc.n_contacts FROM basicads b
						LEFT JOIN
							(SELECT uri, basicad_ID FROM basicads_images WHERE main = '1') bi USING (basicad_ID)
						LEFT JOIN
							(SELECT basicad_ID, COUNT(basicad_contact_ID) AS n_contacts FROM basicads_contacts WHERE parent = '0' GROUP BY basicad_ID) bc USING (basicad_ID)
						WHERE user_ID = '$user_id'
						ORDER BY date_added DESC LIMIT $limit;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * basicads. addBasicAd
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function saveBasicAd($data, $basicad_id = false)
	{
		//echo "pasa"; exit();
		if ($basicad_id) {
			// update basicad
			$where = array('basicad_ID' => $basicad_id);
			unset($data['basicad']['user_ID']);
			if ($this->db->update('basicads', $data['basicad'], $where)) {
				$this->db->delete('basicads_images', $where);
			} else {
				$basicad_id = false;
			}
		} else {
			// or create basicad
			$data['basicad']['site_ID'] = site_id();
			$data['basicad']['date_added'] = date('Y-m-d H:i:s');
			$data['basicad']['date_activation'] = date('Y-m-d H:i:s');
			$data['basicad']['status'] = $this->registry->site('default_basicads_status');
			if ($this->db->insert('basicads', $data['basicad'])) {
				$basicad_id = $this->db->insert_id();
			} else {
				$basicad_id = false;
			}
		}
		if ($data['basicad_images'] and $basicad_id) {
			foreach ($data['basicad_images'] as $image) {
		  	$image['basicad_ID'] = $basicad_id;
		  	$this->db->insert('basicads_images', $image);
		  }
		}
		return $basicad_id;
	}
	
	/**
	 * basicads. deleteBasicAd
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $basicad_id
	 *
	 * @return bool
	 */
	public function deleteBasicAd($basicad_id)
	{
		$where = array('basicad_ID' => $basicad_id);
		if ($this->db->delete('basicads', $where)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * basicads. deleteBasicAdContact
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $basicad_id
	 *
	 * @return bool
	 */
	public function deleteBasicAdContact($basicad_id)
	{
		$where = array('basicad_ID' => $basicad_id);
		if ($this->db->delete('basicads_contacts', $where)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * basicads. deleteBasicAdContact
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $basicad_id
	 *
	 * @return bool
	 */
	public function deleteBasicAdImages($basicad_id)
	{
		$where = array('basicad_ID' => $basicad_id);
		if ($this->db->delete('basicads_images', $where)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * basicads. sendEmail
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function sendEmail($basicad)
	{
		//echo "AQUI";var_dump($basicad);
		$this->load->model('users_model');
		$basicad_owner = $this->users_model->getUser($basicad['user_ID']);
		
		$receipt_info = array(
				'author'				=> $basicad_owner['display_name'],
				'author_email'	=> $basicad_owner['email']
		);

		$data = array(
			'site_url'				=> $this->registry->site_url(),
			'site_name'				=> $this->registry->site('name'),
			'logo'						=> $this->registry->site('logo'),
			'recipient_name'	=> $receipt_info['author'],
		//	'sender_name'			=> $sender_info['author'],
			'basicad_title'		=> $basicad['title'],
			'basicad_ID'		=> $basicad['basicad_ID'],
			//'sender_name'			=> $sender_info['author'],
			//'message'					=> $message
		);

		$this->load->library('parser');
		
		$html_email = $this->parser->parse('themes/default/email/basicad_send.tpl', $data, TRUE);
		
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);
		
		$this->email->from('no-reply@' . $this->registry->core('base_domain'), $this->registry->site('name') . '+portales');
		//$this->email->to($basicad['user_email']);
		$this->email->to("freelance@aitoribanez.com");
		
		$this->email->subject('Anuncio ' . $data['basicad_title'] . ' apunto de expirar - ' . $this->registry->site('name') . '+Portales');
		$this->email->message($html_email);
		
		$this->email->send();
	}

	
	/**
	 * basicads. getBasicAdsCategories
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $start
	 * @param int $limit
	 *
	 * @return bool
	 */
	public function getBasicAdsCategories($start = 0, $limit = 20)
	{
		$sql = "SELECT * FROM basicads_categories ORDER BY name ASC LIMIT $start, $limit";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * basicads. slugFor
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
		$sql = "SELECT basicad_ID FROM basicads WHERE slug = '$slug' LIMIT 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['basicad_ID'];
		} else {
			return false;
		}
	}
	
	/**
	 * basicads. saveBasicAdContact
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function saveBasicAdContact($data)
	{
		$basicad_id = $data['basicads_contacts']['basicad_ID'];
		if ($this->db->insert('basicads_contacts', $data['basicads_contacts'])) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * basicads. getBasicAdsContacts
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $type values: ALL | NUEVOS | LEIDOS | RESPONDIDOS
	 * @param int $start
	 * @param int $limit
	 *
	 * @return array
	 */
	public function getBasicAdsContacts($basicad_id = null)
	{
		/*
		if ($type == 'NUEVOS') {
			$sql = "SELECT bc.*, ba.`title` as article_title FROM blog_comments bc
								LEFT JOIN blog_articles ba ON (bc.`article_ID` = ba.`article_ID`)
							WHERE bc.approved = '1'
							LIMIT $start, $limit;";
		} elseif ($type == 'LEIDOS') {
			$sql = "SELECT bc.*, ba.`title` as article_title FROM blog_comments bc
								LEFT JOIN blog_articles ba ON (bc.`article_ID` = ba.`article_ID`)
							WHERE bc.approved = '0'
							LIMIT $start, $limit;";
		} else {
			$sql = "SELECT bc.*, ba.`title` as article_title FROM blog_comments bc
								LEFT JOIN blog_articles ba ON (bc.`article_ID` = ba.`article_ID`)
							LIMIT $start, $limit;";
		}
		*/
		
		$sql = "SELECT * FROM basicads_contacts WHERE basicad_ID = '$basicad_id' AND parent = '0';";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * basicads. getBasicAdsContacts
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $basicad_contact_id
	 *
	 * @return array
	 */
	public function getBasicAdsContactAnswers($basicad_contact_id)
	{
		$sql = "SELECT * FROM basicads_contacts WHERE parent = '$basicad_contact_id' AND status = 'respuesta';";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * basicads. getBasicAdsContact
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $basicad_contact_id
	 *
	 * @return array
	 */
	public function getBasicAdsContact($basicad_contact_id)
	{
		$sql = "SELECT * FROM basicads_contacts WHERE basicad_contact_ID = '$basicad_contact_id' LIMIT 1;";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * basicads. sendOrderEmail
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $basicad_contact
	 * @param array $basicad_answer
	 *
	 * @return bool
	 */
	public function sendBasicAdContactEmail($sender_info, $receipt_info, $message, $basicad_id) // $basicad_contact, $basicad_answer = null)
	{
		$this->load->library('parser');
		
		$basicad = $this->getBasicAd($basicad_id);
		
		if (!$receipt_info) {
			$basicad_owner = $this->users_model->getUser($basicad['user_ID']);
			$receipt_info = array(
				'author'				=> $basicad_owner['display_name'],
				'author_email'	=> $basicad_owner['email']
			);
		}
		
		$data = array(
			'title'						=> 'Respuesta de solicitud de información sobre anuncio clasificado',
			'site_url'				=> $this->registry->site_url(),
			'site_name'				=> $this->registry->site('name'),
			'logo'						=> $this->registry->site('logo'),
			'recipient_name'	=> $receipt_info['author'],
			'sender_name'			=> $sender_info['author'],
			'basicad_title'		=> $basicad['title'],
			'message'					=> $message
		);
		
		$html_email = $this->parser->parse('themes/default/email/basicad_contact.tpl', $data, TRUE);
		
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);
		
		$sender_email = 'no-reply@';
		$sender_email.= ($this->registry->site('domain')) ? $this->registry->site('domain') : $this->registry->core('base_domain');
		
		$this->email->from($sender_email, $this->registry->site('name') . '+portales');
		$this->email->reply_to($sender_info['author_email'], $sender_info['author']);
		$this->email->to($receipt_info['author_email']);
		
		$this->email->subject('Mensaje anuncio clasificado: ' . $basicad['title'] . ' - ' . $this->registry->site('name') . '+Portales');
		$this->email->message($html_email);
		
		return $this->email->send();
	}
	
	/**
	 * basicads. getComments
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $basicad_id
	 *
	 * @return array
	 */
	public function getComments($basicad_id)
	{
		return false;
	}

}

/* End of file basicads_model.php */
/* Location: ./application/models/basicads_model.php */