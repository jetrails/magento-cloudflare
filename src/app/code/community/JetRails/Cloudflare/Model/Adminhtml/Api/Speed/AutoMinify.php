<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Speed_AutoMinify
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Getter {

		protected $_endpoint = "settings/minify";

		public function change ( $js, $css, $html ) {
			$endpoint = $this->getEndpoint ();
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array ( "value" => array (
				"js" => $js == "true" ? "on" : "off",
				"css" => $css == "true" ? "on" : "off",
				"html" => $html == "true" ? "on" : "off"
			)));
			return $api->resolve ( $endpoint );
		}

	}
