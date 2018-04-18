<?php

	class JetRails_Cloudflare_Api_Crypto_Tls13Controller extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/crypto/tls_13");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_tls13");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function changeAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_tls13");
			$response = $api->change (
				$this->_request->getParam ("value")
			);
			return $this->_formatAndSend ( $response );
		}

	}
