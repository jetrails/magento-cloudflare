<?php

	class JetRails_Cloudflare_Api_Caching_PurgeCacheController extends JetRails_Cloudflare_Controller_ApiAction {

		function everythingAction () {
			$api = Mage::getModel ("cloudflare/api_caching_purgecache");
			$response = $api->purgeEverything ();
			return $this->_formatAndSend ( $response );
		}

		function individualAction () {
			$api = Mage::getModel ("cloudflare/api_caching_purgecache");
			$response = $api->purgeIndividual ( $this->_request->getParam ("files") );
			return $this->_formatAndSend ( $response );
		}

	}
