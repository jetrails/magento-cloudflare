<?php

	class JetRails_Cloudflare_Api_Firewall_SecurityLevelController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/firewall/security_level");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_securityLevel");
			$response = $api->getValue ();
			return $this->_sendResponse ( $response );
		}

		public function updateAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_securityLevel");
			$response = $api->setValue (
				$this->_request->getParam ("value")
			);
			return $this->_sendResponse ( $response );
		}

	}
