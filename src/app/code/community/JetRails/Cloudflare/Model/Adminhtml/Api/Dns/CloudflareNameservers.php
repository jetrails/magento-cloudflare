<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Dns_CloudflareNameservers
	extends Mage_Core_Model_Abstract {

		public function getNameservers () {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			$response = $api->resolve ( $endpoint );
			if ( $response->success ) $response->result = $response->result->name_servers;
			return $response;
		}

	}
