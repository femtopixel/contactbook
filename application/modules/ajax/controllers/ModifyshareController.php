<?php
/**
 * Update a share 
 *
 */
class Ajax_ModifshareController extends Zend_Controller_Action {
	protected function _setAnswer($message) {
		$response = $this->getResponse();
		$response->clearBody();
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		$response->setBody($message);
	}
	/**
	 * Default action called by AjaxController
	 *
	 * Match the posted ID to the right action to do
	 */
	public function indexAction() {
		$this->getHelper('viewRenderer')->setNoRender(true);
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife(0);
		$id = (int) $_POST['id'];
		$share = new Annuaire_Share($id);
		$share->switchModify();
		$share->commit();
		$this->_setAnswer('ok');
	}
}
?>