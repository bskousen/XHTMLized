<?php

class Event_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * events. getEventEvents
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function getEventEvents($params = array())
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 20,
			'order_by'	=> 'event_start DESC',
			'search_by'	=> false,
			'search'		=> '',
			'filter_by'	=> false,
			'filter'		=> '',
			'from'			=> false
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
		if ($params['from']) {
			$where.= " AND event_start > '" . $params['from'] . "'";
		}
		/*
		$sql = "SELECT DISTINCT ba.*, bam.name as photo_name, bam.uri as photo_uri, u.display_name as author_name FROM blog_articles ba
							LEFT JOIN
								(SELECT bt.* FROM blog_attachments bt
									LEFT JOIN blog_article_attachments baa USING (attachment_ID)
								WHERE baa.main = '1') bam
							ON (ba.article_ID = bam.article_ID)
							LEFT JOIN users u ON (ba.author = u.user_ID)
						WHERE site_ID = '" . site_id() . "'$where";
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		$query = $this->db->query($sql);
		*/
		$sql = "SELECT * FROM events
						WHERE site_ID = '" . site_id() . "'$where";
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
		
		/*
		if ($search) {
			$search_where = " WHERE title LIKE '%$search%' ";
		} else {
			$search_where = " ";
		}
		
		$sql = "SELECT * FROM events
						WHERE site_ID = '" . site_id() . "'$where";
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		$query = $this->db->query($sql);
		//				ORDER BY event_start DESC LIMIT $start, $limit;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
		*/
	}
	
	/**
	 * events. getEventsByDays
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function getEventsByDays($params = array())
	{
		$defaults = array(
			'start'			=> 0,
			'limit'			=> 20,
			'order_by'	=> 'event_start DESC',
			'search_by'	=> false,
			'search'		=> '',
			'filter_by'	=> false,
			'filter'		=> '',
			'from'			=> false
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
		if ($params['from']) {
			$where.= " AND event_start > '" . $params['from'] . "'";
		}
		
		$sql = "SELECT * FROM events
						WHERE site_ID = '" . site_id() . "'$where";
		$sql.= ($params['order_by']) ? " ORDER BY " . $params['order_by'] : "";
		$sql.= " LIMIT " . $params['start'] . ", " . $params['limit'] . ";";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$db_events = $query->result_array();
			$events_per_day = array();
			foreach ($db_events as $event) {
				$date_id = fecha($event['event_start'], 'yyyymmdd');
				$event_id = $event['event_ID'];
				$events_per_day[$date_id][$event_id] = $event;
				$events_per_day[$date_id][$event_id]['eventdate'] = array(
					'day' => fecha($event['event_start'], 'day'),
					'month' => fecha($event['event_start'], 'month'),
					'year' => fecha($event['event_start'], 'year'),
					'monthname' => fecha($event['event_start'], 'monthname')
				);
			}
			return $events_per_day;
		} else {
			return false;
		}
	}
	
	/**
	 * events. getEventsFromDate
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $date
	 *
	 * @return int
	 */
	public function getEventsFromDate($date)
	{
		$res =array();
		$return = 0;
		$sql = "SELECT * FROM events
						WHERE event_start = '$date%'
						ORDER BY event_start DESC;";
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$res = $query->result_array();
		} else {
			$return = 1;
		}
//echo "PRIMERA<br>";
//var_dump($res);
		$sql = "SELECT * FROM events
						ORDER BY event_start DESC;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$data = $query->result_array();
		//	echo "SEGUNDA<br>";
//var_dump($data);
			$x=1000;
			foreach ($data as $event) {

				

			

				if($event['event_start'] != $event['event_finish']) {
					
				$start_timestamp = strtotime($event['event_start']);
				$finish_timestamp = strtotime($event['event_finish']);
				$clicked_timestamp = strtotime($date);
					/*echo "START".$start_timestamp.'<br />';
					echo "START-DT".$event['event_start'].'<br />';
					echo "END".$finish_timestamp.'<br />';
					echo "END-DT".$event['event_finish'].'<br />';
					echo "NOW".$clicked_timestamp.'<br />';*/
					if($clicked_timestamp > $start_timestamp AND $clicked_timestamp < $finish_timestamp) {
					//	echo "DENTRO";
						$res[$x]['slug'] = $event["slug"];
						$res[$x]['title'] = $event["title"];
						$res[$x]['content'] = $event["content"];
						$x++;
					} //else echo "KK";
				}
				//exit();
			}
			//echo "DATA";var_dump($res);
		} else {
			return false;
		}
		
			return $res;
		}

		/**
	 * events. getEventsFromDate
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $date
	 *
	 * @return int
	 */
	public function events_calendar()
	{
		$sql = "SELECT event_start,event_finish FROM events
						ORDER BY event_start DESC;";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	
	/**
	 * events. getEventNEvents
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @return int
	 */
	public function getEventNEvents()
	{
		$sql = "SELECT COUNT(event_ID) as n_events FROM events";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$query->free_result();
			return $row->n_events;
		} else {
			$query->free_result();
			return 0;
		}
	}
	
	/**
	 * events. getEventEvent
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param int $event_id
	 *
	 * @return mixed
	 */
	public function getEventEvent($event_id)
	{
		$sql = "SELECT * FROM events WHERE event_ID = '$event_id' LIMIT 1";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	/**
	 * events. getForPrint
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $event_id
	 *
	 * @return array|bool
	 */
	public function getForPrint($event_id)
	{
		$item_tmp = $this->getEventEvent($event_id);
		
		$item = array(
			'title'					=> $item_tmp['title'],
			'content'				=> $item_tmp['content'],
			'image_uri'			=> $item_tmp['image'],
			'image_folder'	=> 'usrs/events/',
			'date_added'		=> $item_tmp['event_start']
		);
		
		return $item;
	}
	
	/**
	 * events. addEventEvent
	 *
	 * @access public
	 * @since 0.9
	 *
	 * @param array $data
	 * @param int $event_id = null
	 *
	 * @return bool
	 */
	public function saveEventEvent($data = array(), $event_id = null)
	{
		if ($event_id) {
			// update event
			$where = array('event_ID' => $event_id);
			unset($data['date_added']);
			if ($this->db->update('events', $data['events'], $where)) {
				return $event_id;
			} else {
				return false;
			}
		} else {
			// or create event
			$data['events']['site_ID'] = site_id();
			if ($this->db->insert('events', $data['events'])) {
				return $this->db->insert_id();
			} else {
				return false;
			}
		}
	}
	
	/**
	 * events. deleteEventEvent
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $event_id
	 *
	 * @return bool
	 */
	public function deleteEventEvent($event_id)
	{
		$where = array('event_ID' => $event_id);
		if ($this->db->delete('events', $where)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * events. slugFor
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $slug
	 *
	 * @return int
	 */
	public function slugFor($slug)
	{
		$sql = "SELECT event_ID FROM events WHERE slug = '$slug' LIMIT 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['event_ID'];
		} else {
			return false;
		}
	}
	
	/**
	 * events. getComments
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

		/**
	 * events. addAgendaComments
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function addAgendaComment($data)
	{
		$event_id = $data['comment']['agenda_ID'];
		if ($this->db->insert('event_comments', $data['comment'])) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * events. getAgendaComments
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
	public function getAgendaComments($type = 'ALL', $start = 0, $limit = 20)
	{
		if ($type == 'APPROVED') {
			$sql = "SELECT ec.*, e.`title` as agenda_title FROM event_comments ec
								LEFT JOIN events e ON (ec.`agenda_ID` = e.`event_ID`)
							WHERE ec.approved = '1'
							LIMIT $start, $limit;";
		} elseif ($type == 'NOTAPPROVED') {
			$sql = "SELECT ec.*, e.`title` as agenda_title FROM event_comments ec
								LEFT JOIN events e ON (ec.`agenda_ID` = e.`event_ID`)
							WHERE ec.approved = '0'
							LIMIT $start, $limit;";
		} else {
			$sql = "SELECT ec.*, e.`title` as agenda_title FROM event_comments ec
								LEFT JOIN events e ON (ec.`agenda_ID` = e.`event_ID`)
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
	 * events. getAgendaComments
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
	public function getAgendaOwnCommentsDetail($agenda_id = null, $type = 'ALL', $start = 0, $limit = 20)
	{
		if ($type == 'APPROVED') {
			$sql = "SELECT ec.*, e.`title` as agenda_title FROM event_comments ec
								LEFT JOIN events e ON (ec.`agenda_ID` = e.`event_ID`)
							WHERE ec.approved = '1' AND ec.`agenda_ID` = '$agenda_id'
							LIMIT $start, $limit;";
		} elseif ($type == 'NOTAPPROVED') {
			$sql = "SELECT ec.*, e.`title` as agenda_title FROM event_comments ec
								LEFT JOIN events e ON (ec.`agenda_ID` = e.`event_ID`)
							WHERE ec.approved = '0'
							LIMIT $start, $limit;";
		} else {
			$sql = "SELECT ec.*, e.`title` as agenda_title FROM event_comments ec
								LEFT JOIN events e ON (ec.`agenda_ID` = e.`event_ID`)
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
	 * events. getAgendaNCategories
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $type values: ALL | APPROVED | NOTAPPROVED
	 *
	 * @return int
	 */
	public function getAgendaNComments($type = 'ALL')
	{
		if ($type == 'APPROVED') {
			$sql = "SELECT COUNT(comment_ID) as n_comments FROM event_comments WHERE approved = '1';";
		} elseif ($type == 'NOTAPPROVED') {
			$sql = "SELECT COUNT(comment_ID) as n_comments FROM event_comments WHERE approved = '0';";
		} else {
			$sql = "SELECT COUNT(comment_ID) as n_comments FROM event_comments;";
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
	 * events. getAgendaNCategories
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param string $type values: ALL | APPROVED | NOTAPPROVED
	 *
	 * @return int
	 */
	public function getAgendaOwnComments($agenda_id = null, $type = 'ALL')
	{
		if ($type == 'APPROVED') {
			$sql = "SELECT COUNT(comment_ID) as n_comments FROM event_comments WHERE approved = '1' AND agenda_ID ='$agenda_id';";
		} elseif ($type == 'NOTAPPROVED') {
			$sql = "SELECT COUNT(comment_ID) as n_comments FROM event_comments WHERE approved = '0' AND agenda_ID ='$agenda_id';";
		} else {
			$sql = "SELECT COUNT(comment_ID) as n_comments FROM event_comments WHERE  agenda_ID ='$agenda_id';";
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
	 * events. approveAgendaComment
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $comment_id
	 * @param int $status values: 0 (desaprove) | 1 (approve)
	 *
	 * @return bool
	 */
	public function approveAgendaComment($comment_id, $agenda_id, $status = '1')
	{
		if ($comment_id != 0 and $agenda_id != 0) {
			$where = array('comment_ID' => $comment_id);
			if ($this->db->update('event_comments', array('approved' => $status), $where)) {
				//echo $this->db->last_query();
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * events. deleteAgendaComment
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @param int $comment_id
	 *
	 * @return bool
	 */
	public function deleteAgendaComment($comment_id)
	{
		$where = array('comment_ID' => $comment_id[1]);
		if ($this->db->delete('event_comments', $where)) {
			return true;
		} else {
			return false;
		}
	}

	public function updateNumberComment($event_id = null)
	{
		 if($this->db->query("UPDATE events SET comment_number = comment_number + 1 WHERE event_ID = $event_id")) {
			return true;
		} 
			return false;
	}


}

/* End of file event_model.php */
/* Location: ./application/models/event_model.php */