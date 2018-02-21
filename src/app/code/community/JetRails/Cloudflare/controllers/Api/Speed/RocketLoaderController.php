<?php

	class JetRails_Cloudflare_Api_Speed_RocketLoaderController extends JetRails_Cloudflare_Controller_ApiAction {

		function indexAction () {
			$api = Mage::getModel ("cloudflare/api_speed_rocketloader");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		function changeAction () {
			$api = Mage::getModel ("cloudflare/api_speed_rocketloader");
			$response = $api->change ( $this->_request->getParam ("value") );
			return $this->_formatAndSend ( $response );
		}

	}
