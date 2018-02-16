<?php

	class JetRails_Cloudflare_DashboardController extends Mage_Adminhtml_Controller_Action {

		/**
		 * This method simply asks Magento's ACL if the logged in user is allowed to see the
		 * configure page that belongs to this module.
		 * @return      boolean                                 Is the user allowed to see page?
		 */
		protected function _isAllowed () {
			// Is user allowed to manage 2FA accounts?
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare");
		}

		public function indexAction () {
			$data = array (
				"error" => "Some error message",
				"payload" => null
			);
			$this->getResponse ()->setHeader ( "Content-type", "application/json" );
			$this->getResponse ()->setBody ( json_encode ( $data ) );
		}

	}
