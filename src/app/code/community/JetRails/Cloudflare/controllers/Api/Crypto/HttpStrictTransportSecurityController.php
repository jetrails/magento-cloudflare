<?php

	class JetRails_Cloudflare_Api_Crypto_HttpStrictTransportSecurityController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/crypto/http_strict_transport_security");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_httpStrictTransportSecurity");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function configureAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_httpStrictTransportSecurity");
			$response = $api->configure (
				$this->_request->getParam ("strict_transport_security")
			);
			return $this->_formatAndSend ( $response );
		}

	}
