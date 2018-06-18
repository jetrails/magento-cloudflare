<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Caching_DevelopmentMode
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/development_mode";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
