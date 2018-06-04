<?php

	class JetRails_Cloudflare_Api_Caching_BrowserCacheExpirationController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/caching/browser_cache_expiration");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_caching_browserCacheExpiration");
			$response = $api->getValue ();
			return $this->_sendResponse ( $response );
		}

		public function updateAction () {
			$api = Mage::getModel ("cloudflare/api_caching_browserCacheExpiration");
			$response = $api->setValue (
				$this->_request->getParam ("value")
			);
			return $this->_sendResponse ( $response );
		}

	}
