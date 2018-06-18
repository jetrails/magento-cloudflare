<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_ScrapeShield_HotlinkProtection
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/hotlink_protection";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
