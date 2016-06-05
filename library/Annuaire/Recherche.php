<?php
/**
 * Class Recherche
 *
 * Class to search contact/companies
 * 
 */

Class Annuaire_Recherche {
	/**
	 * Private member for database
	 */
	private $_db;

	/**
	 * Private member for number of result
	 */
	private $_limit;

	/**
	 * private member for result number
	 */
	private $_nbresult;

	/**
	 * private member for number of pages
	 */
	private $_nbpage;

	/**
	 * private member for term searched
	 */
	private $_term;

	/**
	 * private member for authorized terms
	 */
	private $_arrayofterm;

	/**
	 * private member for shared results
	 */
	private $_share;


	/**
	 * constructor to search
	 *
	 * @param string $term Searched term
	 */
	public function __construct($term) {
		$this->_share = new Annuaire_Share();
		$uid = Annuaire_User::getCurrentUserId();
		$this->_term = '%' . addslashes($term) . '%';
		$this->_db = Gears_Db::getDb();
		$this->_arrayofterm = Array('SOCIETE_NOM', 'SOCIETE_ADRESSE', 'SOCIETE_NUMERO', 'SOCIETE_ACTIVITE',
									'CONTACT_NOM', 'CONTACT_PRENOM', 'CONTACT_ADRESSE', 'CONTACT_MAIL', 
									'CONTACT_NUMERO', 'CONTACT_PORTABLE', 'CONTACT_COMMENTAIRE', 'CONTACT_FAX',
									'CONTACT_SITE', 'SOCIETE_FAX', 'SOCIETE_SITE');
		$sql = "SELECT * FROM ANNUAIRE_CONTACT c LEFT JOIN ANNUAIRE_SOCIETE s ON c.SOCIETE_ID = s.SOCIETE_ID WHERE (";
		$values = Array();
		foreach ($this->_arrayofterm as $myterm) {
			$sql .= "$myterm LIKE ? OR ";
			$values[] = $this->_term;
		}
		$sql .= " 0=1) AND c.USER_ID = ? ORDER BY s.SOCIETE_ID";
		$values[] = $uid;
		$result = $this->_db->fetchAll($sql, $values);
		$this->_nbresult = count($result) + count($this->_share->getMyShare(true, $this->_term));
	}

	/**
	 * Change the number of result per page
	 *
	 * @param int $value Number of result per page
	 */
	public function setLimit($value) {
		if (is_numeric($value)) {
			$this->_limit = (int) $value;
			$this->_nbpage = ceil($this->_nbresult / $this->_limit);
		}
	}

	/**
	 * Get number of pages
	 *
	 * @return int Number of pages
	 */
	public function getNbPage() {
		return($this->_nbpage);
	}

	/**
	 * Get results for a page
	 *
	 * @param int $page Page number
	 *
	 * @return Array Array containing informations
	 */
	public function go($page) {
		if ($this->_nbresult) {
			$uid = Annuaire_User::getCurrentUserId();
			$page = (int) $page;
			if ($page <= 1) {
				$page = 1;
			}
			if ($page >= $this->_nbpage) {
				$page = $this->_nbpage;
			}
			$start = $this->_limit * ($page - 1);

			$sql = "SELECT * FROM ANNUAIRE_CONTACT c LEFT JOIN ANNUAIRE_SOCIETE s ON c.SOCIETE_ID = s.SOCIETE_ID WHERE (";
			$values = Array();
			foreach ($this->_arrayofterm as $myterm) {
				$sql .= "$myterm LIKE ? OR ";
				$values[] = $this->_term;
			}
			$sql .= " 0=1) AND c.USER_ID = ? ORDER BY s.SOCIETE_ID";
			$values[] = $uid;
			$result = $this->_db->fetchAll($sql, $values);
			$shared = $this->_share->getMyShare(true, $this->_term);
			foreach ($shared as $info) {
				array_push($result, $info);
			}
			$array = Array();
			for($i = $start; $i < $start + $this->_limit; $i++) {
				if (isset($result[$i])) {
					array_push($array, $result[$i]);
				}
			}
			return ($array);
		} else {
			return (Array());
		}
	}
}