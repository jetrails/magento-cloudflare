<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Firewall_ChallengePassage
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Simple {

		protected $_endpoint = "settings/challenge_ttl";
		protected $_dataKey = "value";
		protected $_isNumeric = self::TYPE_INTEGER;

	}
