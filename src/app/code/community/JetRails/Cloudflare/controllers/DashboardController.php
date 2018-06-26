<?php

	/**
	 * This controller is used to render the dashboard template with the index
	 * action. It also has a save action that is used to update the Cloudflare
	 * email and token that is used for API access. Finally it contains an
	 * action to change the domain to use with the Cloudflare dashboard. This
	 * domain selection is saved within the user's session.
	 */
	class JetRails_Cloudflare_DashboardController
	extends Mage_Adminhtml_Controller_Action {

		/**
		 * This method simply authorizes access to the dashboard page based on
		 * the logged in user. The user must have resource access to the
		 * jetrails/cloudflare resource.
		 * @return  boolean                           Is access authorized?
		 */
		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare");
		}

		/**
		 * This method sets the page title and sets the active menu to the
		 * JetRails menu item. It then sets the dashboard template and block to
		 * the current layout and finally renders it.
		 * @return  object                            Return reference to self
		 */
		public function indexAction () {
			$this->_title ( $this->__("JetRails") );
			$this->_title ( $this->__("Cloudflare") );
			$this->_title ( $this->__("Dashboard") );
			$this->loadLayout ();
			$this->_setActiveMenu ("jetrails/cloudflare");
			$block = $this
				->getLayout ()
				->createBlock ("cloudflare/dashboard")
				->setTemplate ("cloudflare/dashboard.phtml");
			$this->_addContent ( $block );
			$this->renderLayout ();
			return $this;
		}

		/**
		 * This action is used only by the overview/configuration section and
		 * therefore access to the resource is checked right away. It takes in
		 * an email and a token and saves it with the use of the cloudflare/data
		 * helper class.
		 * @return  void
		 */
		public function saveAction () {
			$session = Mage::getSingleton ("admin/session");
			if ( $session->isAllowed ("jetrails/cloudflare/overview/configuration") ) {
				$api = Mage::getSingleton ("cloudflare/api_overview_configuration");
				$data = Mage::helper ("cloudflare/data");
				$email = $this->getRequest ()->getPost ("email");
				$token = $this->getRequest ()->getPost ("token");
				$data->setAuthEmail ( $email );
				$data->setAuthToken ( $token );
			}
			$this->_redirect ("*/*/index");
		}

		/**
		 * This action is simply used to change the scope of the dashboard by
		 * changing which domain we want to use with the Cloudflare dashboard.
		 * This change is saved within the logged in user's session and the zone
		 * id will be loaded using this selected domain name.
		 * @return  void
		 */
		public function domainAction () {
			$data = Mage::helper ("cloudflare/data");
			$session = Mage::getSingleton ("core/session");
			$selected = $this->getRequest ()->getParam ("name");
			$domains = $data->getDomainNames ();
			$domains = array_filter ( $domains, function ( $domain ) use ( $selected ) {
				return $domain ["name"] == $selected;
			});
			if ( count ( $domains ) === 1 ) {
				$session->setCloudflareSelectedDomain ( $selected );
			}
			$this->_redirect ("*/*/index");
		}

	}
