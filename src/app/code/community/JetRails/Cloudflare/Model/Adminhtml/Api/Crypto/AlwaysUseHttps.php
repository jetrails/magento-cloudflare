<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_AlwaysUseHttps
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/always_use_https";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
