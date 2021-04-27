<?php

	/**
	 * This model inherits from the basic Getter model. It inherits
	 * functionality that asks the Cloudflare API for a current setting value.
	 * It then adds on to that functionality by adding more methods that
	 * interact with the Cloudflare API.
	 * @version     1.2.4
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Speed_Polish
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Getter {

		/**
		 * @var     string      _endpoint             Appended to zone endpoint
		 */
		protected $_endpoint = "settings/polish";

		/**
		 * This method contacts the Cloudflare API and asks for the current
		 * value for the webp setting.
		 * @return  stdClass                          CF response to request
		 */
		public function getWebP () {
			$endpoint = $this->getEndpoint ("settings/webp");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

		/**
		 * This method takes in a value for the polish setting and a value for
		 * the webp setting. It then attempts to updates the values using the
		 * Cloudflare API. This is done through two API requests.
		 * @param   boolean      value                The value for polish
		 * @param   boolean      webp                 The value for webp
		 * @return  stdClass                          CF response to request
		 */
		public function change ( $value, $webp ) {
			$endpoint = $this->getEndpoint ();
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setPayload ( array ( "value" => $value ) );
			$response = $api->resolve ( $endpoint );
			if ( isset ( $response->success ) && $response->success && $value != "off" ) {
				$endpoint = $this->getEndpoint ("settings/webp");
				$api = Mage::getModel ("cloudflare/api_request");
				$api->setType ( $api::REQUEST_PATCH );
				$api->setPayload ( array ( "value" => $webp ? "on" : "off" ) );
				$response = $api->resolve ( $endpoint );
			}
			return $response;
		}

	}
