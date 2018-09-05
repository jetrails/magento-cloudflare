<?php

	/**
	 * This model is communicates with the Cloudflare API. It particular, it
	 * uses certain endpoints to purge everything that is related to a certain
	 * zone and it also asks the Cloudflare API to purge the cache for an array
	 * of specific URLs.
	 * @version     1.0.3
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Caching_PurgeCache
	extends Mage_Core_Model_Abstract {

		/**
		 * This method asks the Cloudflare API to purge all the cache that is
		 * associated with the currently selected zone.
		 * @return  stdClass                          Cloudflare response
		 */
		public function purgeEverything () {
			$modelPath = "cloudflare/api_overview_configuration";
			$zoneId = Mage::getSingleton ("$modelPath")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/purge_cache", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			$api->setData ( array ( "purge_everything" => true ) );
			return $api->resolve ( $endpoint );
		}

		/**
		 * This method asks the Cloudflare API to purge all the cache in the
		 * currently selected zone and that match any of the URLs found in the
		 * passed array.
		 * @param   array        urls                 URLs to purge in zone
		 * @return  stdClass                          Cloudflare response
		 */
		public function purgeIndividual ( $urls ) {
			$modelPath = "cloudflare/api_overview_configuration";
			$zoneId = Mage::getSingleton ("$modelPath")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/purge_cache", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			$api->setData ( array ( "files" => $urls ) );
			return $api->resolve ( $endpoint );
		}

	}
