<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Firewall_ChallengePassage
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Setter {

		protected $_endpoint = "settings/challenge_ttl";
		protected $_dataKey = "value";
		protected $_settingType = self::TYPE_INTEGER;

	}
