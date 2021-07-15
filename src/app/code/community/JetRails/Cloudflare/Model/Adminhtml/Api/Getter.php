<?php

	/**
	 * This class is a parent class that child classes inherit from. It
	 * implements functionality to easily get a setting value from Cloudflare
	 * using their API.
	 * @version     1.2.5
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Getter
	extends Mage_Core_Model_Abstract {

		/**
		 * @var     string       _endpoint            Postfixed to zone endpoint
		 */
		protected $_endpoint = "";

		/**
		 * This method takes in an optional endpoint that will override the one
		 * that is stored internally. That value is then appended to the zone
		 * endpoint.
		 * @param   mixed        endpoint             Override internal endpoint
		 * @return  string                            Resulting endpoint
		 */
		protected function getEndpoint ( $endpoint = false ) {
			$endpoint = $endpoint ? $endpoint : $this->_endpoint;
			$cnf = Mage::getSingleton ("cloudflare/api_overview_configuration");
			$zoneId = $cnf->getZoneId ();
			return sprintf ( "zones/%s/%s", $zoneId, $endpoint );
		}

		/**
		 * This method simply constructs a GET request to the endpoint that is
		 * most appropriate based on how this object was configured.
		 * @return  stdClass                          CF response to request
		 */
		public function getValue () {
			$endpoint = $this->getEndpoint ();
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

	}
