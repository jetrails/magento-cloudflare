<?php

	class JetRails_Cloudflare_Api_Crypto_DisableUniversalSslController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/crypto/disable_universal_ssl");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_disableUniversalSsl");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function changeAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_disableUniversalSsl");
			$response = $api->change (
				$this->_request->getParam ("value") == "true"
			);
			return $this->_formatAndSend ( $response );
		}

	}
