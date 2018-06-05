<?php

	class JetRails_Cloudflare_Api_Crypto_MinimumTlsVersionController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/crypto/minimum_tls_version");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_minimumTlsVersion");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function changeAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_minimumTlsVersion");
			$response = $api->change (
				$this->_request->getParam ("value")
			);
			return $this->_formatAndSend ( $response );
		}

	}
