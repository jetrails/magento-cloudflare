<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Caching_CachingLevel
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		protected $_endpoint = "settings/cache_level";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_STRING;

	}
