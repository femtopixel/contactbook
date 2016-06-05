<?php
/**
 * Delete a company 
 *
 */
class Ajax_DeletesocieteController extends Zend_Controller_Action {

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
		$uid = Annuaire_User::getCurrentUserId();
		$db = Gears_Db::getDb();
		$db->beginTransaction();
		try {
			$method = $_POST['method'];
			$id = (int) $_POST['id'];
			$societe = new Annuaire_Societe($id);
			if ($uid == $societe->getUserId()) {
				if ($method == 'only') {
					$sql = "UPDATE ANNUAIRE_CONTACT SET SOCIETE_ID = 0 WHERE SOCIETE_ID = ? AND USER_ID = ?";
					$db->query($sql, Array($id, $uid));
				} elseif ($method == "all") {
					$sql = "SELECT CONTACT_ID FROM ANNUAIRE_CONTACT WHERE SOCIETE_ID = ?";
					$result = $db->fetchAll($sql, Array($id));
					$newSql = "(";
					$values = Array();
					foreach ($result as $info) {
						$newSql .= "CONTACT_ID = ? OR ";
						$values[] = $info['CONTACT_ID'];
					}
					$newSql .= "1=0)";
					$sql = "DELETE FROM ANNUAIRE_SHARE WHERE $newSql";
					$db->query($sql, $values);
					$sql = "DELETE FROM ANNUAIRE_CONTACT WHERE SOCIETE_ID = ? AND USER_ID = ?";
					$db->query($sql, Array($id, $uid));
				}
				$sql = "DELETE FROM ANNUAIRE_SHARE WHERE SOCIETE_ID = ?";
				$db->query($sql, Array($id));
				$sql = "DELETE FROM ANNUAIRE_SOCIETE WHERE SOCIETE_ID = ? AND USER_ID = ?";
				$db->query($sql, Array($id, $uid));
				$this->_setAnswer('ok');
			} else {
				$this->_setAnswer('error');
			}
		} catch (Exception $e) {
			$db->rollBack();
			$this->_setAnswer('error');
		}
	}
}