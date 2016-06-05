<?php
/**
 * Template renderer
 *
 */
class Annuaire_View_Smarty extends Gears_View_Smarty {

	/**
	 * Function to initialize the Layout var 
	 *
	 */
	protected function _initLayout() {
		$share = new Annuaire_Share();
		$newShared = $share->getMyShare(false);
		$me = new Annuaire_User(Annuaire_User::getCurrentUserId());

		$this->addLayoutVar ('locale', Annuaire_User::getLocale());
		$this->addLayoutVar ('title', t_('ContactBook'));
		$this->addLayoutVar ('consult', t_('Consult'));
		$this->addLayoutVar ('add', t_('Add'));
		$this->addLayoutVar ('deletecompanie', t_('Delete a companie'));
		$this->addLayoutVar ('useShare', Zend_Registry::getInstance()->config->use_share);
		if (Zend_Registry::getInstance()->config->use_share) {
			$this->addLayoutVar ('sharemanager', t_('Share manager'));
			$this->addLayoutVar ('newShared', (count($newShared)) ? sprintf (t_('%s new share(s)'), count($newShared)) : 0);
			$this->addLayoutVar ('newSharedTitle', t_("New Shares"));
			$this->addLayoutVar ('shares', $newShared);
		}
		
		$this->addLayoutVar ('connected', (Annuaire_User::getCurrentUserId() ? 1 : 0));
		$this->addLayoutVar ('loginOrRegister', t_('Login'));
		$this->addLayoutVar ('disconnect', t_('Disconnect'));
		$this->addLayoutVar ('mylogin', $me->getLogin());
		$this->addLayoutVar ('mymail', $me->getMail());
		
		$this->addJSText('errorSharing', t_("Error while sharing"));
		$this->addJSText('confirmDeleteShare', t_("Are you sure you want to DELETE this share ?"));
		
		$this->addLayoutVar ( "jsver",  filemtime ( ROOT_DIR . 'www/javascript/engine.js' ) );
		$this->addLayoutVar ( "cssver", filemtime ( ROOT_DIR . 'www/css/engine.css' ) );
	}
}