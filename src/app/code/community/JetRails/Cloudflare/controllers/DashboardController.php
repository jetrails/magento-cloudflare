<?php

	class JetRails_Cloudflare_DashboardController
	extends Mage_Adminhtml_Controller_Action {

		protected function _isAllowed () {
			$session = Mage::getSingleton ("admin/session");
			return $session->isAllowed ("jetrails/cloudflare");
		}

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

	}
