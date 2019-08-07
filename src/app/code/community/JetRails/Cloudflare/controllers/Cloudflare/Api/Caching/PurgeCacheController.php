<?php

	/**
	 * This controller has two endpoints. One is used to send an API call to
	 * Cloudflare and it purges all the cache for the current domain. The other
	 * endpoint asks the Cloudflare API to purge certain files from a zone.
	 * @version     1.1.0
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Cloudflare_Api_Caching_PurgeCacheController
	extends JetRails_Cloudflare_Controller_Action {

		/**
		 * This action simply triggers the Cloudflare API to purge all the cache
		 * related to the zone.
		 * @return 	void
		 */
		public function everythingAction () {
			$api = Mage::getModel ("cloudflare/api_caching_purgeCache");
			$response = $api->purgeEverything ();
			if ( $response->success ) {
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
		 * This action takes in a list of files from the 'files' parameter and
		 * it asks the Cloudflare API to purge the cache related to said files.
		 * @return 	void
		 */
		public function individualAction () {
			$api = Mage::getModel ("cloudflare/api_caching_purgeCache");
			$files = $this->_request->getParam ("files");
			$response = $api->purgeIndividual ( $files );
			if ( $response->success ) {
				$response->messages = array_merge (
					array (
						"Successfully purged assets. Please allow up to 30 " .
						"seconds for changes to take effect."
					),
					$response->messages
				);
			}
			return $this->_sendResponse ( $response );
		}

	}
