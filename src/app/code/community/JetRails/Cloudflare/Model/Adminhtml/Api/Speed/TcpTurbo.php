<?php

	/**
	 * This model class inherits from the Getter model. It essentially wraps
	 * that class in order to send passed data to the Cloudflare API endpoint.
	 * @version     1.2.6
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Speed_TcpTurbo
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Getter {

		/**
		 * @var     string      _endpoint       Appended to zone endpoint
		 */
		protected $_endpoint = "";

		/**
		 * This method simply constructs a GET request to the endpoint that is
		 * most appropriate based on how this object was configured.
		 * @return  stdClass                          CF response to request
		 */
		public function getValue () {
			$endpoint = $this->getEndpoint ();
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$response = $api->resolve ( $endpoint );
			if ( $response->success ) {
				$response->result = $response->result->plan->legacy_id;
			}
			return $response;
		}

	}
