<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Firewall_SecurityLevel
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Setting {

		protected $_endpointPostfix = "security_level";
		protected $_isNumeric = self::TYPE_STRING;

	}
