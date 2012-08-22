<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $form = new Application_Form_Login();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                if ($this->_process($form->getValues())) {
                    // We're authenticated! Redirect to the home page
                    $this->_helper->redirector('index', 'index');
                }
            } else {
            	
            }
        }
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index'); // back to login page
    }
    
    public function registerAction()
    {
        $users = new Application_Model_DbTable_Users();
        $register_form = new Application_Form_Registration();
        $request = $this->getRequest();
        if ($request->isPost()) {
	        $formData = $request->getPost();
	        if ($register_form->isValid($formData)) {
		        $salt = sha1(uniqid(rand(), TRUE));
		        $data = array(
		        	'name'		=> $register_form->getValue('name'),
		        	'surname'	=> $register_form->getValue('surname'),
		        	'email'		=> $register_form->getValue('email'),
		        	'password'	=> sha1($register_form->getValue('password') . $salt),
		        	'salt'		=> $salt,
		        	'ip'		=> $this->getRequest()->getServer('REMOTE_ADDR'),
		        	'date_added'	=> date('Y-m-d H:i:s')
		        );
		        $users->addUser($data);
		        $this->view->registrationResult = true;
	        } else {
		        $this->view->registrationResult = false;
		        $register_form->populate($formData);
	        }
        }
        $this->view->register_form = $register_form;
        $this->view->title = ': Registration';
    }

    protected function _process($values)
    {
	    // Get our authentication adapter and check credentials
	    $adapter = $this->_getAuthAdapter();
	    $adapter->setIdentity($values['username']); 
	    $adapter->setCredential($values['password']);
	    
	    $auth = Zend_Auth::getInstance();
	    $result = $auth->authenticate($adapter);
	    if ($result->isValid()) {
	    	$user = $adapter->getResultRowObject();
	    	$auth->getStorage()->write($user);
	    	return true;
	    }
	    return false;
    }

    protected function _getAuthAdapter()
    {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('users')
                    ->setIdentityColumn('email')
                    ->setCredentialColumn('password')
                    ->setCredentialTreatment('SHA1(CONCAT(?,salt))');

        return $authAdapter;
    }

}