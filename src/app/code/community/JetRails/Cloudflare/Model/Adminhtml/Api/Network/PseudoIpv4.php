<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Network_PseudoIpv4
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/pseudo_ipv4";
		protected $_isNumeric = self::TYPE_STRING;

	}
