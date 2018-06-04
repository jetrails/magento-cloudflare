<?php

	class JetRails_Cloudflare_Api_Firewall_ChallengePassageController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/firewall/challenge_passage");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_challengePassage");
			$response = $api->getValue ();
			return $this->_sendResponse ( $response );
		}

		public function updateAction () {
			$api = Mage::getModel ("cloudflare/api_firewall_challengePassage");
			$response = $api->setValue (
				$this->_request->getParam ("value")
			);
			return $this->_sendResponse ( $response );
		}

	}
