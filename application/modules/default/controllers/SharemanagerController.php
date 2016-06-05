<?php
/**
 * Sharemanager interface
 *
 */
class SharemanagerController extends Zend_Controller_Action {

	/**
	 * Class initialization
	 *
	 * must be connected to use the interface
	 */
	public function init() {
		Annuaire_User::mustBeConnected();
		$this->view->setLayout("default");
		$this->view->addLayoutVar("onglet", 4);
	}

	/**
	 * Display sharemanager interface
	 *
	 */
	public function indexAction() {
		$db = Gears_Db::getDb();
		$share = new Annuaire_Share();
		$globbincontacts = Array();
		$globbincompanies = Array();
		$globboutcontacts = Array();
		$globboutcompanies = Array();
		$results = $share->getMyShare();
		foreach ($results as $key => $info) {
			$obj = ($info['SHARETYPE'] == 'contact') ? new Annuaire_Contact($info['CONTACT_ID']) : new Annuaire_Societe($info['SOCIETE_ID']);
			$user = new Annuaire_User($obj->getUserId());
			$info['USER_MAIL'] = $user->getMail();
			if ($info['SHARETYPE'] == "contact") {
				array_push($globbincontacts, $info);
			} else {
				array_push($globbincompanies, $info);
			}
		}

		$results = $share->getShared();
		foreach ($results as $key => $info) {
			if ($info['SHARETYPE'] == "societe") {
				$res = $db->fetchAll("SELECT CONTACT_ID FROM ANNUAIRE_CONTACT WHERE SOCIETE_ID = ? LIMIT 1", Array($info['SOCIETE_ID']));
				$info['FIRSTCONTACTID'] = $res[0]['CONTACT_ID'];
			}
			if ($info['SHARETYPE'] == "contact") {
				array_push($globboutcontacts, $info);
			} else {
				array_push($globboutcompanies, $info);
			}
		}

		$this->view->whatiamsharing =  (t_("What i am sharing"));
		$this->view->fullcompany =  (t_("Full Company"));
		$this->view->contacts =  (t_("Contacts"));
		$this->view->sharedby =  (t_("Shared by"));
		$this->view->editable =  (t_("Modifiable"));
		$this->view->noteditable =  (t_("Not modifiable"));
		$this->view->deleteshare =  (t_("Delete Share"));
		$this->view->whatissharedwithme =  (t_("What is shared with me"));
		$this->view->nothing =  (t_("nothing"));
		$this->view->sharemanager = t_("Share manager");
		$this->view->globbincompanies = ($globbincompanies);
		$this->view->globbincontacts = ($globbincontacts);
		$this->view->globboutcompanies = ($globboutcompanies);
		$this->view->globboutcontacts = ($globboutcontacts);
	}
}