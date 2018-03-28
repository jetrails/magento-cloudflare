<?php

	class JetRails_Cloudflare_Api_PageRules_PageRulesController extends JetRails_Cloudflare_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/page_rules/page_rules");
		}

		// public function indexAction () {
		// 	$api = Mage::getModel ("cloudflare/api_overview_status");
		// 	$response = $api->getStatus ();
		// 	return $this->_formatAndSend ( $response );
		// }

		public function createAction () {
			$api = Mage::getModel ("cloudflare/api_pageRules_pageRules");
			$response = $api->create (
				$this->_request->getParam ("target"),
				$this->_request->getParam ("actions"),
				$this->_request->getParam ("status") == "true"
			);
			return $this->_sendResponse ( $response );
			// return $this->_formatAndSend ( $response );
		}

	}
