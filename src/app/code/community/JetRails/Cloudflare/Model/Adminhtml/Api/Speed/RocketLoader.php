<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Speed_RocketLoader
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/rocket_loader";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
