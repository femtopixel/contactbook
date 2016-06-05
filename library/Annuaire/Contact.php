<?php
/**
 * Class contact
 *
 * Class to update/delete/create a contact
 *  
 */

Class Annuaire_Contact {
	/**
	 * Private member for Id a contact
	 */
	private $_id;

	/**
	 * Private member for database object
	 */
	private $_db;

	/**
	 * Private member for company of the contact
	 */
	private $_societe_id = 0;

	/**
	 * Private member for contact name
	 */
	private $_nom;

	/**
	 * private member for contact first name
	 */
	private $_prenom;

	/**
	 * private member for contact address
	 */
	private $_adresse;

	/**
	 * private member for contact mail
	 */
	private $_mail;

	/**
	 * private member for contact phone number
	 */
	private $_numero;

	/**
	 * private member for contact cellphone number
	 */
	private $_portable;

	/**
	 * private member for contact comment
	 */
	private $_commentaire;

	/**
	 * private member for contact fax
	 */
	private $_fax;

	/**
	 * private member for contact site
	 */
	private $_site;

	/**
	 * private member for contact member user id
	 */
	private $_user_id;

	/**
	 * Constructor to create/update a contact
	 *
	 * @param int $id Id of the contact to update
	 *
	 */
	public function __construct($id = 0) {
		$this->_db = Gears_Db::getDb();

		$sql = "SELECT * FROM ANNUAIRE_CONTACT WHERE CONTACT_ID = ?";
		$result = $this->_db->fetchAll($sql, Array($id));
		if (count($result)) {
			$this->_id = $result[0]['CONTACT_ID'];
			$this->_societe_id = addslashes($result[0]['SOCIETE_ID']);
			$this->_nom = addslashes($result[0]['CONTACT_NOM']);
			$this->_prenom = addslashes($result[0]['CONTACT_PRENOM']);
			$this->_adresse = addslashes($result[0]['CONTACT_ADRESSE']);
			$this->_mail = addslashes($result[0]['CONTACT_MAIL']);
			$this->_numero = addslashes($result[0]['CONTACT_NUMERO']);
			$this->_portable = addslashes($result[0]['CONTACT_PORTABLE']);
			$this->_commentaire = addslashes($result[0]['CONTACT_COMMENTAIRE']);
			$this->_fax = addslashes($result[0]['CONTACT_FAX']);
			$this->_site = addslashes($result[0]['CONTACT_SITE']);
			$this->_user_id = addslashes($result[0]['USER_ID']);
		} else {
			$this->_id = 0;
		}
	}

	/**
	 * Get the contact Id
	 *
	 * @return int Contact ID
	 */
	public function getId() {
		return ($this->_id);
	}

	/**
	 * Get company ID
	 *
	 * @return int Contact's company Id
	 */
	public function getSocieteId() {
		return ($this->_societe_id);
	}

	/**
	 * Get Contact Name
	 *
	 * @return string contact Name
	 */
	public function getNom() {
		return (stripslashes($this->_nom));
	}

	/**
	 * Get Contact First Name
	 *
	 * @return string contact First name
	 */
	public function getPrenom() {
		return (stripslashes($this->_prenom));
	}

	/**
	 * Get Contact address
	 *
	 * @return string Contact address
	 */
	public function getAdresse() {
		return (stripslashes($this->_adresse));
	}

	/**
	 * Get Contact mail
	 *
	 * @return string contact mail
	 */
	public function getMail() {
		return (stripslashes($this->_mail));
	}

	/**
	 * Get contact phone number
	 *
	 * @return string contact phone number
	 */
	public function getNumero() {
		return (stripslashes($this->_numero));
	}

	/**
	 * Get contact cellphone number
	 *
	 * @return string contact cellphone number
	 */
	public function getPortable() {
		return (stripslashes($this->_portable));
	}

	/**
	 * Get Contact comment
	 *
	 * @return string Contact comment
	 */
	public function getCommentaire() {
		return (stripslashes($this->_commentaire));
	}

	/**
	 * Get contact Fax
	 *
	 * @return string contact fax
	 */
	public function getFax() {
		return (stripslashes($this->_fax));
	}

	/**
	 * Get contact site
	 *
	 * @return string contact site
	 */

	public function getSite() {
		return (stripslashes($this->_site));
	}

	/**
	 * Get owner user id
	 * @return int Owner User id
	 */
	public function getUserId() {
		return (stripslashes($this->_user_id));
	}

	/**
	 * Define Contact company by his Id
	 *
	 * @param int $value Company id
	 */
	public function setSocieteId($value) {
		if (is_numeric($value)) {
			$this->_societe_id = (int) $value;
		}
	}

	/**
	 * Define contact name
	 *
	 * @param string $value Contact name
	 */
	public function setNom($value) {
		$this->_nom = addslashes($value);
	}

	/**
	 * Define contact first name
	 *
	 * @param string $value Contact first name
	 */
	public function setPrenom($value) {
		$this->_prenom = addslashes($value);
	}

	/**
	 * Define contact address
	 *
	 * @param string $value Contact address
	 */
	public function setAdresse($value) {
		$this->_adresse = addslashes($value);
	}

	/**
	 * Define contact mail
	 *
	 * @param string $value Contact mail
	 */
	public function setMail($value) {
		$this->_mail = addslashes($value);
	}

	/**
	 * Define contact phone number
	 *
	 * @param string $value Contact phone 
	 */
	public function setNumero($value) {
		$this->_numero = addslashes($value);
	}

	/**
	 * Define contact cellphone number
	 *
	 * @param string $value Contact cellphone
	 */
	public function setPortable($value) {
		$this->_portable = addslashes($value);
	}

	/**
	 * Define contact comment
	 *
	 * @param string $value Contact comment
	 */
	public function setCommentaire($value) {
		$this->_commentaire = addslashes($value);
	}

	/**
	 * Define contact fax
	 *
	 * @param string $value Contact fax
	 */
	public function setFax($value) {
		$this->_fax = addslashes($value);
	}

	/**
	 * Define contact site
	 *
	 * @param string $value Contact site
	 */
	public function setSite($value) {
		$this->_site = addslashes($value);
	}

	/**
	 * Save contact updates
	 */
	public function commit() {
		if ($this->_id == 0) {
			$sql = "INSERT INTO";
			$this->_user_id = Annuaire_User::getCurrentUserId();
		} else {
			$sql = "UPDATE";
		}
		$sql .= " ANNUAIRE_CONTACT SET ";
		$sql .= "SOCIETE_ID = ?, ";
		$sql .= "CONTACT_NOM = ?, ";
		$sql .= "CONTACT_PRENOM = ?, ";
		$sql .= "CONTACT_ADRESSE = ?, ";
		$sql .= "CONTACT_MAIL = ?, ";
		$sql .= "CONTACT_NUMERO = ?, ";
		$sql .= "CONTACT_PORTABLE = ?, ";
		$sql .= "CONTACT_COMMENTAIRE = ?, ";
		$sql .= "CONTACT_FAX = ?, ";
		$sql .= "CONTACT_SITE = ?, ";
		$sql .= "USER_ID = ?";
		$values = Array(
			$this->_societe_id,
			$this->_nom,
			$this->_prenom,
			$this->_adresse,
			$this->_mail,
			$this->_numero,
			$this->_portable,
			$this->_commentaire,
			$this->_fax,
			$this->_site,
			$this->_user_id
		);
		if ($this->_id != 0) {
			$sql .= " WHERE CONTACT_ID = ?";
			$values[] = $this->_id;
		}
		$this->_db->query($sql, $values);
	}
}