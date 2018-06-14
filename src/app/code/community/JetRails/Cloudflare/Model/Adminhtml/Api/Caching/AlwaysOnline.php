<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Caching_AlwaysOnline
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Setting {

		protected $_endpointPostfix = "always_online";
		protected $_settingType = self::TYPE_BOOLEAN;

	}
