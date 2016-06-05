<?php
/**
 * Save contact updates
 *
 */
class Ajax_ModifuserController extends Zend_Controller_Action {

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
		$client = new Annuaire_Contact((int)$_GET['cid']);
		$societe = new Annuaire_Societe($client->getSocieteId());
		$share = new Annuaire_Share();
		$shared = $share->getSharedByContactId($client->getId());
		$share = new Annuaire_Share($shared[0]['SHARE_ID']);
		if ($share->getId() == 0) {
			$shared = $share->getSharedBySocieteId($societe->getId());
			$share = new Annuaire_Share($shared[0]['SHARE_ID']);
		}
		
		$uid = Annuaire_User::getCurrentUserId();
		switch ($_POST['id']) {
			case "nom":
				$client->setNom($_POST['value']);
				break;
			case "prenom":
				$client->setPrenom($_POST['value']);
				break;
			case "adresse":
				$client->setAdresse($_POST['value']);
				break;
			case "mail":
				$client->setMail($_POST['value']);
				break;
			case "numero":
				$client->setNumero($_POST['value']);
				break;
			case "portable":
				$client->setPortable($_POST['value']);
				break;
			case "commentaire":
				$client->setCommentaire($_POST['value']);
				break;
			case "fax":
				$client->setFax($_POST['value']);
				break;
			case "site":
				$client->setSite($_POST['value']);
				break;
		}

		if ($_POST['id'] == "societe" && $share->getId() == 0) {
			$client->setSocieteId($_POST['societeid']);
		}
		if ($client->getUserId() == $uid || $share->getModify()) {
			$client->commit();
		}
		$returnvalue = (($_POST['value'] == "") ? t_("(none)") : stripslashes($_POST['value']));
		$this->_setAnswer($returnvalue);
	}
}