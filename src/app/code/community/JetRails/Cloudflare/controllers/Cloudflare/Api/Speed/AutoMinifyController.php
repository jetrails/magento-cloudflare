<?php

	/**
	 * This controller inherits from a generic controller that implements the
	 * base functionality for interfacing with a getter model. This action
	 * simply loads the initial value through the Cloudflare API. The rest of
	 * this class extends on that functionality and adds more endpoints.
	 * @version     1.2.3
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Cloudflare_Api_Speed_AutoMinifyController
	extends JetRails_Cloudflare_Controller_Getter {

		/**
		 * This action takes in the js, css, and html state through the request
		 * parameters. It then asks the Cloudflare API model to update the
		 * state of auto minification based on these passed values.
		 * @return  void
		 */
		public function changeAction () {
			$api = Mage::getModel ("cloudflare/api_speed_autoMinify");
			$response = $api->change (
				$this->_request->getParam ("js"),
				$this->_request->getParam ("css"),
				$this->_request->getParam ("html")
			);
			return $this->_sendResponse ( $response );
		}

	}
