<?php

	class JetRails_Cloudflare_Api_Network_PseudoIpv4Controller extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/network/pseudo_ipv4");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_network_pseudoIpv4");
			$response = $api->getValue ();
			return $this->_sendResponse ( $response );
		}

		public function updateAction () {
			$api = Mage::getModel ("cloudflare/api_network_pseudoIpv4");
			$response = $api->setValue (
				$this->_request->getParam ("value")
			);
			return $this->_sendResponse ( $response );
		}

	}
