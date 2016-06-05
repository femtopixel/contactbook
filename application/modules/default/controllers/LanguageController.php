<?php
/**
 * Language Controller
 *
 */
class LanguageController extends Zend_Controller_Action {
	/**
	 * Change the locale to selected
	 *
	 */
	public function indexAction() {
		$lang = $this->_getParam ( 'language' );
		Annuaire_User::setLocale ( $lang );
		$previous = isset ( $_SERVER ["HTTP_REFERER"] ) ? $_SERVER ["HTTP_REFERER"] : '/';
		$this->_redirect ( $previous );
	}
}
