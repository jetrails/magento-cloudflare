<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_AuthenticatedOriginPulls
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/tls_client_auth";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
