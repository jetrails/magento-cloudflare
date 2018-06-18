<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_ScrapeShield_EmailAddressObfuscation
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/email_obfuscation";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
