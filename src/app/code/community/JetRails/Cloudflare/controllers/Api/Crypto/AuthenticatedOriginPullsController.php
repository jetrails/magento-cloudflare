<?php

	class JetRails_Cloudflare_Api_Crypto_AuthenticatedOriginPullsController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/crypto/authenticated_origin_pulls");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_authenticatedOriginPulls");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function toggleAction () {
			$api = Mage::getModel ("cloudflare/api_crypto_authenticatedOriginPulls");
			$response = $api->toggle (
				$this->_request->getParam ("state") === "true"
			);
			return $this->_formatAndSend ( $response );
		}

	}
