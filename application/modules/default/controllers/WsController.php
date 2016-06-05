<?php
/**
 * Controller for login/register/setting user preference on the site
 *
 * @package    Core
 * @subpackage controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class WsController extends Zend_Controller_Action {
	/**
	 * Initilization
	 */
	public function init() {
		$this->view->setCacheLife(0);
		$this->view->setLayout('default');
	}
	
	/**
	 * Action to show captcha protection
	 *
	 */
	public function showcaptchaAction() {
        $this->getHelper('viewRenderer')->setNoRender();
		$aFonts = array (ROOT_DIR . '../Core/Gears/Captcha/CROOBIE.ttf', ROOT_DIR . '../Core/Gears/Captcha/LITTLELO.ttf', ROOT_DIR . '../Core/Gears/Captcha/TUFFY.ttf' );
		$oPhpCaptcha = new Gears_Captcha_Captcha ( $aFonts, 200, 50 );
		$oPhpCaptcha->UseColour ( true );
		if (!$oPhpCaptcha->Create ()) {
			throw new Exception('Unable to create file due to GD miss...');
		}
	}

	/**
	 * Action protected that redirect to the site root
	 *
	 */
	public function indexAction() {
		$this->_redirect ( '/' );
	}

	/**
	 * Action to log the user in
	 *
	 */
	public function loginAction() {
		if (Annuaire_User::getCurrentUserId ()) {
			$this->_redirect ( "/" );
		}
		$session = new Zend_Session_Namespace(__CLASS__);
		$error = "none";
		if ($this->getRequest()->isPost()) {
			
			$requestedMail = $this->_request->getPost('mail');
			$user = new Annuaire_User ( $requestedMail );
			if ($user->getActive ()) {
				if (($user->getPassword () == sha1 ( sha1 ( $this->_request->getPost('password') , false ), false ))) {
					$user->getConnected ( isset ( $_POST ['rememberme'] ) );
					$this->_redirect ( $session->redirectPage );
				} else {
					$error = t_( "Login failed, check your login/password." );
				}
			} else {
				$error = t_( "Your account isn't active." );
			}
		}

		$this->view->connect = t_( "Connect" );
		$this->view->login = t_( "Login" );
		$this->view->addLayoutVar ( "title", t_( "Connection" ) );
		$this->view->mail = t_( "Mail or Login" );
		$this->view->mailSub = t_( "Mail or Login" );
		$this->view->password = t_( "Password" );
		$this->view->openIdLogin = t_( "Login with OpenID!" );
		$this->view->rememberMe = t_( "Remember Me?" );
		$this->view->forgotPassword = t_( "Forgotten password?" );
		$this->view->registerAccount = t_( "No account? Click here to register." );
		$this->view->remembered = (isset ( $_COOKIE ['settings'] ) && $_COOKIE ['settings'] != '0') ? 'true' : 'false';

		$loginValue = "";
		$passwordValue = "";

		$this->view->loginValue = strip_tags($this->_request->getPost('mail'));
		$this->view->passwordValue = strip_tags($this->_request->getPost('password'));
		$this->view->errorMsg = $error;
		$this->view->moreInfo = isset($this->moreInfo['login']) ? $this->moreInfo['login'] : '';
	}

	/**
	 * Action to disconnect the user
	 *
	 */
	public function disconnectAction() {
		$this->_helper->viewRenderer->setNoRender ( true );
		Annuaire_User::disconnect();
		$this->_redirect('/');
	}
}