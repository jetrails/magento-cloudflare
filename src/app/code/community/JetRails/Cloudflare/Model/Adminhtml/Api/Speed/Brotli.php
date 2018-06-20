<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Speed_Brotli
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		protected $_endpoint = "settings/brotli";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
