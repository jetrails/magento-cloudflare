<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_AutomaticHttpsRewrites
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/automatic_https_rewrites";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
