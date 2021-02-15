<?php

	/**
	 * This model class inherits from the Setter model.  It essentially wraps
	 * that class in order to send passed data to the Cloudflare API endpoint.
	 * @version     1.2.2
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Speed_AutomaticPlatformOptimization
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		/**
		 * @var     string      _endpoint       Appended to zone endpoint
		 * @var     string      _dataKey        Key name used for value
		 * @var     integer     _settingType    Value cast type before sending
		 */
		protected $_endpoint = "settings/automatic_platform_optimization";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_BOOLEAN;

		/**
		 * This method takes in a value of mixed type and based on the setting
		 * type, that value is cast and sent though the Cloudflare API to be
		 * changed.
		 * @param   mixed        value                Value to pass to setting
		 */
		public function setValue ( $value ) {
			$value = $this->_castValue ( $value );
			$zoneId = Mage::getSingleton ("cloudflare/api_overview_configuration")->getZoneId ();
			$endpoint = sprintf ( "zones/%s/%s", $zoneId, $this->_endpoint );
			$api = Mage::getModel ("cloudflare/api_request");
			$api->setType ( $this->_usePatchToSet ? $api::REQUEST_PATCH : $api::REQUEST_PUT );
			$api->setPayload ( array ( "$this->_dataKey" => array ( "enabled" => $value ) ) );
			return $api->resolve ( $endpoint );
		}


	}
