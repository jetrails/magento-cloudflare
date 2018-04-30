<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_ScrapeShield_HotlinkProtection extends Mage_Core_Model_Abstract {

		public function getValue () {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/settings/hotlink_protection", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

		public function toggle ( $state ) {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/settings/hotlink_protection", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array ( "value" => $state ? "on" : "off" ) );
			return $api->resolve ( $endpoint );
		}

	}
