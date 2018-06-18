<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Caching_CachingLevel
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/cache_level";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_STRING;

	}
