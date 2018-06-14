<?php

	class JetRails_Cloudflare_Api_Caching_CachingLevelController
	extends JetRails_Cloudflare_Controller_Action {

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_caching_cachingLevel");
			$response = $api->getValue ();
			return $this->_sendResponse ( $response );
		}

		public function changeAction () {
			$api = Mage::getModel ("cloudflare/api_caching_cachingLevel");
			$response = $api->setValue ( $this->_request->getParam ("value") );
			return $this->_sendResponse ( $response );
		}

	}
