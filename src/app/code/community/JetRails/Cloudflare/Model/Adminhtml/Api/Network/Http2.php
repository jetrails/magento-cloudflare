<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Network_Http2
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/http2";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_SWITCH;

	}
