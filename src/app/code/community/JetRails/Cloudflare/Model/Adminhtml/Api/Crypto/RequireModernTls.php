<?php

	/**
	 * This model class inherits from the Setter model.  It essentially wraps
	 * that class in order to send passed data to the Cloudflare API endpoint.
	 * @version     1.0.0
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 */
	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_RequireModernTls
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		/**
		 * @var     string      _endpoint       Appended to zone endpoint
		 * @var     string      _dataKey        Key name used for value
		 * @var     integer     _settingType    Value cast type before sending
		 */
		protected $_endpoint = "settings/tls_1_2_only";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
