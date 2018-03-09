<?php

	class JetRails_Cloudflare_DebugController extends Mage_Adminhtml_Controller_Action {

		public function indexAction () {
			echo "<pre>";
			var_dump ( Mage::getStoreConfig ("cloudflare/configuration/auth_email") );
		}

	}
