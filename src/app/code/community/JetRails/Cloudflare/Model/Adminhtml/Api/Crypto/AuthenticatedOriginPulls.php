<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_AuthenticatedOriginPulls
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		protected $_endpoint = "settings/tls_client_auth";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
