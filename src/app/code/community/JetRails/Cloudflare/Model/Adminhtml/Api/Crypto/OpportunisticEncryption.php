<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_OpportunisticEncryption
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		protected $_endpoint = "settings/opportunistic_encryption";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
