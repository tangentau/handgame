<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
		$alphabet = new Application_Model_AlphabetMapper();
        $this->view->entries = $alphabet->fetchAll();
    }


}

