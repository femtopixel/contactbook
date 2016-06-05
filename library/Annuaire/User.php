<?php
/**
 * User class manage all sites users
 *
 * @package   Core
 * @author    Jeremy MOULIN <jeremy.moulin@Gears.com>
 * @copyright 2008-2009 Gears
 * @version   Paper
 */
class Annuaire_User {

	/**
	 * Cookie duration
	 */
	const COOKIETIME = 2592000;//60 * 60 * 24 * 30;

	/**
	 * User id
	 *
	 * @var int
	 */
	private $_id;

	/**
	 * User mail
	 *
	 * @var string
	 */
	private $_mail;

	/**
	 * User password
	 *
	 * @var sha1
	 */
	private $_password;
	/**
	 * User random secret key (for invitation or lost password))
	 *
	 * @var string
	 */
	private $_secret;
	/**
	 * User active state
	 *
	 * @var bool
	 */
	private $_active;
	/**
	 * User login
	 *
	 * @var string
	 */
	private $_login;
	/**
	 * User last connection IP
	 *
	 * @var string
	 */
	private $_lastConnectIp;
	/**
	 * No sending mail
	 *
	 * @var bool
	 */
	private $_noMail = false;
	/**
	 * Name
	 *
	 * @var string
	 */
	private $_name = '';
	/**
	 * First name
	 *
	 * @var string
	 */
	private $_firstName = '';
	
	/**
	 * Constructor, Create instance by user id or user mail/login
	 *
	 * @param int|string $idOrMail User Id or User mail/login
	 */
	public function __construct($idOrMail = false) {
		$db = Gears_Db::getDb ( );
		$this->_id = 0;
		if (is_numeric ( $idOrMail )) {
			$sql = 'SELECT * FROM ANNUAIRE_USER WHERE USER_ID = ? AND USER_DELETED IS NULL';
			$values = Array ( $idOrMail );
		} else {
			$idOrMail = strtolower ( $idOrMail );
			$sql = 'SELECT * FROM ANNUAIRE_USER WHERE (USER_MAIL = ? OR USER_LOGIN = ?) AND USER_DELETED IS NULL';
			$values = Array ( $idOrMail, $idOrMail );
		}

		$result = $db->fetchAll ( $sql, $values );

		if (count ( $result )) {
			$this->_id = $result [0] ['USER_ID'];
			$this->_mail =  $result [0] ['USER_MAIL'];
			$this->_password = $result [0] ['USER_PASSWORD'];
			$this->_secret = $result [0] ['USER_SECRET'];
			$this->_active = $result [0] ['USER_ACTIVE'];
			$this->_login = $result [0] ['USER_LOGIN'];
			$this->_lastConnectIp = $result [0] ['USER_IP'];
			$this->_name = $result [0] ['USER_NAME'];
			$this->_firstName = $result [0] ['USER_FIRSTNAME'];
		}
	}

	/**
	 * Define user login
	 *
	 * @param string $value User login (must not be a mail)
	 *
	 * @return bool User login valid or not
	 */
	public function setLogin($value) {
		if (! strpos ( $value, '@' ) && strlen($value) && !is_numeric($value)) {
			$db = Gears_Db::getDb ( );
			$sql = 'SELECT * FROM ANNUAIRE_USER WHERE USER_LOGIN = ? AND USER_DELETED IS NULL';
			$result = $db->fetchAll ( $sql, Array ( strtolower ( $value ) ) );
			if (! count ( $result )) {
				$this->_login = strip_tags ( strtolower ( $value ) );
				return (true);
			} else
				return (false);
		} else
			return (false);
	}

	/**
	 * Retrieve User login
	 *
	 * @return string
	 */
	public function getLogin() {
		return ($this->_login);
	}
	
	/**
	 * Retrieve User last connect IP
	 *
	 * @return string
	 */
	public function getLastIp() {
		return ($this->_lastConnectIp);
	}
	
	/**
	 * Set User last connect IP
	 *
	 * @param string $ip User's IP
	 */
	public function setLastIp($ip) {
		$this->_lastConnectIp = strip_tags ( $ip );
	}
	
	/**
	 * Set Name
	 *
	 * @param string $value Name
	 */
	public function setName($value) {
		$this->_name = strip_tags ( $value );
	}
	
	/**
	 * Set First Name
	 *
	 * @param string $value First name
	 */
	public function setFirstName($value) {
		$this->_firstName = strip_tags ( $value );
	}

	/**
	 * Generate random string of X size
	 *
	 * @param int $car Size of the string
	 */
	public function setRandom($car) {
		$string = '';
		$chaine = 'abcdefghijklmnpqrstuvwxyz0123456789';
		srand ( ( double ) microtime () * 1000000 );
		for($i = 0; $i < $car - strlen ( time () ); $i ++) {
			$string .= $chaine [rand () % strlen ( $chaine )];
		}
		$this->_secret = $string . time ();
	}

	/**
	 * Retrieve User secret key
	 *
	 * @return string
	 */
	public function getRandom() {
		return ($this->_secret);
	}

	/**
	 * Get a user id by its secret key
	 *
	 * @param string $secret User secret key
	 *
	 * @return int User id
	 */
	public static function getIdBySecret($secret) {
		if (strtolower ( $secret ) == 'null')
			return (0);
		$db = Gears_Db::getDb ( );
		$sql = 'SELECT * FROM ANNUAIRE_USER WHERE USER_SECRET = ? AND USER_DELETED IS NULL';
		$result = $db->fetchAll ( $sql , Array ( strtolower ( $secret ) ) );
		if (count ( $result ))
			return $result [0] ['USER_ID'];
		else
			return 0;
	}

	/**
	 * Retrieve user id
	 *
	 * @return int
	 */
	public function getId() {
		return ($this->_id);
	}

	/**
	 * Retrieve User mail
	 *
	 * @return string
	 */
	public function getMail() {
		return ( $this->_mail );
	}
	
	/**
	 * Retrieve User name
	 *
	 * @return string
	 */
	public function getName() {
		return ( $this->_name );
	}
	
	/**
	 * Retrieve User first name
	 *
	 * @return string
	 */
	public function getFirstName() {
		return ( $this->_firstName );
	}

	/**
	 * Set user password
	 *
	 * @param string $value password
	 */
	public function setPassword($value) {
		$this->_password = sha1 ( sha1 ( $value , true) , true );
		$this->_secret = 'null';
	}

	/**
	 * Retrieve sha1 crypted User password
	 *
	 * @return sha1
	 */
	public function getPassword() {
		return ($this->_password);
	}

	/**
	 * Connect the user to the plateform
	 *
	 * @param bool $cookies Save a cookie ?
	 */
	public function getConnected($cookies = false) {
		if ($this->_id != 0) {
			Gears_Token::createToken ( 'user' );
			$this->setLastIp(Gears_Utile::getIp());
			$this->commit();
			$session = new Zend_Session_Namespace(__CLASS__);
			$session->id = (Zend_Registry::getInstance()->config->allow_multiple) ? $this->_id : 1;
			$session->mail = $this->_mail;
			$session->login = $this->_login;
			$session->role = (Zend_Registry::getInstance()->config->allow_multiple) ? $this->_id : 1;
			if ($cookies) {
				setcookie ( 'settings', Gears_Utile::passwordEncode('GearsCoreUserPasswordEncoded', serialize($this)), time () + self::COOKIETIME, '/', '', 0 );
			} else {
				setcookie ( 'settings', '0', time () + self::COOKIETIME, '/', '', 0 );
			}
			Zend_Session::regenerateId();
		}
	}

	/**
	 * Connect the user to the plateform by its cookie
	 *
	 */
	public static function getConnectedByCookie() {
		if (isset ( $_COOKIE ['settings'] ) && ($_COOKIE ['settings'] != '0')) {
			try {
				$obj = unserialize(Gears_Utile::passwordDecode('GearsCoreUserPasswordEncoded', $_COOKIE ['settings']));
				if (! ($obj instanceof Annuaire_User)) {
					throw new Exception ('Not a valid user !');
				}
				$user = new Annuaire_User( $obj->getId() );
				if (($user->getPassword () == $obj->getPassword()) && $user->getActive ()) {
					$user->getConnected ( true );
				}
			} catch (Exception $e) {
			}
		}
	}

	/**
	 * Check if mail is valid
	 *
	 * @param string $mail User mail
	 *
	 * @return bool Valid mail
	 */
	static private function checkMail($mail) {
		return (preg_match ( '/^[\ a-z0-9._-]+@[a-z0-9.-]+\.[a-z]{2,6}$/i', $mail ));
	}

	/**
	 * Save all user's updates
	 *
	 */
	public function commit() {
		$db = Gears_Db::getDb ( );
		$sql = 'UPDATE ANNUAIRE_USER SET ';
		$sql .= ' USER_PASSWORD = ?,';
		$sql .= ' USER_ACTIVE = ?,';
		$sql .= ' USER_LOGIN = ?,';
		$sql .= ' USER_MAIL = ?,';
		$sql .= ' USER_IP = ?,';
		$sql .= ' USER_NAME = ?,';
		$sql .= ' USER_FIRSTNAME = ?,';
		$sql .= ' USER_SECRET = ?';
		$sql .= ' WHERE USER_ID = ?';
		
		$values = Array ( $this->_password,
							$this->_active,
							$this->_login,
							$this->_mail,
							$this->_lastConnectIp,
							$this->_name,
							$this->_firstName,
							$this->_secret,
							$this->_id );

		$db->query ( $sql, $values );
	}

	/**
	 * Is the user active ?
	 *
	 * @return bool
	 */
	public function getActive() {
		return ($this->_active);
	}

	/**
	 * Set the user active state
	 *
	 * @param bool $bool User active state
	 */
	public function setActive($bool = true) {
		$this->_active = ($bool) ? 1 : 0;
		$this->_secret = 'null';
	}

	/**
	 * Set user locale
	 *
	 * @param string $value User locale
	 */
	static public function setLocale($value) {
		$session = new Zend_Session_Namespace("Gears_Bootstrap_Language");
		$session->locale = $value;
	}
	
	/**
	 * Get user locale
	 *
	 * @return string User locale
	 */
	static public function getLocale() {
		$session = new Zend_Session_Namespace("Gears_Bootstrap_Language");
		return (isset($session->locale) ? $session->locale : 'auto');
	}

	/**
	 * Protect a page for connected users only
	 *
	 */
	static public function mustBeConnected() {
		if (!self::getCurrentUserId()) {
			Zend_Controller_Front::getInstance()
									->getResponse()
									->setRedirect('/ws/login');
		}
	}

	/**
	 * Retrieve User informations by their Ids
	 *
	 * @param array $array Array of ids to retrieve informations about
	 * @param bool  $all   boolean to return all users informations
	 *
	 * @return Array Array with informations
	 */
	static public function getInfos($array, $all = false) {
		$registry = Zend_Registry::getInstance ();
		$cache = $registry->get ( 'cache' );

		if (! $return = $cache->load ( 'userinfos' )) {
			$sql = 'SELECT * FROM ANNUAIRE_USER WHERE USER_DELETED IS NULL';
			$db = Gears_Db::getDb ( );
			$result = $db->fetchAll ( $sql );
			$return = Array ();
			foreach ( $result as $line ) {
				if ( self::checkMail ( $line ['USER_LOGIN'] ) ) {
					$noMail = explode('@', $line ['USER_LOGIN']);
					$line ['USER_LOGIN'] = $noMail[0];
				}
				$return [$line ['USER_ID']] = $line ['USER_LOGIN'];
			}
			$cache->save ( $return, 'userinfos' );
		}

		foreach ( $return as $id => $value ) {
			if (! in_array ( $id, $array ) && !$all) {
				unset ( $return [$id] );
			}
		}
		return ($return);
	}

	/**
	 * Return the connected User Id
	 *
	 * @return int
	 */
	static public function getCurrentUserId() {
		$session = new Zend_Session_Namespace(__CLASS__);
		return (isset($session->id) ? $session->id : 0);
	}
	
	/**
	 * Return the connected Login
	 *
	 * @return string
	 */
	static public function getCurrentLogin() {
		$session = new Zend_Session_Namespace(__CLASS__);
		return (isset($session->login) ? $session->login : 0);
	}
	
	/**
	 * Return the connected user Role
	 *
	 * @return string
	 */
	static public function getCurrentRole() {
		$session = new Zend_Session_Namespace(__CLASS__);
		return (isset($session->role) ? $session->role : 'guest');
	}
	
	/**
	 * Return the connected user Role
	 *
	 * @param string $value Role to assign
	 */
	static public function setRole($value) {
		$session = new Zend_Session_Namespace(__CLASS__);
				
		if (self::getCurrentUserId()) {
			$session->role = $value;
		} else {
			$session->role = 'guest';
		}
	}
	
	/**
	 * Destroy the session of the current user
	 */
	static public function disconnect() {
		Zend_Session::namespaceUnset(__CLASS__);
		setcookie ( 'settings', '0', time () + self::COOKIETIME, '/', '', 0 );
	}
	
	/**
	 * Permit object (un)serializing
	 *
	 * return array Keys to serialize
	 */
	public function __sleep() {
		return array_keys( get_object_vars( $this ) );
	}
	
}
