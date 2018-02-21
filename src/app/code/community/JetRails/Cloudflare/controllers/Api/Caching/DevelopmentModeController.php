<?php

	class JetRails_Cloudflare_Api_Caching_DevelopmentModeController extends JetRails_Cloudflare_Controller_ApiAction {

		function indexAction () {
			$api = Mage::getModel ("cloudflare/api_caching_developmentmode");
			$response = $api->getValue ();
			return $this->_formatAndSend ( $response );
		}

		function toggleAction () {
			$api = Mage::getModel ("cloudflare/api_caching_developmentmode");
			$response = $api->toggle ( $this->_request->getParam ("state") === "true" );
			return $this->_formatAndSend ( $response );
		}

	}
