<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_MinimumTlsVersion
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		protected $_endpoint = "settings/min_tls_version";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_STRING;

	}
