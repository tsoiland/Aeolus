<?php

class Application_Form_User extends Zend_Form
{

    public function init()
    {
        $this->setName("user");
        $this->setMethod('post');
             
        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => 'Username:',
        ));
        $this->addElement('text', 'password', array(
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => false,
            'label'      => 'Password:',
        ));
        $this->addElement('text', 'realname', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => 'Real Name:',
        ));
        $this->addElement('text', 'phone_nr', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 10)),
                
            ),
            'required'   => true,
            'label'      => 'Phone nr:',
        ));
        $this->addElement('text', 'location', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => 'Location:',
        ));
        $this->addElement('select', 'role', array(
            'required'   => true,
            'label'      => 'role:',
	        'multiOptions' => array(
		        'guest' => 'Anonymous User',
		        'admin' => 'Administrator',
		        'field_personnel' => 'Field Personnel'
		    )
        ));
        $this->addElement('submit', 'user', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Save',
        )); 
    }


}

