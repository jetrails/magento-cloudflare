<?php

	class JetRails_Cloudflare_Api_Firewall_AccessRulesController extends JetRails_Cloudflare_Controller_Action {

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_accessRules");
			$response = $api->load ();
			return $this->_sendResponse ( $response );
		}

		public function deleteAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_accessRules");
			$response = $api->delete (
				$this->_request->getParam ("id")
			);
			return $this->_sendResponse ( $response );
		}

		public function addAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_accessRules");
			$response = $api->add (
				$this->_request->getParam ("target"),
				$this->_request->getParam ("value"),
				$this->_request->getParam ("mode"),
				$this->_request->getParam ("note")
			);
			return $this->_sendResponse ( $response );
		}

		public function modeAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_accessRules");
			$response = $api->updateMode (
				$this->_request->getParam ("id"),
				$this->_request->getParam ("mode")
			);
			return $this->_sendResponse ( $response );
		}

		public function editAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_accessRules");
			$response = $api->updateNote (
				$this->_request->getParam ("id"),
				$this->_request->getParam ("note")
			);
			return $this->_sendResponse ( $response );
		}

	}
