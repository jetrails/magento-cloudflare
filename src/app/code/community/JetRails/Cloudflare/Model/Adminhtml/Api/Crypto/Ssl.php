<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_Ssl
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/ssl";
		protected $_dataKey = "value";
		protected $_isNumeric = self::TYPE_STRING;

	}
