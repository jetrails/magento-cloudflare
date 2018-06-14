<?php

	class JetRails_Cloudflare_Api_Caching_PurgeCacheController
	extends JetRails_Cloudflare_Controller_Action {

		public function everythingAction () {
			$api = Mage::getModel ("cloudflare/api_caching_purgeCache");
			$response = $api->purgeEverything ();
			if ( $response->success ) {
				$response->messages = array_merge (
					["Successfully purged all assets. Please allow up to 30 seconds for changes to take effect."],
					$response->messages
				);
			}
			return $this->_sendResponse ( $response );
		}

		public function individualAction () {
			$api = Mage::getModel ("cloudflare/api_caching_purgeCache");
			$response = $api->purgeIndividual ( $this->_request->getParam ("files") );
			if ( $response->success ) {
				$response->messages = array_merge (
					["Successfully purged assets. Please allow up to 30 seconds for changes to take effect."],
					$response->messages
				);
			}
			return $this->_sendResponse ( $response );
		}

	}
