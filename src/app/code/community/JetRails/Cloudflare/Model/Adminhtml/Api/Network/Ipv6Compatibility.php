<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Network_Ipv6Compatibility
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/ipv6";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
