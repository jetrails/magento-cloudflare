<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Getter
	extends Mage_Core_Model_Abstract {

		protected $_endpoint = "";

		protected function getEndpoint ( $endpoint = false ) {
			$endpoint = $endpoint ? $endpoint : $this->_endpoint;
			$cnf = Mage::getSingleton ("cloudflare/api_overview_configuration");
			$zoneId = $cnf->getZoneId ();
			return sprintf ( "zones/%s/%s", $zoneId, $endpoint );
		}

		public function getValue () {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/%s", $zoneId, $this->_endpoint );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

	}
