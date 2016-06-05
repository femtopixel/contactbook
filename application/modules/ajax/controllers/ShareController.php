<?php
/**
 * Share interface
 *
 */
class Ajax_ShareController extends Zend_Controller_Action {

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
		$this->getHelper('viewRenderer')->setNoRender(false);
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife(0);
		$share = new Annuaire_Share();
		$shared = $share->getMyShare(false);
		$contact = new Annuaire_Contact($shared[0]['CONTACT_ID']);
		$societe = new Annuaire_Societe($shared[0]['SOCIETE_ID']);
		$temp = new Annuaire_User(($contact->getUserId() == 0) ? $societe->getUserId() : $contact->getUserId());
		
		$this->view->mail = $temp->getMail();
		$this->view->sharedby = t_('Shared by');
		$this->view->company = t_('Company');
		$this->view->contact = t_('Contact');
		$this->view->name = (($contact->getNom() == "") ? t_('(none)') : $contact->getNom());
		$this->view->firstname = (($contact->getPrenom() == "") ? t_('(none)') : $contact->getPrenom());
		$this->view->companyname = (($societe->getNom() == "") ? t_('(none)') : $societe->getNom());
		$this->view->id = $shared[0]['SHARE_ID'];
		$this->view->accept = t_('Accept');
		$this->view->refuse = t_('Decline');
		$this->view->closeBox = t_('Close the box');
		$this->view->iscontact = (($contact->getId()) ? 1 : 0);
		$this->view->ajax = (isset($_GET['ajax']) ? 1 : 0);
		$this->view->nothing = ((count($shared) == 0) ? 1 : 0);
	}
}