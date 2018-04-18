<?php

	class JetRails_Cloudflare_Api_Crypto_AlwaysUseHttpsController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/crypto/always_use_https");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_alwaysUseHttps");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function toggleAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_alwaysUseHttps");
			$response = $api->toggle (
				$this->_request->getParam ("state") === "true"
			);
			return $this->_formatAndSend ( $response );
		}

	}
