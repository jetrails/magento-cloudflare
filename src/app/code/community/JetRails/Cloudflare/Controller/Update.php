<?php

	/**
	 * This class inherits from the Getter class and therefore, has an index
	 * action. The main action in this class is the update action which simply
	 * passes the value straight to the API model.
	 * @version     1.2.4
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Controller_Update
	extends JetRails_Cloudflare_Controller_Getter {

		/**
		 * This action reads the value parameter and simply passes it on to the
		 * appropriate API model. This API model is determined by the endpoint
		 * that was visited.
		 * @return 	void
		 */
		public function updateAction () {
			$resource = Mage::app ()->getRequest ()->getControllerName ();
			$resource = preg_replace ( "/^cloudflare_/", "", $resource );
			$api = Mage::getModel ("cloudflare/$resource");
			$value = $this->_request->getParam ("value");
			$response = $api->setValue ( $value );
			return $this->_sendResponse ( $response );
		}

	}
