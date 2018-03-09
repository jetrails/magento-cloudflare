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
			// Set the title for the page
			$this->_title ( $this->__("JetRails") );
			$this->_title ( $this->__("Cloudflare") );
			$this->_title ( $this->__("Dashboard") );
			// Load layout, add the content, set active tab, and render layout
			$this->loadLayout ();
			$this->_initLayoutMessages ("admin/session");
			$this->_setActiveMenu ("jetrails/cloudflare");

			$data = Mage::helper ("cloudflare/data");
			$api = Mage::getSingleton ("cloudflare/api_overview_configuration");
			$validAuthentication = $api->validateAuth ();
			$zoneId = $api->getZoneId ();
			if ( $validAuthentication && !empty ( $zoneId ) ) {
				$this->_addContent ( $this->getLayout ()->createBlock ("cloudflare/dashboard_edit") )
					 ->_addLeft ( $this->getLayout ()->createBlock ("cloudflare/dashboard_edit_tabs") );
			}
			else if ( $validAuthentication ) {
				$domain = $data->getDomainName ();
				$this->_addContent (
					$this->getLayout ()
					->createBlock ("cloudflare/dashboard_section_overview_configuration")
					->setTemplate ("cloudflare/overview/configuration.phtml")
					->setState ("response_error")
					->setMessages ( array ( "Error : The domain <u>$domain</u> is not associated with your Cloudflare account" ) )
				);
			}
			else {
				$this->_addContent (
					$this->getLayout ()
					->createBlock ("cloudflare/dashboard_section_overview_configuration")
					->setTemplate ("cloudflare/overview/configuration.phtml")
					->setState ("response_error")
					->setMessages ( array ( "Error : Email address or API token could not be authenticated" ) )
				);
			}

			$this->renderLayout ();
		}

		public function saveAction () {
			$api = Mage::getSingleton ("cloudflare/api_overview_configuration");
			$data = Mage::helper ("cloudflare/data");

			$email = $this->getRequest ()->getPost ("email");
			$token = $this->getRequest ()->getPost ("token");

			$data->setAuthEmail ( $email );
			$data->setAuthToken ( $token );

			$this->_redirect ("*/*/index");
		}

	}
