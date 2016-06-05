<?php
/**
 * Share a company 
 *
 */
class Ajax_AddsocieteshareController extends Zend_Controller_Action {

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
		$contactid = (int) $_POST['id'];
		$uid = Annuaire_User::getCurrentUserId();
		$societe = new Annuaire_Societe($contactid);
		if ($societe->getUserId() == $uid) {
			$user = new Annuaire_User($_POST['value']);
			$shareid = $user->getId();
			$share = new Annuaire_Share();
			if ($shareid > 0) {
				$return = $share->shareSociete($societe->getId(), $shareid);
				$this->_setAnswer($return ? 'ok' : t_("Already Exists"));
			} else {
				$this->_setAnswer($user->create($_POST['value']) ? 'ok' : t_('Mail seems not to be valid'));
			}
		} else {
			$this->_setAnswer('error');
		}
	}
}