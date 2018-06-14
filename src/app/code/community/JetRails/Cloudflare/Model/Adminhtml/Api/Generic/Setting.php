<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Setting
	extends Mage_Core_Model_Abstract {

		const TYPE_BOOLEAN = 0;
		const TYPE_INTEGER = 1;
		const TYPE_STRING  = 2;

		protected $_endpointPostfix = "";
		protected $_settingType = self::TYPE_STRING;

		protected function _castValue ( $value ) {
			switch ( $this->_settingType ) {
				case self::TYPE_BOOLEAN: return $value ? "on" : "off";
				case self::TYPE_INTEGER: return intval ( $value );
				case self::TYPE_STRING:  return "$value";
				default: 				 return "";
			}
		}

		public function getValue () {
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/settings/$this->_endpointPostfix", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

		public function setValue ( $value ) {
			$value = $this->_castValue ( $value );
			$zoneId = Mage::getModel ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/settings/$this->_endpointPostfix", $zoneId );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array ( "value" => $value ) );
			return $api->resolve ( $endpoint );
		}

	}
