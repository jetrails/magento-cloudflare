<?php

	class JetRails_Cloudflare_Api_Speed_PolishController extends JetRails_Cloudflare_Controller_ApiAction {

		function indexAction () {
			$api = Mage::getModel ("cloudflare/api_speed_polish");
			$responseValue = $api->getValue ();
			$responseWebP = $api->getWebP ();
			return $this->_sendResponse ( array (
				"state" => $this->_format ( $responseValue ),
				"webp" => $this->_format ( $responseWebP )
			));
		}

		function changeAction () {
			$api = Mage::getModel ("cloudflare/api_speed_polish");
			$response = $api->change ( $this->_request->getParam ("value") );
			return $this->_formatAndSend ( $response );
		}

	}
