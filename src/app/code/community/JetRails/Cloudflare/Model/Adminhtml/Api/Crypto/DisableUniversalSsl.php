<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_DisableUniversalSsl
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		protected $_endpoint = "ssl/universal/settings";
		protected $_dataKey = "enabled";
		protected $_settingType = self::TYPE_BOOLEAN;

	}
