<?php
/**
 * Delete a share 
 *
 */
class Ajax_DeleteshareController extends Zend_Controller_Action {

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
		$method = $_POST['method'];
		$share = new Annuaire_Share((int)$_POST['id']);
		$share->delete();
		$this->_setAnswer('ok');
	}
}