<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Caching_DevelopmentMode
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Setting {

		protected $_endpointPostfix = "development_mode";
		protected $_settingType = self::TYPE_BOOLEAN;

	}
