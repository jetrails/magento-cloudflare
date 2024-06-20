<?php

	/**
	 * This model class inherits from the Setter model.  It essentially wraps
	 * that class in order to send passed data to the Cloudflare API endpoint.
	 * @version     1.3.1
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Network_Grpc
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		public function getValue () {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/%s", $zoneId, "flags" );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$response = $api->resolve ( $endpoint );
			$value = null;
			if ( 
				isset ( $response ) &&
				isset ( $response->result ) &&
				isset ( $response->result->protocols ) &&
				isset ( $response->result->protocols->gRPC )
			) {
				$value = $response->result->protocols->gRPC ? "on" : "off";
			}
			return array ( "result" => array ( "value" => $value ) );
		}

		public function setValue ( $value ) {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/%s", $zoneId, "flags/products/protocols/changes" );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_POST );
			$api->setPayload ( array ( "feature" => "gRPC", "value" => $value ) );
			return $api->resolve ( $endpoint );
		}

	}
