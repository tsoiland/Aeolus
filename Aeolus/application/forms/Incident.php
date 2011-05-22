<?php

class Application_Form_Incident extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
       	$this->addElement('text', 'title', array('label' => 'Title'));
       	$this->addElement('textarea', 'description', array('label' => 'Public Description'));
       	$this->addElement('textarea', 'sensitive_description', array('label' => 'Sensitive Description'));
       	$this->addElement('hidden', 'longitude');
       	$this->addElement('hidden', 'latitude');
       	$this->addElement('select', 'status', array(
            'required'   => true,
            'label'      => 'Status:',
	        'multiOptions' => array(
		        '0' => 'Open',
		        '1' => 'Closed'
		    )
        ));
       	$this->addElement('submit', 'login', array('label' => 'Report'));
    }
}

