<?php
/**
 * Class Share
 *
 * Class to share a contact or a full company to another user
 * 
 */

Class Annuaire_Share {
	/**
	 * Private member of database
	 */
	private $_db;

	/**
	 * Private member of the share id
	 */
	private $_id;
	
	/**
	 * private member of the current user id
	 */
	private $_uid;
	
	/**
	 * private member of shared user
	 */
	private $_user_id;

	/**
	 * private member of shared company
	 */
	private $_societe_id;

	/**
	 * private member of shared contact
	 */
	private $_contact_id;

	/**
	 * private member of modification boolean
	 */
	private $_modify;

	/**
	 * private member of acceptation boolean
	 */
	private $_accepted;


	/**
	 * Constructor
	 *
	 * @param int $id Id of the share
	 */
	public function __construct($id = false) {
		$this->_uid = Annuaire_User::getCurrentUserId();
		$this->_db = Gears_Db::getDb();
		$this->_id = 0;
		if (is_numeric($id)) {
			$result = $this->_db->fetchAll("SELECT * FROM ANNUAIRE_SHARE WHERE SHARE_ID = ?", Array($id));
			if (count($result)) {
				$this->_id = $id;
				$this->_user_id = $result[0]['USER_ID'];
				$this->_societe_id = $result[0]['SOCIETE_ID'];
				$this->_contact_id = $result[0]['CONTACT_ID'];
				$this->_modify = $result[0]['WRITEABLE'];
				$this->_accepted = $result[0]['ACCEPTED'];
			}
		}
	}

	/**
	 * Get the share id
	 *
	 * @return int
	 */
	public function getId() {
		return $this->_id;
	}

	/**
	 * Share a company
	 *
	 * @param int  $id   Id of the company to share
	 * @param int  $user User Id to share with
	 * @param bool $edit Share with editable rights
	 *
	 * @return bool
	 */
	public function shareSociete($id, $user, $edit = false) {
		$this->_db->beginTransaction();
		try {
			if ($this->_uid != $user) {
				$societe = new Annuaire_Societe($id);
				if ($societe->getUserId() == $this->_uid) {
					if (is_numeric($id) && is_numeric($user)) {
						$sql = "SELECT * FROM ANNUAIRE_SHARE WHERE SOCIETE_ID = ? AND USER_ID = ?";
						if (!count($this->_db->fetchAll($sql, Array($id, $user)))) {
							$sql = "SELECT USER_ID FROM ANNUAIRE_CONTACT WHERE SOCIETE_ID = ?";
							$result = $this->_db->fetchAll($sql, Array($id));
							$where = '(';
							$values = Array();
							foreach ($result as $info) {
								$where .= "USER_ID = ? OR ";
								$values[] = $info['USER_ID'];
							}
							$where .= "1 = 0)";
							$values[] = $user;
							$this->_db->query("DELETE FROM ANNUAIRE_SHARE WHERE $where AND USER_ID = ?", $values);
							$sql = "INSERT INTO ANNUAIRE_SHARE SET USER_ID = ?, SOCIETE_ID = ?, WRITEABLE = '";
							$sql .= ($edit) ? '1' : '0';
							$sql .= "', ACCEPTED = '0'";
							$this->_db->query($sql, Array($user, $id));
							return (true);
						}
					}
				}
			}
		} catch (Exception $e) {
			$this->_db->rollBack();
		}
		return (false);
	}

	/**
	 * Share a contacr
	 *
	 * @param int  $id   Id of the contact to share
	 * @param int  $user User Id to share with
	 * @param bool $edit Share with editable rights
	 *
	 * @return bool
	 */
	public function shareContact($id, $user, $edit = false) {
		if ($this->_uid != $user) {
			$client = new Annuaire_Contact($id);
			if ($client->getUserId() == $this->_uid) {
				if (is_numeric($id) && is_numeric($user)) {
					$values = Array();
					$sql = "SELECT * FROM ANNUAIRE_SHARE WHERE (CONTACT_ID = ?";
					$values[] = $id;
					if ($client->getSocieteId() != 0) {
						$sql .= " OR SOCIETE_ID = ?";
						$values[] = $client->getSocieteId();
					}
					$sql .= ") AND USER_ID = ?";
					$values[] = $user;
					if (!count($this->_db->fetchAll($sql, $values))) {
						$sql = "INSERT INTO ANNUAIRE_SHARE SET USER_ID = ?, CONTACT_ID = ?, WRITEABLE = '";
						$sql .= ($edit) ? '1' : '0';
						$sql .= "', ACCEPTED = '0'";
						$this->_db->query($sql, Array($user, $id));
						return (true);
					}
				}
			}
		}
		return (false);
	}
	
	/**
	 * Delete a share
	 */
	public function delete() {
		$societe = new Annuaire_Societe($this->_societe_id);
		$client = new Annuaire_Contact($this->_contact_id);
		if ($this->_uid == $this->_user_id ||
			$this->_uid == $client->getUserId() ||
			$this->_uid == $societe->getUserId()) {
			$sql = "DELETE FROM ANNUAIRE_SHARE WHERE SHARE_ID = ?";
			$this->_db->query($sql, $this->_id);
		}
	}

	/**
	 * Retrieve all share
	 *
	 * @param bool   $accepted If share is accepted
	 * @param string $term     Searchin term
	 *
	 * @return Array Array containing informations
	 */
	public function getMyShare($accepted = true, $term = null) {
		$accepted = ($accepted) ? 1 : 0;

		$share = $this->_db->fetchAll("SELECT * FROM ANNUAIRE_SHARE sh WHERE sh.USER_ID = ? AND sh.ACCEPTED = ?", Array($this->_uid, $accepted));
		$result = Array();
		foreach ($share as $info) {
			if (is_numeric($info['CONTACT_ID']) && $info['CONTACT_ID'] != 0) {
				$arrayofterm = Array('CONTACT_NOM', 'CONTACT_PRENOM', 'CONTACT_ADRESSE', 'CONTACT_MAIL', 
										'CONTACT_NUMERO', 'CONTACT_PORTABLE', 'CONTACT_COMMENTAIRE', 'CONTACT_FAX',
										'CONTACT_SITE');
				$values = Array();
				$sql = "SELECT * FROM ANNUAIRE_CONTACT WHERE CONTACT_ID = ?";
				$values[] = $info['CONTACT_ID'];
				if ($term != null) {
					$sql .= " AND (";
					foreach ($arrayofterm as $myterm) {
						$sql .= "$myterm LIKE ? OR ";
						$values[] = "%{$term}%";
					}
					$sql .= " 0=1)";
				}
				$myres = $this->_db->fetchAll($sql, $values);
				if (count($myres)) {
					$myres = $myres[0];
					unset($info['CONTACT_ID']);
					unset($info['SOCIETE_ID']);
					foreach ($info as $key => $value) {
						$myres[$key] = $value;
					}
					$myres['SHARETYPE'] = 'contact';
					array_push($result, $myres);
				}
			} else {
				$arrayofterm = Array('SOCIETE_NOM', 'SOCIETE_ADRESSE', 'SOCIETE_NUMERO', 'SOCIETE_ACTIVITE',
									'CONTACT_NOM', 'CONTACT_PRENOM', 'CONTACT_ADRESSE', 'CONTACT_MAIL', 
									'CONTACT_NUMERO', 'CONTACT_PORTABLE', 'CONTACT_COMMENTAIRE', 'CONTACT_FAX',
									'CONTACT_SITE', 'SOCIETE_FAX', 'SOCIETE_SITE');
				$values = Array();
				$sql = "SELECT * FROM ANNUAIRE_CONTACT c LEFT JOIN ANNUAIRE_SOCIETE s ON c.SOCIETE_ID = s.SOCIETE_ID WHERE s.SOCIETE_ID = ?";
				$values[] = $info['SOCIETE_ID'];
				if ($term != null) {
					$sql .= " AND (";
					foreach ($arrayofterm as $myterm) {
						$sql .= "$myterm LIKE ? OR ";
						$values[] = "%{$term}%";
					}
					$sql .= " 0=1)";
				}
				$myres = $this->_db->fetchAll($sql, $values);

				if (count($myres)) {
					unset($info['CONTACT_ID']);
					unset($info['SOCIETE_ID']);
					foreach ($myres as $myinfo) {
						foreach ($info as $key => $value) {
							$myinfo[$key] = $value;
						}
						$myinfo['SHARETYPE'] = 'societe';
						array_push($result, $myinfo);
					}
				}
			}
		}
		return ($result);
	}

	/**
	 * Retrieve users by a contact id
	 *
	 * @return Array Array containing informations
	 */
	public function getSharedByContactId($id) {
		return ($this->_db->fetchAll("SELECT * FROM ANNUAIRE_SHARE s, USER u WHERE u.USER_ID = s.USER_ID AND s.CONTACT_ID = ?", Array($id)));
	}

	/**
	 * Retrieve users by a company id
	 *
	 * @return Array Array containing informations
	 */
	public function getSharedBySocieteId($id) {
		return ($this->_db->fetchAll("SELECT * FROM ANNUAIRE_SHARE s, USER u WHERE u.USER_ID = s.USER_ID AND s.SOCIETE_ID = ?", Array($id)));
	}

	/**
	 * Accept a contact share
	 *
	 * @param int $id Id of the contact to accept
	 *
	 * @return bool
	 */
	public function allowContact($id) {
		$contact = new Annuaire_Contact($id);
		if ($this->_uid == $contact->getUserId()) {
			return (true);
		} else if (count($this->_db->fetchAll("SELECT * FROM ANNUAIRE_SHARE WHERE CONTACT_ID = ? AND USER_ID = ?", Array($id, $this->_uid)))) {
			return (true);
		} else {
			return (false);
		}
	}

	/**
	 * Accept a company share
	 *
	 * @param int $id Id of the company to accept
	 *
	 * @return bool
	 */
	public function allowSociete($id) {
		$societe = new Annuaire_Societe($id);
		if ($this->_uid == $societe->getUserId()) {
			return (true);
		} else if (count($this->_db->fetchAll("SELECT * FROM ANNUAIRE_SHARE WHERE SOCIETE_ID = ? AND USER_ID = ?", Array($id, $this->_uid)))) {
			return (true);
		} else {
			return (false);
		}
	}

	/**
	 * Save changes on a share
	 */
	public function commit() {
		if ($this->_id == 0) {
			$sql = "INSERT INTO";
		} else {
			$sql = "UPDATE";
		}
		$sql .= " ANNUAIRE_SHARE SET ";
		$sql .= "USER_ID = ?,";
		$sql .= "SOCIETE_ID = ?,";
		$sql .= "CONTACT_ID = ?,";
		$sql .= "WRITEABLE = ?,";
		$sql .= "ACCEPTED = ?";
		$values = Array(
			$this->_user_id,
			$this->_societe_id,
			$this->_contact_id,
			$this->_modify,
			$this->_accepted
		);
		if ($this->_id != 0) {
			$sql .= " WHERE SHARE_ID = ?";
			$values[] = $this->_id;
		}
		if (($this->_id != 0) || ($this->_uid == $this->_user_id)) {
			$this->_db->query($sql, $values);
		}
	}

	/**
	 * Switch the modify right
	 */
	public function switchModify() {
		$this->_modify = ($this->_modify) ? 0 : 1;
	}

	/**
	 * Get the modify right
	 *
	 * @param bool
	 */
	public function getModify() {
		return ($this->_modify);
	}

	/**
	 * Accept a share
	 */
	public function accept() {
		$this->_accepted = 1;
	}

	/**
	 * Retrieve shared companies
	 *
	 * @return Array Array containing informations
	 */
	public function getSharedSociete() {
		return ($this->_db->fetchAll("SELECT * FROM ANNUAIRE_SHARE sh, ANNUAIRE_SOCIETE s WHERE s.SOCIETE_ID = sh.SOCIETE_ID AND sh.USER_ID = ?", Array($this->_uid)));
	}

	/**
	 * Retrieve shared contacts
	 *
	 * @return Array Array containing informations
	 */
	public function getShared() {
		$return = Array();
		$sql = "SELECT * FROM ANNUAIRE_SHARE sh, ANNUAIRE_CONTACT c WHERE c.CONTACT_ID = sh.CONTACT_ID AND c.USER_ID = ?";
		$result = $this->_db->fetchAll($sql, Array($this->_uid));
		if (count($result)) {
			foreach ($result as $info) {
				$info['SHARETYPE'] = 'contact';
				array_push($return, $info);
			}
		}

		$sql = "SELECT * FROM ANNUAIRE_SHARE sh, ANNUAIRE_SOCIETE s WHERE s.SOCIETE_ID = sh.SOCIETE_ID AND s.USER_ID = ?";
		$result = $this->_db->fetchAll($sql, Array($this->_uid));
		if (count($result)) {
			foreach ($result as $info) {
				$info['SHARETYPE'] = 'societe';
				array_push($return, $info);
			}
		}
		return ($return);
	}

	/**
	 * Retrieve the user id
	 *
	 * @return int
	 */
	public function getUserId() {
		return ($this->_user_id);
	}

	/**
	 * Retrieve the contact id
	 *
	 * @return int
	 */
	public function getContactId() {
		return ($this->_contact_id);
	}
}
