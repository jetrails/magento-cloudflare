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
	class JetRails_Cloudflare_Model_Adminhtml_Api_Caching_ArgoTieredCache
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		public function getValue () {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/%s", $zoneId, "argo/tiered_caching" );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

		public function setValue ( $value ) {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/%s", $zoneId, "argo/tiered_caching" );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setPayload ( array ( "value" => $value ? "on" : "off" ) );
			return $api->resolve ( $endpoint );
		}

	}
