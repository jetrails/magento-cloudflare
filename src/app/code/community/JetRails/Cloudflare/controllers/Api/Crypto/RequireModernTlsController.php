<?php

	class JetRails_Cloudflare_Api_Crypto_RequireModernTlsController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/crypto/require_modern_tls");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_requireModernTls");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function toggleAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_requireModernTls");
			$response = $api->toggle (
				$this->_request->getParam ("state") === "true"
			);
			return $this->_formatAndSend ( $response );
		}

	}
