<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_HttpStrictTransportSecurity
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Getter {

		protected $_endpoint = "settings/security_header";

		public function setValue ( $conf ) {
			$conf = array (
				"enabled" => $conf ["enabled"] === "true",
				"max_age" => intval ( $conf ["max_age"] ),
				"include_subdomains" => $conf ["include_subdomains"] === "true",
				"preload" => $conf ["preload"] === "true",
				"nosniff" => $conf ["nosniff"] === "true"
			);
			$endpoint = $this->getEndpoint ();
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array ( "value" => array (
				"strict_transport_security" => $conf
			)));
			return $api->resolve ( $endpoint );
		}

	}
