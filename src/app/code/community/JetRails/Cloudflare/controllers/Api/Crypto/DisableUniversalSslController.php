<?php

	class JetRails_Cloudflare_Api_Crypto_DisableUniversalSslController
	extends JetRails_Cloudflare_Controller_Action {

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_disableUniversalSsl");
			$response = $api->getValue ();
			return $this->_sendResponse ( $response );
		}

		public function toggleAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_disableUniversalSsl");
			$response = $api->setValue (
				$this->_request->getParam ("value")
				// $this->_request->getParam ("value") == "true"
			);
			return $this->_sendResponse ( $response );
		}

	}
