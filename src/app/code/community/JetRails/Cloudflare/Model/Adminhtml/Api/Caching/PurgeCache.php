<?php

	/**
	 * This model is communicates with the Cloudflare API. It particular, it
	 * uses certain endpoints to purge everything that is related to a certain
	 * zone and it also asks the Cloudflare API to purge the cache for an array
	 * of specific URLs.
	 * @version     1.3.0
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
			$api->setPayload ( array ( "purge_everything" => true ) );
			return $api->resolve ( $endpoint );
		}

		/**
		 * Given a list of items, ask Cloudflare to purge cache that matches the
		 * list of urls.
		 * @param   array        items                Items to purge
		 * @return  stdClass                          Cloudflare response
		 */
		public function purgeUrls ( $items ) {
			$modelPath = "cloudflare/api_overview_configuration";
			$zoneId = Mage::getSingleton ("$modelPath")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/purge_cache", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			$api->setPayload ( array ( "files" => $items ) );
			return $api->resolve ( $endpoint );
		}

		/**
		 * Given a list of items, ask Cloudflare to purge cache that matches the
		 * list of hostnames.
		 * @param   array        items                Items to purge
		 * @return  stdClass                          Cloudflare response
		 */
		public function purgeHosts ( $items ) {
			$modelPath = "cloudflare/api_overview_configuration";
			$zoneId = Mage::getSingleton ("$modelPath")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/purge_cache", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			$api->setPayload ( array ( "hosts" => $items ) );
			return $api->resolve ( $endpoint );
		}

		/**
		 * Given a list of items, ask Cloudflare to purge cache that matches the
		 * list of tags.
		 * @param   array        items                Items to purge
		 * @return  stdClass                          Cloudflare response
		 */
		public function purgeTags ( $items ) {
			$modelPath = "cloudflare/api_overview_configuration";
			$zoneId = Mage::getSingleton ("$modelPath")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/purge_cache", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			$api->setPayload ( array ( "tags" => $items ) );
			return $api->resolve ( $endpoint );
		}

		/**
		 * Given a list of items, ask Cloudflare to purge cache that matches the
		 * list of prefixes.
		 * @param   array        items                Items to purge
		 * @return  stdClass                          Cloudflare response
		 */
		public function purgePrefixes ( $items ) {
			$modelPath = "cloudflare/api_overview_configuration";
			$zoneId = Mage::getSingleton ("$modelPath")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/purge_cache", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_DELETE );
			$api->setPayload ( array ( "prefixes" => $items ) );
			return $api->resolve ( $endpoint );
		}

	}
