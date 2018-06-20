<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_AlwaysUseHttps
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		protected $_endpoint = "settings/always_use_https";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
