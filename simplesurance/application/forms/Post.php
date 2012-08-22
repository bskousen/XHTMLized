<?php

class Application_Form_Post extends Zend_Form
{

    public function init()
    {
        $this->setName("send_post");
        $this->setMethod('post');

        $this->addElement('textarea', 'message', array(
            'filters'    => array('StringTrim'),
            'required'   => true,
            'label'      => 'Message:',
        ));

        $this->addElement('submit', 'send_post', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Post',
        ));
    }


}

