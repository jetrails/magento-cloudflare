<?php

	class JetRails_Cloudflare_Api_Dns_CloudflareNameserversController
	extends JetRails_Cloudflare_Controller_Action {

		public function indexAction () {
			$api = Mage::getModel ("cloudflare/api_dns_cloudflareNameservers");
			$response = $api->getNameservers ();
			return $this->_sendResponse ( $response );
		}

	}
