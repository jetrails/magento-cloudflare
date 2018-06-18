<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_MinimumTlsVersion
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/min_tls_version";
		protected $_dataKey = "value";
		protected $_isNumeric = self::TYPE_STRING;

	}
