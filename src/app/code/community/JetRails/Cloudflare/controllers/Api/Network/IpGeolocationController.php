<?php

	class JetRails_Cloudflare_Api_Network_IpGeolocationController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/network/ip_geolocation");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_network_ipGeolocation");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		public function toggleAction () {
			$api = Mage::getModel ("cloudflare/api_network_ipGeolocation");
			$response = $api->toggle (
				$this->_request->getParam ("state") === "true"
			);
			return $this->_formatAndSend ( $response );
		}

	}
