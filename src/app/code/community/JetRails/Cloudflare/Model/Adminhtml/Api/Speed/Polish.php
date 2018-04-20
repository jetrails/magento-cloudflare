<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Speed_Polish extends Mage_Core_Model_Abstract {

		public function getValue () {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/settings/polish", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

		public function getWebP () {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/settings/webp", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

		public function change ( $value, $webp ) {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/settings/polish", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array ( "value" => $value ) );
			$response = $api->resolve ( $endpoint );
			if ( $response->success && $value != "off" ) {
				$endpoint = sprintf ( "zones/%s/settings/webp", $zoneId );
				$api = Mage::getModel ("cloudflare/api_request");
				$api->setType ( $api::REQUEST_PATCH );
				$api->setData ( array ( "value" => $webp ? "on" : "off" ) );
				$response = $api->resolve ( $endpoint );
			}
			return $response;
		}

	}
