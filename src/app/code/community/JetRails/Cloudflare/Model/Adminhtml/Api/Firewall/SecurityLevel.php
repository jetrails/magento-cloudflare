<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Firewall_SecurityLevel
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/security_level";
		protected $_dataKey = "value";
		protected $_isNumeric = self::TYPE_STRING;

	}
