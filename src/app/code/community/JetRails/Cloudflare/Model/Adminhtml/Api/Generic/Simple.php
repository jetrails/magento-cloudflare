<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple
	extends Mage_Core_Model_Abstract {

		const TYPE_BOOLEAN = 0;
		const TYPE_SWITCH  = 1;
		const TYPE_INTEGER = 2;
		const TYPE_STRING  = 3;

		protected $_endpoint = "settings";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_STRING;

		protected function _castValue ( $value ) {
			switch ( $this->_settingType ) {
				case self::TYPE_BOOLEAN: return $value == "true" ? true : false;
				case self::TYPE_SWITCH:  return $value ? "on" : "off";
				case self::TYPE_INTEGER: return intval ( $value );
				case self::TYPE_STRING:  return "$value";
				default: 				 return "";
			}
		}

		public function getValue () {
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/%s", $zoneId, $this->_endpoint );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_GET );
			return $api->resolve ( $endpoint );
		}

		public function setValue ( $value ) {
			$value = $this->_castValue ( $value );
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/%s", $zoneId, $this->_endpoint );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $api::REQUEST_PATCH );
			$api->setData ( array ( "$this->_dataKey" => $value ) );
			return $api->resolve ( $endpoint );
		}

	}
