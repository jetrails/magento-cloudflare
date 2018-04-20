<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_HttpStrictTransportSecurity extends Mage_Core_Model_Abstract {

		public function getValue () {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/settings/security_header", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

		public function configure ( $config ) {
			$config ["enabled"] = $config ["enabled"] === "true";
			$config ["max_age"] = intval ( $config ["max_age"] );
			$config ["include_subdomains"] = $config ["include_subdomains"] === "true";
			$config ["preload"] = $config ["preload"] === "true";
			$config ["nosniff"] = $config ["nosniff"] === "true";
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/settings/security_header", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array ( "value" => array (
				"strict_transport_security" => $config
			)));
			return $api->resolve ( $endpoint );
		}

	}
