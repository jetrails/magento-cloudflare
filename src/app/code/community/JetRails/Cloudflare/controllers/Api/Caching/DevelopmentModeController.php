<?php

	class JetRails_Cloudflare_Api_Caching_DevelopmentModeController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/caching/development_mode");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_caching_developmentMode");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function toggleAction () {
			$api = Mage::getModel ("cloudflare/api_caching_developmentMode");
			$response = $api->toggle ( $this->_request->getParam ("state") === "true" );
			return $this->_formatAndSend ( $response );
		}

	}
