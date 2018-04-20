<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Speed_Mirage extends Mage_Core_Model_Abstract {

		public function getValue () {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/settings/mirage", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

		public function toggle ( $state ) {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/settings/mirage", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array ( "value" => $state ? "on" : "off" ) );
			return $api->resolve ( $endpoint );
		}

	}
