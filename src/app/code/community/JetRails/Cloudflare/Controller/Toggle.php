<?php

	/**
	 * This class inherits from the Getter class and therefore, has an index
	 * action. The main action in this class is the toggle action which takes
	 * the passed value and casts it into a boolean value. That value is then
	 * passed straight to the API model.
	 * @version     1.1.0
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Controller_Toggle
	extends JetRails_Cloudflare_Controller_Getter {

		/**
		 * This action reads the value parameter and simply casts the value into
		 * a boolean. After that, it passes that boolean value to the
		 * appropriate API model. This API model is determined by the endpoint
		 * that was visited.
		 * @return 	void
		 */
		public function toggleAction () {
			$resource = Mage::app ()->getRequest ()->getControllerName ();
			$resource = preg_replace ( "/^cloudflare_/", "", $resource );
			$api = Mage::getModel ("cloudflare/$resource");
			$state = $this->_request->getParam ("state");
			$response = $api->setValue ( $state === "true" );
			return $this->_sendResponse ( $response );
		}

	}
