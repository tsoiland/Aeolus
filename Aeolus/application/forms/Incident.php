<?php

class Application_Form_Incident extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
       	$this->addElement('text', 'title', array('label' => 'Title'));
       	$this->addElement('textarea', 'description', array('label' => 'Description'));
       	$this->addElement('hidden', 'longitude');
       	$this->addElement('hidden', 'latitude');
       	$this->addElement('submit', 'login', array('label' => 'Report'));
    }
}

