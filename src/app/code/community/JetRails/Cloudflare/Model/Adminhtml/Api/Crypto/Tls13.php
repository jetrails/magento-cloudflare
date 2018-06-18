<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_Tls13
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/tls_1_3";
		protected $_dataKey = "value";
		protected $_isNumeric = self::TYPE_STRING;

	}
