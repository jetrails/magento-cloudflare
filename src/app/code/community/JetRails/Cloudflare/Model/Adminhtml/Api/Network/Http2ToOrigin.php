<?php

	/**
	 * This model class inherits from the Setter model.  It essentially wraps
	 * that class in order to send passed data to the Cloudflare API endpoint.
	 * @version     1.2.7
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Network_Http2ToOrigin
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		public function getValue () {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/%s", $zoneId, "origin_max_http_version" );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$response = $api->resolve ( $endpoint );
			if ( isset ( $response ) && isset ( $response->result ) && isset ( $response->result->value ) ) {
				$response->result->value = $response->result->value === "2" ? "on" : "off";
			}
			return $response;
		}

		public function setValue ( $value ) {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/%s", $zoneId, "origin_max_http_version" );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setPayload ( array ( "value" => $value ? "2" : "1" ) );
			return $api->resolve ( $endpoint );
		}

	}
