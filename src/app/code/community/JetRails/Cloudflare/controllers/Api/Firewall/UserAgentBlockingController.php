<?php

	class JetRails_Cloudflare_Api_Firewall_UserAgentBlockingController extends JetRails_Cloudflare_Controller_Action {

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_userAgentBlocking");
			$response = $api->load ();
			return $this->_sendResponse ( $response );
		}

		public function deleteAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_userAgentBlocking");
			$response = $api->delete (
				$this->_request->getParam ("id")
			);
			return $this->_sendResponse ( $response );
		}

		public function createAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_userAgentBlocking");
			$response = $api->create (
				$this->_request->getParam ("mode"),
				$this->_request->getParam ("paused") == "true",
				$this->_request->getParam ("value"),
				$this->_request->getParam ("description")
			);
			return $this->_sendResponse ( $response );
		}

		public function editAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_userAgentBlocking");
			$response = $api->update (
				$this->_request->getParam ("id"),
				$this->_request->getParam ("mode"),
				$this->_request->getParam ("paused") == "true",
				$this->_request->getParam ("value"),
				$this->_request->getParam ("description")
			);
			return $this->_sendResponse ( $response );
		}

		public function modeAction () {
			return $this->modeAction ();
		}

		public function toggleAction () {
			return $this->modeAction ();
		}

		public function pauseAction () {
			return $this->modeAction ();
		}

	}


?>
