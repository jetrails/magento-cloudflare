<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Crypto_AuthenticatedOriginPulls
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Setting {

		protected $_endpointPostfix = "tls_client_auth";
		protected $_settingType = self::TYPE_BOOLEAN;

	}
