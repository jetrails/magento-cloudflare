<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Caching_PurgeCache extends Mage_Core_Model_Abstract {

		public function purgeEverything () {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/purge_cache", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			$api->setData ( array ( "purge_everything" => true ) );
			return $api->resolve ( $endpoint );
		}

		public function purgeIndividual ( $files ) {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/purge_cache", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			$api->setData ( array ( "files" => $files ) );
			return $api->resolve ( $endpoint );
		}

	}
