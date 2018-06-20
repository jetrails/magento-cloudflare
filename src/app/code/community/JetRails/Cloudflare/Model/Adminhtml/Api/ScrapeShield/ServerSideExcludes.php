<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_ScrapeShield_ServerSideExcludes
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		protected $_endpoint = "settings/server_side_exclude";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
