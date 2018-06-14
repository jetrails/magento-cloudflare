<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_AlwaysUseHttps
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Setting {

		protected $_endpointPostfix = "always_use_https";
		protected $_settingType = self::TYPE_BOOLEAN;

	}
