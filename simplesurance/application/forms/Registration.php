<?php

class Application_Form_Registration extends Zend_Form
{

    public function init()
    {
        $this->setName('registration');
        $this->setMethod('post');
        
        $this->addElement('text', 'name', array(
        	'filters'		=> array('StringTrim'),
        	'validators'	=> array(
        		array('StringLength', true, array(0, 32))
        	),
        	'required'		=> true,
        	'label'			=> 'Name:'
        ));
        
        $this->addElement('text', 'surname', array(
        	'filters'		=> array('StringTrim'),
        	'validators'	=> array(
        		array('StringLength', true, array(0, 32))
        	),
        	'required'		=> true,
        	'label'			=> 'Surname:'
        ));
        
        $this->addElement('text', 'email', array(
        	'filters'		=> array('StringTrim', 'StringToLower'),
        	'validators'	=> array(
        		array('EmailAddress'),
        		new Zend_Validate_Db_NoRecordExists('users', 'email')
        	),
        	'required'		=> true,
        	'label'			=> 'Email:'
        ));
        
        $this->addElement('password', 'password', array(
        	'filters'		=> array('StringTrim'),
        	'validators'	=> array(
        		array('StringLength', true, array(0, 32))
        	),
        	'required'		=> true,
        	'label'			=> 'Password:'
        ));
        
        $this->addElement('password', 'password2', array(
        	'filters'		=> array('StringTrim'),
        	'validators'	=> array(
        		array('StringLength', true, array(0, 32)),
        		array('Identical', false, array('token' => 'password'))
        	),
        	'required'		=> true,
        	'label'			=> 'Repeat password:'
        ));
        
        $this->addElement('submit', 'login', array(
        	'required'		=> false,
        	'ignore'		=> true,
        	'label'			=> 'Register'
        ));
    }


}
