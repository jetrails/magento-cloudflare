<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Network_PseudoIpv4
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		protected $_endpoint = "settings/pseudo_ipv4";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_STRING;

	}
