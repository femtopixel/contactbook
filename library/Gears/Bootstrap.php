<?php
/**
 * General bootstrap
 *
 * @package   Core
 * @author    Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright 2008-2009 Doonoyz
 * @version   Paper
 */

class Gears_Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	
	protected function _initHeader() {
		error_reporting(E_ALL|E_STRICT);
		date_default_timezone_set ( 'Europe/Paris' );
	}
	
	protected function _initSession() {
		Zend_Session::start();
	}
	
	protected function _initRegistry() {
		$registry = new Zend_Registry(array(), ArrayObject::ARRAY_AS_PROPS);
		Zend_Registry::setInstance($registry);
		return $registry;
	}
	
	protected function _initConfig() {
		$config = new Zend_Config_Ini ( ROOT_DIR . 'application/config.ini', ENVIRONMENT );
		$registry = $this->getResource('registry');
		$registry->set ( 'config', $config );
		return $config;
	}
	
	protected function _initCache() {
		$config = $this->getResource('config');
		$cache = Zend_Cache::factory ( $config->cache->front->driver, $config->cache->back->driver, $config->cache->front->options->toArray(), $config->cache->back->options->toArray() );
		$registry = $this->getResource('registry');
		$registry->cache = $cache;
		return $cache;
	}
	
	protected function _initLanguage() {
		$registry = $this->getResource('registry');
		$config = $this->getResource('config');
		$cache = $this->getResource('cache');
		$registry->languages = $config->language->toArray();
		$session = new Zend_Session_Namespace("Gears_Bootstrap_Language");

		if ($config->use_language) {
			
			Zend_Translate::setCache ( $cache );

			$tr = new Zend_Translate ( 'Zend_Translate_Adapter_Gettext', ROOT_DIR . 'application/languages/lang.en.mo', 'en' );
			
			foreach ($registry->languages as $lang => $text) {
				$tr->addTranslation ( ROOT_DIR . 'application/languages/lang.' . $lang . '.mo', $lang );
			}

			try {
				$locale = new Zend_Locale ( $session->locale );
			} catch ( Zend_Locale_Exception $e ) {
				$locale = new Zend_Locale ( 'en' );
			}
			try {
				$tr->setLocale ( $locale->getLanguage () );
			} catch ( Exception $e ) {
				$locale = new Zend_Locale ( 'en' );
				$tr->setLocale ( $locale->getLanguage () );
			}

			$session->locale = $locale->getLanguage ();

			$registry->translate = $tr;

			if (! function_exists ( 't_' )) {
				function t_($text) {
					$tr = Zend_Registry::getInstance ()->translate;
					return $tr->_ ( $text );
				}
			}
		} else {
			$session->locale = 'en';
			if (! function_exists ( 't_' )) {
				function t_($text) {
					return $text;
				}
			}
		}
	}
	
	protected function _initMail() {
		$config = $this->getResource('config');
		$tr = new Zend_Mail_Transport_Smtp ( $config->mail->smtp, $config->mail->config->toArray () );
		Zend_Mail::setDefaultTransport ( $tr );
	}
	
	protected function _initView() {
		$registry = $this->getResource('registry');
		$config = $this->getResource('config');
		$plugin = $config->view->plugin;
		
		$smartyPaths = array ('scriptPath' => ROOT_DIR . 'application/modules/default/views/scripts',
						'compileDir' => ROOT_DIR . 'application/modules/default/views/compile',
						'cacheDir' => ROOT_DIR . 'application/modules/default/views/cache',
						'cache' => $config->template->cache,
						'cacheLife' => $config->template->cacheLife,
						'compileCheck' => $config->template->compileCheck,
						'configDir' => ROOT_DIR . 'application' );

		$view = new $plugin ( $smartyPaths );
		//$view->setScriptPath(ROOT_DIR.'templates');


		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer ( );
		$viewRenderer->setView ( $view );
		// make viewRenderer use Twinmusic_View_Smarty
		
		// make it search for .tpl files
		$viewRenderer->setViewSuffix ( 'tpl' );
		$registry->template = $view->getEngine ();
		
		Zend_Controller_Action_HelperBroker::addHelper ( $viewRenderer );
		return $viewRenderer;
	}
	
	protected function _initCsrf() {
		$csrfPlugin = new Gears_Controller_Plugin_CsrfProtect();
		$csrfPlugin->setEnabled(false); //CSRF commented to allow multiple actions on the site. Must be reactivated in case of CSRF doubts...

		Zend_Controller_Action_HelperBroker::addHelper ( new Gears_Controller_Action_Helper_Csrf ( ) );
		return $csrfPlugin;
	}
	
	protected function _initFront() {
		// setup controller
		$frontController = Zend_Controller_Front::getInstance ();

		// load routing rules configuration
		$config = new Zend_Config_Ini ( ROOT_DIR . 'application/routes.ini', 'all' );
		$router = $frontController->getRouter ();
		$router->addConfig ( $config, 'routes' );

		$frontController->setRouter ( $router );
	}
}