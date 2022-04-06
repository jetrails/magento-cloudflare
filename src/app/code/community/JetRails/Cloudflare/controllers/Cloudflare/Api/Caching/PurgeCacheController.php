<?php

	/**
	 * This controller has two endpoints. One is used to send an API call to
	 * Cloudflare and it purges all the cache for the current domain. The other
	 * endpoint asks the Cloudflare API to purge certain files from a zone.
	 * @version     1.2.7
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Cloudflare_Api_Caching_PurgeCacheController
	extends JetRails_Cloudflare_Controller_Action {

		/**
		 * This helper method simply looks if the response is successful and it
		 * appends a success message to the response that Cloudflare fails to
		 * attach.
		 * @return  void
		 */
		private function _handleResponse ( $response ) {
			if ( isset ( $response->success ) && $response->success ) {
				$response->messages = array_merge (
					array (
						"Successfully purged all assets. Please allow up to " .
						"30 seconds for changes to take effect."
					),
					$response->messages
				);
			}
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action simply triggers the Cloudflare API to purge all the cache
		 * related to the zone.
		 * @return  void
		 */
		public function everythingAction () {
			$api = Mage::getModel ("cloudflare/api_caching_purgeCache");
			$response = $api->purgeEverything ();
			return $this->_handleResponse ( $response );
		}

		/**
		 * This action simply triggers the Cloudflare API to purge all the cache
		 * related that matches a passed list of urls.
		 * @return  void
		 */
		public function urlAction () {
			$api = Mage::getModel ("cloudflare/api_caching_purgeCache");
			$items = $this->_request->getParam ("items");
			$response = $api->purgeUrls ( $items );
			return $this->_handleResponse ( $response );
		}

		/**
		 * This action simply triggers the Cloudflare API to purge all the cache
		 * related that matches a passed list of hostnames.
		 * @return  void
		 */
		public function hostnameAction () {
			$api = Mage::getModel ("cloudflare/api_caching_purgeCache");
			$items = $this->_request->getParam ("items");
			$response = $api->purgeHosts ( $items );
			return $this->_handleResponse ( $response );
		}

		/**
		 * This action simply triggers the Cloudflare API to purge all the cache
		 * related that matches a passed list of tags.
		 * @return  void
		 */
		public function tagAction () {
			$api = Mage::getModel ("cloudflare/api_caching_purgeCache");
			$items = $this->_request->getParam ("items");
			$response = $api->purgeTags ( $items );
			return $this->_handleResponse ( $response );
		}

		/**
		 * This action simply triggers the Cloudflare API to purge all the cache
		 * related that matches a passed list of prefixes.
		 * @return  void
		 */
		public function prefixAction () {
			$api = Mage::getModel ("cloudflare/api_caching_purgeCache");
			$items = $this->_request->getParam ("items");
			$response = $api->purgePrefixes ( $items );
			return $this->_handleResponse ( $response );
		}

	}
