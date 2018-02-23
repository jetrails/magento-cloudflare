<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Speed_AutoMinify extends Mage_Core_Model_Abstract {

		public function getValue () {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/settings/minify", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

		public function change ( $js, $css, $html ) {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/settings/minify", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array ( "value" => array (
				"js" => $js == "true" ? "on" : "off",
				"css" => $css == "true" ? "on" : "off",
				"html" => $html == "true" ? "on" : "off"
			)));
			return $api->resolve ( $endpoint );
		}

	}
