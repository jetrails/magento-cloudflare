<?php

	/**
	 * This controller inherits from a generic controller that implements the
	 * base functionality for interfacing with a getter model. This action
	 * simply loads the initial value through the Cloudflare API. The rest of
	 * this class extends on that functionality and adds more endpoints.
	 * @version     1.2.2
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Cloudflare_Api_Overview_StatusController
	extends JetRails_Cloudflare_Controller_Getter {

		/**
		 * This action simply asks the Cloudflare API model to pause the site
		 * based on the currently selected zone.
		 * @return  void
		 */
		public function pauseAction () {
			$api = Mage::getModel ("cloudflare/api_overview_status");
			$response = $api->setValue ( true );
			return $this->_sendResponse ( $response );
		}

		/**
		 * This action simply asks the Cloudflare API model to resume the site
		 * based on the currently selected zone.
		 * @return  void
		 */
		public function resumeAction () {
			$api = Mage::getModel ("cloudflare/api_overview_status");
			$response = $api->setValue ( false );
			return $this->_sendResponse ( $response );
		}

	}
