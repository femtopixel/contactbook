<?php
/**
 * Contact controller to display a contact information
 *
 */
class ContactController extends Zend_Controller_Action {

	/**
	 * Controller initialization
	 *
	 * Must be connected to use this service
	 */
	public function init() {
		Annuaire_User::mustBeConnected();
		$this->view->setLayout('default');
	}

	/**
	 * Action to add a contact
	 *
	 */
	public function addAction() {
		$this->view->addLayoutVar("onglet", 2);
		$uid = Annuaire_User::getCurrentUserId();
		$this->view->title = t_('Add');
		$db = Gears_Db::getDb();
		$clients = Array();
		$result = $db->fetchAll("SELECT * FROM ANNUAIRE_SOCIETE WHERE USER_ID = ?", Array($uid));
		foreach ($result as $info) {
			$clients[$info['SOCIETE_ID']][0] = $info['SOCIETE_ID'];
			$clients[$info['SOCIETE_ID']][1] = $info['SOCIETE_NOM'];
		}
		$this->view->clients = ($clients);
		$this->view->addcontact = t_("Add a contact");
		$this->view->name = t_("Name");
		$this->view->firstname = t_("First Name");
		$this->view->address = t_("Address");
		$this->view->mail = t_("Mail");
		$this->view->phone = t_("Phone Number");
		$this->view->cell = t_("Cellphone number");
		$this->view->fax = t_("Fax");
		$this->view->site = t_("Website");
		$this->view->comment = t_("Comment");
		$this->view->society = t_("Companie");
		$this->view->none = t_("none");
		$this->view->send = t_("Send");
		$this->view->addsociety = t_("Add a companie");
		$this->view->activity = t_("Activity");
	}

	/**
	 * Consult a contact
	 *
	 */
	public function consultAction() {
		$this->view->addLayoutVar("onglet", 1);
		$id_user = $this->_getParam('userId');
		$option = $this->_getParam('option');

		$user = new Annuaire_Contact($id_user);
		$societe = new Annuaire_Societe($user->getSocieteId());
		$uid = Annuaire_User::getCurrentUserId();
		$share = new Annuaire_Share();
		$shared = $share->getSharedByContactId($user->getId());
		$share = new Annuaire_Share(isset($shared[0]['SHARE_ID']) ? $shared[0]['SHARE_ID'] : 0);
		if ($share->getId() == 0) {
			$shared = $share->getSharedBySocieteId($societe->getId());
			$share = new Annuaire_Share(isset($shared[0]['SHARE_ID']) ? $shared[0]['SHARE_ID'] : 0);
		}
		
		if (!$share->allowContact($user->getId())) {
			if (!$share->allowSociete($societe->getId())) {
				throw new Exception (t_('Not your contact'));
			}
		}
		
		$db = Gears_Db::getDb();
		$sql = "SELECT * FROM ANNUAIRE_SOCIETE WHERE USER_ID = ?";
		$result = $db->fetchAll($sql, Array($uid));
		$sharedSociete = $share->getSharedSociete();
		foreach ($sharedSociete as $temp) {
			array_push($result, $temp);
		}
		$societes = Array();
		foreach ($result as $item) {
			$societes[$item['SOCIETE_ID']][0] = $item['SOCIETE_ID'];
			$societes[$item['SOCIETE_ID']][1] = $item['SOCIETE_NOM'];
		}

		$this->view->nom = (($user->getNom() == "") ? t_("(None)") : $user->getNom());
		$this->view->prenom = (($user->getPrenom() == "") ? t_("(None)") : $user->getPrenom());
		$this->view->id = ($user->getId());
		$this->view->adresse = (($user->getAdresse() == "") ? t_("(None)") : $user->getAdresse());
		$this->view->mail = (($user->getMail() == "") ? t_("(None)") : $user->getMail());
		$this->view->numero = (($user->getNumero() == "") ? t_("(None)") : $user->getNumero());
		$this->view->portable = (($user->getPortable() == "") ? t_("(None)") : $user->getPortable());
		$this->view->commentaire = (($user->getCommentaire() == "") ? t_("(None)") : $user->getCommentaire());
		$this->view->societeid = ($societe->getId());
		$this->view->nomsociete = (($societe->getnom() == "") ? t_("(None)") : $societe->getnom());
		$this->view->adressesociete = (($societe->getAdresse() == "") ? t_("(None)") : $societe->getAdresse());
		$this->view->numerosociete = (($societe->getNumero() == "") ? t_("(None)") : $societe->getNumero());
		$this->view->activite = (($societe->getActivite() == "") ? t_("(None)") : $societe->getActivite());
		$this->view->fax = (($user->getFax() == "") ? t_("(None)") : $user->getFax());
		$this->view->site = (($user->getSite() == "") ? t_("(None)") : $user->getSite());
		$this->view->faxsociete = (($societe->getFax() == "") ? t_("(None)") : $societe->getFax());
		$this->view->sitesociete = (($societe->getSite() == "") ? t_("(None)") : $societe->getSite());
		$this->view->societes = ($societes);
		$this->view->edit = ($option == "edit" ? (($user->getUserId() == $uid) ? 1 :($share->getModify() ? ($share->getContactId() ? 1 : 2) : 0)) : 0);
		$this->view->delete = ($option == "delete" ? (($user->getUserId() == $uid) ? 1 : 0) : 0);
		$this->view->shared = (($share->getId() == 0) ? 0 : 1);

		$this->view->companieName =  (t_("Company name"));
		$this->view->companieAddress =  (t_("Company address"));
		$this->view->companiePhone =  (t_("Company phone"));
		$this->view->companieActivity =  (t_("Company activity"));
		$this->view->companieFax =  (t_("Company fax"));
		$this->view->companieWebsite =  (t_("Company website"));
		$this->view->person =  (t_("Person"));
		$this->view->name =  (t_("Name"));
		$this->view->fistname =  (t_("Firstname"));
		$this->view->address =  (t_("address"));
		$this->view->mailText =  (t_("Mail"));
		$this->view->phone =  (t_("Phone Number"));
		$this->view->cell =  (t_("Cellphone number"));
		$this->view->faxText =  (t_("Fax"));
		$this->view->website =  (t_("Website"));
		$this->view->comment =  (t_("Comment"));
		$this->view->companie =  (t_("Company"));
		$this->view->none =  (t_("(None)"));
		$this->view->sureDeleteContact =  (t_("Are you sure you want to delete this contact ?"));
		$this->view->yes =  (t_("Yes"));
		$this->view->no =  (t_("No"));
	}

	/**
	 * Action to share a contact or a company
	 *
	 */
	public function shareAction() {	
		$this->view->addLayoutVar("onglet", 1);
		$id_user = $this->_getParam('userId');
		
		$user = new Annuaire_Contact($id_user);
		$societe = new Annuaire_Societe($user->getSocieteId());
		$uid = Annuaire_User::getCurrentUserId();
		$share = new Annuaire_Share();
		if (!$share->allowContact($user->getId())) {
			throw new Exception (t_('Not your contact'));
		}

		$this->view->nom = (($user->getNom() == "") ? t_("(None)") : $user->getNom());
		$this->view->prenom = (($user->getPrenom() == "") ? t_("(None)") : $user->getPrenom());
		$this->view->companyname = (($societe->getNom() == "") ? t_("(None)") : $societe->getNom());
		$this->view->id = ($user->getId());
		$this->view->societeid = (($societe->getUserId() == $uid) ? $societe->getId() : 0);
		$this->view->admin = (($user->getUserId() == $uid) ? 1 : 0);
		$this->view->sharedwith =  (t_("Shared with :"));
		$this->view->addshare =  (t_("Add a share"));
		$this->view->sharecontact =  (t_("Share a contact"));
		$this->view->sharesociete =  (t_("Share a company"));
		$this->view->sureDeleteShare =  (t_("Are you sure you want to delete this share ?"));
		$this->view->delete =  (t_("Delete"));
		$this->view->modify = (t_("Allow to modify"));
		$this->view->yes =  (t_("Yes"));
		$this->view->send =  (t_("Send"));
		$this->view->no =  (t_("No"));
		$this->view->cancel = (t_("Cancel"));
	}
}
