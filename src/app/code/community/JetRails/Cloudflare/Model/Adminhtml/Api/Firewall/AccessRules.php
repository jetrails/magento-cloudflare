<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Firewall_AccessRules extends Mage_Core_Model_Abstract {

		public function load ( $page, $perPage ) {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/firewall/access_rules/rules", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$api->setQuery ( "page", intval ( $page ) );
			$api->setQuery ( "per_page", intval ( $perPage ) );
			return $api->resolve ( $endpoint );
		}

	}
