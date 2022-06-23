<?php

	/**
	 * This controller inherits from a generic controller that implements the
	 * base functionality for interfacing with a getter model. This action
	 * simply loads the initial value through the Cloudflare API. The rest of
	 * this class extends on that functionality and adds more endpoints.
	 * @version     1.3.0
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Cloudflare_Api_Dns_CustomNameserversController
	extends JetRails_Cloudflare_Controller_Getter {

		/**
		 * This action takes in custom nameserver records and it then asks the
		 * Cloudflare API model to update the values for the zone.
		 * @return  void
		 */
		public function editAction () {
			$api = Mage::getModel ("cloudflare/api_dns_customNameservers");
			$response = $api->edit (
				$this->_request->getParam ("nameservers")
				? $this->_request->getParam ("nameservers")
				: array ()
			);
			return $this->_sendResponse ( $response );
		}

	}
