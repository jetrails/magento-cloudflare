<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_MinimumTlsVersion
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Setting {

		protected $_endpointPostfix = "min_tls_version";
		protected $_isNumeric = self::TYPE_STRING;

	}
