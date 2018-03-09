<?php

	class JetRails_Cloudflare_Api_Overview_StatusController extends JetRails_Cloudflare_Controller_ApiAction {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare/overview/status");
		}

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_overview_status");
			$response = $api->getStatus ();
			return $this->_formatAndSend ( $response );
		}

		public function pauseAction () {
			$api = Mage::getModel ("cloudflare/api_overview_status");
			$response = $api->setPaused ( true );
			return $this->_formatAndSend ( $response );
		}

		public function resumeAction () {
			$api = Mage::getModel ("cloudflare/api_overview_status");
			$response = $api->setPaused ( false );
			return $this->_formatAndSend ( $response );
		}

	}
