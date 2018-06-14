<?php

	class JetRails_Cloudflare_Api_Speed_AutoMinifyController
	extends JetRails_Cloudflare_Controller_Action {

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_speed_autoMinify");
			$response = $api->getValue ();
			return $this->_sendResponse ( $response );
		}

		public function changeAction () {
			$api = Mage::getModel ("cloudflare/api_speed_autoMinify");
			$response = $api->change (
				$this->_request->getParam ("js"),
				$this->_request->getParam ("css"),
				$this->_request->getParam ("html")
			);
			return $this->_sendResponse ( $response );
		}

	}
