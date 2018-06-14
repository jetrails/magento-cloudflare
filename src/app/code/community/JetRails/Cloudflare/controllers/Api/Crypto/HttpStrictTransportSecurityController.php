<?php

	class JetRails_Cloudflare_Api_Crypto_HttpStrictTransportSecurityController
	extends JetRails_Cloudflare_Controller_Action {

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_httpStrictTransportSecurity");
			$response = $api->getValue ();
			return $this->_sendResponse ( $response );
		}

		public function configureAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_httpStrictTransportSecurity");
			$response = $api->configure (
				$this->_request->getParam ("strict_transport_security")
			);
			return $this->_sendResponse ( $response );
		}

	}
