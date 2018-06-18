<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Network_IpGeolocation
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/ip_geolocation";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
