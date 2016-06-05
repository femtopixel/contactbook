<?php 
/**
 * Controller to delete a company
 *
 */
class DeletesocieteController extends Zend_Controller_Action {

	/**
	 * Initialization
	 *
	 * Must be connected to user this interface
	 */
	public function init() {
		Annuaire_User::mustBeConnected();
		$this->view->setLayout("default");
		$this->view->addLayoutVar("onglet", 3);
	}

	/**
	 * Display interface
	 *
	 */
	public function indexAction() {
		$db = Gears_Db::getDb();
		$uid = Annuaire_User::getCurrentUserId();
		$sql = "SELECT * FROM ANNUAIRE_SOCIETE WHERE USER_ID = ?";
		$result = $db->fetchAll($sql, Array($uid));
		
		$array = Array();
		foreach($result as $info) {
			$array[$info['SOCIETE_ID']][0] = $info['SOCIETE_ID'];
			$array[$info['SOCIETE_ID']][1] = $info['SOCIETE_NOM'];
		}
		$this->view->result = ($array);
		$this->view->deletesociety =  (t_("Delete a companie"));
		$this->view->deleteonlysociety =  (t_("Delete only the companie"));
		$this->view->deleteallsociety =  (t_("Delete the companie and all its contacts"));
	}
}