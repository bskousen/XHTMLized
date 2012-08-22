<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->setName('login');
        $this->setMethod('post');
        
        $this->addElement('text', 'username', array(
        	'filters'		=> array('StringTrim', 'StringToLower'),
        	'validators'	=> array(
        		array('EmailAddress')
        	),
        	'required'		=> true,
        	'label'			=> 'Email:'
        ));
        
        $this->addElement('password', 'password', array(
        	'filter'		=> array('StringTrim'),
        	'validators'	=> array(
        		array('StringLength', false, array(0, 32))
        	),
        	'required'		=> true,
        	'label'			=> 'Password:'
        ));
        
        $this->addElement('submit', 'login', array(
        	'required'		=> false,
        	'ignore'		=> true,
        	'label'			=> 'Login'
        ));
    }

}