<?php 
/**
 * Post controller that take care about posted datas
 *
 */
class PostController extends Zend_Controller_Action {

	/**
	 * Must be connected to user this interface
	 *
	 */
	public function init() {
		Annuaire_User::mustBeConnected();
	}

	/**
	 * Action to add a company
	 *
	 */
	public function addsocieteAction() {
		$societe = new Annuaire_Societe();
		$societe->setNom($_POST['nom']);
		$societe->setAdresse($_POST['adresse']);
		$societe->setNumero($_POST['numero']);
		$societe->setActivite($_POST['activite']);
		$societe->setFax($_POST['fax']);
		$societe->setSite($_POST['site']);
		$societe->commit();
		$this->_redirect('/contact/add');
	}

	/**
	 * Action to add a contact
	 *
	 */
	public function adduserAction() {
		$contact = new Annuaire_Contact();
		$contact->setNom($_POST['nom']);
		$contact->setPrenom($_POST['prenom']);
		$contact->setAdresse($_POST['adresse']);
		$contact->setMail($_POST['mail']);
		$contact->setNumero($_POST['numero']);
		$contact->setPortable($_POST['portable']);
		$contact->setCommentaire($_POST['commentaire']);
		$contact->setSocieteId($_POST['societe']);
		$contact->setFax($_POST['fax']);
		$contact->setSite($_POST['site']);
		$societe = new Annuaire_Societe($_POST['societe']);

		if (Annuaire_User::getCurrentUserId() == $societe->getUserId() || $_POST['societe'] == 0) {
			$contact->commit();
		}
		$this->_redirect('/contact/add');
	}

	/**
	 * Action to delete a contact
	 *
	 */
	public function deleteuserAction() {
		$uid = Annuaire_User::getCurrentUserId();
		$db = Gears_Db::getDb();
		$id = (int) $_POST['id'];
		$sql = "DELETE FROM ANNUAIRE_CONTACT WHERE CONTACT_ID = ? AND USER_ID = ?";
		$db->query($sql, Array($id, $uid));
		$this->_redirect('/');
	}
}