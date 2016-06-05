<?php 
/**
 * Default Controller
 *
 * displays the interface
 */
class IndexController extends Zend_Controller_Action {

	/**
	 * Controller Initialization
	 *
	 * must be connected to use it
	 */
	public function init() {
		Annuaire_User::mustBeConnected();
		$this->view->setLayout("default");
		$this->view->addLayoutVar("onglet", 1);
	}

	/**
	 * Interface if connected
	 *
	 */
	public function indexAction() {
		$this->view->setLayout('default');
		$this->view->search = (t_("Search"));
		$this->view->launchSearch =  (t_("Find !"));
	}
}