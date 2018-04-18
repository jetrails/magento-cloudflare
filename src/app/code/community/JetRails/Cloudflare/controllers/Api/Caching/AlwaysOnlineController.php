<?php

	class JetRails_Cloudflare_Api_Caching_AlwaysOnlineController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/caching/always_online");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_caching_alwaysOnline");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function toggleAction () {
			$api = Mage::getModel ("cloudflare/api_caching_alwaysOnline");
			$response = $api->toggle (
				$this->_request->getParam ("state") === "true"
			);
			return $this->_formatAndSend ( $response );
		}

	}
