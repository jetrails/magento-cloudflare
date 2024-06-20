<?php

	/**
	 * This controller inherits from the base action class and it inherits
	 * helper methods that are contained within it. This controller contains two
	 * actions. One gets the values for the polish and webp settings and the
	 * other changes them.
	 * @version     1.3.1
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Cloudflare_Api_Speed_MobileRedirectController
	extends JetRails_Cloudflare_Controller_Action {

		/**
		 * This action asks the Cloudflare API model for the value of the mobile
		 * redirect setting and the available DNS entries. It then combines both
		 * responses and sends it back to the caller.
		 * @return  void
		 */
		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_speed_mobileRedirect");
			$response = $api->getValue ();
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action takes in a polish value and a webp value through the
		 * request parameters. It then uses the Cloudflare API model to change
		 * the passed settings.
		 * @return  void
		 */
		public function changeAction () {
			$api = Mage::getModel ("cloudflare/api_speed_mobileRedirect");
			$response = $api->change (
				$this->_request->getParam ("mobile_subdomain"),
				$this->_request->getParam ("status") === "on" ? "on" : "off",
				$this->_request->getParam ("strip_uri") === "true"
			);
			return $this->_sendResponse ( $response );
		}

	}
