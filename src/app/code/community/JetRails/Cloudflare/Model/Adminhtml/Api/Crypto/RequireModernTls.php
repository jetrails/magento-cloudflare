<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_RequireModernTls
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Setting {

		protected $_endpointPostfix = "tls_1_2_only";
		protected $_settingType = self::TYPE_BOOLEAN;

	}
