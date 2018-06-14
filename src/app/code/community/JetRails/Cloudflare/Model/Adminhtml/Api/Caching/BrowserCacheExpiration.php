<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Caching_BrowserCacheExpiration
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Setting {

		protected $_endpointPostfix = "browser_cache_ttl";
		protected $_settingType = self::TYPE_INTEGER;

	}
