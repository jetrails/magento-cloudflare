<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Speed_Polish
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Getter {

		protected $_endpoint = "settings/polish";

		public function getWebP () {
			$endpoint = $this->getEndpoint ("settings/webp");
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

		public function change ( $value, $webp ) {
			$endpoint = $this->getEndpoint ();
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array ( "value" => $value ) );
			$response = $api->resolve ( $endpoint );
			if ( $response->success && $value != "off" ) {
				$endpoint = sprintf ( "zones/%s/settings/webp", $zoneId );
				$api = Mage::getModel ("cloudflare/api_request");
				$api->setType ( $api::REQUEST_PATCH );
				$api->setData ( array ( "value" => $webp ? "on" : "off" ) );
				$response = $api->resolve ( $endpoint );
			}
			return $response;
		}

	}
