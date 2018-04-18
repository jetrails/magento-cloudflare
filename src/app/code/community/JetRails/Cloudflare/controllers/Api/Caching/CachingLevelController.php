<?php

	class JetRails_Cloudflare_Api_Caching_CachingLevelController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/caching/caching_level");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_caching_cachingLevel");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function changeAction () {
			$api = Mage::getModel ("cloudflare/api_caching_cachingLevel");
			$response = $api->change ( $this->_request->getParam ("value") );
			return $this->_formatAndSend ( $response );
		}

	}
