<?php

class Application_Model_DbTable_Posts extends Zend_Db_Table_Abstract
{

    protected $_name = 'posts';
    
    public function getPost($id)
    {
	    $id = (int)$id;
	    $row = $this->fetchRow("id = $id");
	    if (!$row) {
		    throw new Exception ("Could not find row $id");
	    }
	    return $row->toArray();
    }
    
    public function getPosts($n_posts = 15)
    {
	    $select = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                		->setIntegrityCheck(false);
        $select->where('parent_id = 0')
        	   ->join('users', 'users.id = posts.author', array('name', 'surname'))
        	   ->order('date_added DESC')->limit($n_posts);
	    
	    return $this->fetchAll($select);
    }
    
    public function getComments($post_id)
    {
	    $select = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                		->setIntegrityCheck(false);
        $select->where('parent_id = ?', $post_id)
        	   ->join('users', 'users.id = posts.author', array('name', 'surname'))
        	   ->order('date_added DESC');
	    
	    return $this->fetchAll($select);
    }
    
    public function addPost($message, $parent = 0)
    {
	    $auth = Zend_Auth::getInstance();
        $author = $auth->getIdentity()->id;
        
	    $data = array(
	    	'author'		=> $author,
	    	'message'		=> $message,
	    	'parent_id'		=> (int)$parent,
	    	'date_added'	=> date('Y-m-d H:i:s')
	    );
	    $this->insert($data);
	    
	    if ($parent !== 0) {
		    $data = array('comments_count' => new Zend_Db_Expr('comments_count + 1'));
		    $this->update($data, 'id = ' . (int)$parent);
	    }
	    
    }


}

