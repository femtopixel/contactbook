<?php
/**
 * Class societe
 *
 * Class to update/create/delete a company
 */

Class Annuaire_Societe {

	/**
	 * Private member of company Id
	 */
	private $_id;

	/**
	 * private member of database
	 */
	private $_db;

	/**
	 * private member of the name of the company
	 */
	private $_nom;

	/**
	 * private member of the company address
	 */
	private $_adresse;

	/**
	 * Private member of the company phone
	 */
	private $_numero;

	/**
	 * private member of the company activity
	 */
	private $_activite;
	
	/**
	 * Private member of the company fax
	 */
	private $_fax;

	/**
	 * private member of the company site
	 */
	private $_site;
	
	/**
	 * Private member of the owner user id 
	 */
	private $_user_id = 0;

	/**
	 * Constructor
	 *
	 * @param int $id company Id
	 */
	public function __construct($id = 0) {
		$this->_db = Gears_Db::getDb();
		if (is_numeric($id)) {
			$sql = "SELECT * FROM ANNUAIRE_SOCIETE WHERE SOCIETE_ID = ?";
			$result = $this->_db->fetchAll($sql, Array($id));
			if (count($result)) {
				$this->_id = $result[0]['SOCIETE_ID'];
				$this->_nom = addslashes($result[0]['SOCIETE_NOM']);
				$this->_adresse = addslashes($result[0]['SOCIETE_ADRESSE']);
				$this->_numero = addslashes($result[0]['SOCIETE_NUMERO']);
				$this->_activite = addslashes($result[0]['SOCIETE_ACTIVITE']);
				$this->_fax = addslashes($result[0]['SOCIETE_FAX']);
				$this->_site = addslashes($result[0]['SOCIETE_SITE']);
				$this->_user_id = addslashes($result[0]['USER_ID']);
			} else {
				$this->_id = 0;
			}
		} else {
			$this->_id = 0;
		}
	}

	/**
	 * Get the company id
	 *
	 * @return int Company Id
	 */
	public function getId() {
		return ($this->_id);
	}

	/**
	 * Get the company name
	 *
	 * @return string Company name
	 */
	public function getNom() {
		return (stripslashes($this->_nom));
	}

	/**
	 * Get the company address
	 *
	 * @return string Company Address
	 */
	public function getAdresse() {
		return (stripslashes($this->_adresse));
	}

	/**
	 * Get the company phone number
	 *
	 * @return string Company phone number
	 */
	public function getNumero() {
		return (stripslashes($this->_numero));
	}

	/**
	 * Get the company activity
	 *
	 * @return string Company activity
	 */
	public function getActivite() {
		return (stripslashes($this->_activite));
	}

	/**
	 * Get the company fax
	 *
	 * @return string Company fax
	 */
	public function getFax() {
		return (stripslashes($this->_fax));
	}

	/**
	 * Get the company site
	 *
	 * @return string Company site
	 */
	public function getSite() {
		return (stripslashes($this->_site));
	}

	/**
	 * Set the company Name
	 *
	 * @param string $values Company Name
	 */
	public function setNom($value) {
		$this->_nom = addslashes($value);
	}

	/**
	 * Set the company address
	 *
	 * @param string $values Company address
	 */
	public function setAdresse($value) {
		$this->_adresse = addslashes($value);
	}

	/**
	 * Set the company phone number
	 *
	 * @param string $values Company phone number
	 */
	public function setNumero($value) {
		$this->_numero = addslashes($value);
	}

	/**
	 * Set the company activity
	 *
	 * @param string $values Company activity
	 */
	public function setActivite($value) {
		$this->_activite = addslashes($value);
	}

	/**
	 * Set the company Fax
	 *
	 * @param string $values Company Fax
	 */
	public function setFax($value) {
		$this->_fax = addslashes($value);
	}

	/**
	 * Set the company Site
	 *
	 * @param string $values Company Site
	 */
	public function setSite($value) {
		$this->_site = addslashes($value);
	}

	/**
	 * Save the company modifications
	 */
	public function commit() {
		if ($this->_id == 0) {
			$sql = "INSERT INTO";
			$this->_user_id = Annuaire_User::getCurrentUserId();
		} else {
			$sql = "UPDATE";
		}
		$sql .= " ANNUAIRE_SOCIETE SET ";
		$sql .= "SOCIETE_NOM = ?, ";
		$sql .= "SOCIETE_ADRESSE = ?, ";
		$sql .= "SOCIETE_NUMERO = ?, ";
		$sql .= "SOCIETE_ACTIVITE = ?, ";
		$sql .= "SOCIETE_FAX = ?, ";
		$sql .= "SOCIETE_SITE = ?, ";
		$sql .= "USER_ID = ?";
		$values = Array(
			$this->_nom,
			$this->_adresse,
			$this->_numero,
			$this->_activite,
			$this->_fax,
			$this->_site,
			$this->_user_id
		);
		if ($this->_id != 0) {
			$sql .= " WHERE SOCIETE_ID = ?";
			$values[] = $this->_id;
		}
		$this->_db->query($sql, $values);
	}

	/**
	 * Get the user id
	 *
	 * @return int user id
	 */
	public function getUserId() {
		return (stripslashes($this->_user_id));
	}
}
