<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_RequireModernTls
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		protected $_endpoint = "settings/tls_1_2_only";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
