<?php

	class JetRails_Cloudflare_Model_Adminhtml_Api_Firewall_ChallengePassage
	extends JetRails_Cloudflare_Model_Adminhtml_Api_Generic_Setting {

		protected $_endpointPostfix = "challenge_ttl";
		protected $_isNumeric = self::TYPE_INTEGER;

	}
