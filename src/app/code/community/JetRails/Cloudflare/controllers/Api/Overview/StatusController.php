<?php

	class JetRails_Cloudflare_Api_Overview_StatusController extends JetRails_Cloudflare_Controller_ApiAction {

		function indexAction () {
			$api = Mage::getModel ("cloudflare/api_overview_status");
			$response = $api->getStatus ();
			return $this->_formatAndSend ( $response );
		}

		function pauseAction () {
			$api = Mage::getModel ("cloudflare/api_overview_status");
			$response = $api->setPaused ( true );
			return $this->_formatAndSend ( $response );
		}

		function resumeAction () {
			$api = Mage::getModel ("cloudflare/api_overview_status");
			$response = $api->setPaused ( false );
			return $this->_formatAndSend ( $response );
		}

	}
