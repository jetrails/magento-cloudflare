<?php

	class JetRails_Cloudflare_Api_Speed_PolishController
	extends JetRails_Cloudflare_Controller_Action {

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_speed_polish");
			$responseValue = $api->getValue ();
			$responseWebP = $api->getWebP ();
			return $this->_sendResponse ( array (
				"state" => $responseValue,
				"webp" => $responseWebP
			));
		}

		public function changeAction () {
			$api = Mage::getModel ("cloudflare/api_speed_polish");
			$response = $api->change (
				$this->_request->getParam ("value"),
				$this->_request->getParam ("webp") === "true"
			);
			return $this->_sendResponse ( $response );
		}

	}
