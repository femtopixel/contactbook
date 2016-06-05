<?php
/**
 * Save Company updates
 *
 */
class Ajax_ModifsocieteController extends Zend_Controller_Action {

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
		$societe = new Annuaire_Societe((int)$_GET['gid']);
		$share = new Annuaire_Share();
		$shared = $share->getSharedBySocieteId($societe->getId());
		$share = new Annuaire_Share($shared[0]['SHARE_ID']);
		$uid = Annuaire_User::getCurrentUserId();
		switch ($_POST['id']) {
			case "nomsociete":
				$societe->setNom($_POST['value']);
				break;
			case "adressesociete":
				$societe->setAdresse($_POST['value']);
				break;
			case "numerosociete":
				$societe->setNumero($_POST['value']);
				break;
			case "activite":
				$societe->setActivite($_POST['value']);
				break;
			case "faxsociete":
				$societe->setFax($_POST['value']);
				break;
			case "sitesociete":
				$societe->setSite($_POST['value']);
				break;
		}
		if ($societe->getUserId() == $uid || $share->getModify()) {
			$societe->commit();
		}
		$returnvalue = ($_POST['value'] == "") ? t_("(none)") : stripslashes($_POST['value']);
		$this->_setAnswer($returnvalue);
	}
}
