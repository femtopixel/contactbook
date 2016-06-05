<?php
/**
 * Error Controller
 *
 */
class ErrorController extends Zend_Controller_Action {

	/**
	 * Protect controller against direct access
	 *
	 */
	public function indexAction() {
		$this->_redirect ( '/' );
	}

	/**
	 * Catch all the errors and do the right action
	 *
	 */
	public function errorAction() {
		$errors = $this->_getParam ( 'error_handler' );

		switch ($errors->type) {
			/**
			 * If is a known error
			 */
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER :
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION :
				// 404 error -- controller or action not found
				$this->view->setLayout ( 'default' );
				$this->view->addLayoutVar ( 'title', t_( "Error" ) );

				$this->getResponse ()->setRawHeader ( 'HTTP/1.1 404 Not Found' );

				$content = t_( "The page you requested was not found." );
				break;
			/**
			 * Any other error
			 */
			default :
				// application error
				$this->getResponse ()->setRawHeader ( 'HTTP/1.1 500 Internal Server Error' );
				$content = t_( "An unexpected error occurred with your request. Please try again later." );
				print "<pre>";
				if ($errors['exception'] instanceof Exception) {
					print $errors['exception']->getMessage() . '<br/>';
				}
				debug_print_backtrace ();
				print "</pre>";
				break;
		}

		// Clear previous content
		$this->getResponse ()->clearBody ();

		$this->view->message = $content;
	}
}
