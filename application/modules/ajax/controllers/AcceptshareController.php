<?php
/**
 * Accept or decline a share
 *
 */
class Ajax_AcceptshareController extends Zend_Controller_Action {
	
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
		$share = new Annuaire_Share((int) $_POST['id']);
		$uid = Annuaire_User::getCurrentUserId();
		if ($share->getId() != 0 && $share->getUserId() == $uid) {
			switch ($_POST['action']) {
				case 'accept' :
					$share->accept();
					$share->commit();
					break;
				case 'decline' :
					$share->delete();
					break;
			}
			$this->_setAnswer('ok');
		} else {		
			$this->_setAnswer('error');
		}
	}
}
