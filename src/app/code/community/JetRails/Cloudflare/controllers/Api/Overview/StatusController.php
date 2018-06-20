<?php

	class JetRails_Cloudflare_Api_Overview_StatusController
	extends JetRails_Cloudflare_Controller_Action {

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_overview_status");
			$response = $api->getValue ();
			return $this->_sendResponse ( $response );
		}

		public function pauseAction () {
			$api = Mage::getModel ("cloudflare/api_overview_status");
			$response = $api->setValue ( true );
			return $this->_sendResponse ( $response );
		}

		public function resumeAction () {
			$api = Mage::getModel ("cloudflare/api_overview_status");
			$response = $api->setValue ( false );
			return $this->_sendResponse ( $response );
		}

	}
