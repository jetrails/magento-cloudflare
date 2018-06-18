<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Caching_AlwaysOnline
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/always_online";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
