<?php
/**
 * Exception due to new routing rules
 *
 */
class Annuaire_Exception extends Zend_Exception {
	/**
	 * Error if action doesn't exists
	 *
	 */
	const NOACTION = 1;
	/**
	 * Error if controller doesn't exists
	 *
	 */
	const NOCONTROLLER = 2;
	/**
	 * Type of the exception
	 *
	 */
	public $type = Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION;
	
	/**
	 * Set the type of error
	 *
	 * @param int $type Error code (see const)
	 */
	public function setType($type) {
		switch ($type) {
			case NOACTION :
				$this->type = Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION;
				break;
			case NOCONTROLLER :
				$this->type = Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER;
				break;
			default :
				$this->type = Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER;
				break;
		}
	}
}
