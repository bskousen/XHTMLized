<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        if	(!$auth->hasIdentity()) {
        	$this->_helper->redirector('index', 'auth');
	        //echo "No user logged.";
        }
        /* Initialize action controller here */
        /*
        echo "hello world!";
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $username = $auth->getIdentity()->name . ' ' . $auth->getIdentity()->surname;
            $logoutUrl = $this->view->url(array('controller'=>'auth', 'action'=>'logout'), null, true);
            return 'Welcome ' . $username .  '. <a href="'.$logoutUrl.'">Logout</a>';
        } 

        $request = Zend_Controller_Front::getInstance()->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        if($controller == 'auth' && $action == 'index') {
            return '';
        }
        $loginUrl = $this->view->url(array('controller'=>'auth', 'action'=>'index'));
        return '<a href="'.$loginUrl.'">Login</a>';
        */
    }

    public function indexAction()
    {
        $posts = new Application_Model_DbTable_Posts();
        $post_form = new Application_Form_Post();
        $request = $this->getRequest();
        if ($request->isPost()) {
	        $formData = $request->getPost();
	        if ($post_form->isValid($formData)) {
	        	$message = $post_form->getValue('message');
	        	$posts->addPost($message);
	        	$this->_helper->redirector('index');
	        } else {
		    	$post_form->populate($formData);
	        }
        }
        $this->view->post_form = $post_form;
        $this->view->title = ': Timeline';
        $this->view->posts = $posts->getPosts(15);
    }

    public function commentAction()
    {
        $comments = new Application_Model_DbTable_Posts();
        $comment_form = new Application_Form_Post();
        $request = $this->getRequest();
        $post_id = $this->_getParam('id');
        
        if ($request->isPost()) {
	        $formData = $request->getPost();
	        if ($comment_form->isValid($formData)) {
		        $message = $comment_form->getValue('message');
		        
		        $comments->addPost($message, $post_id);
		        $this->_helper->redirector('index');
	        } else {
		        $comment_form->populate($formData);
	        }
        }
        $this->view->comment_form = $comment_form;
        $this->view->title = ': Comments';
        $this->view->comments = $comments->getComments($post_id);
    }


}



