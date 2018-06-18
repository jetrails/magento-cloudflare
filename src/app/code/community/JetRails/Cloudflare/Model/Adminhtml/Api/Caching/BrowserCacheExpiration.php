<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Caching_BrowserCacheExpiration
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/browser_cache_ttl";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_INTEGER;

	}
