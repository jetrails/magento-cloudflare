<?php

	class JetRails_Cloudflare_Block_Adminhtml_Dashboard_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

	    public function __construct () {
	        parent::__construct ();
	        $this->setId ("cloudflare_dashboard");
	        $this->setDestElementId ("edit_form");
	        $this->setTitle ("<img class='cloudflare_logo'  src='" . $this->getSkinUrl ('images/cloudflare/cloudflare.svg') . "' />");
	    }

		protected function _createTabIcon ( $type ) {
			$label = $type;
			$icon = strtolower ( str_replace ( " ", "_", $type ) );
			return "<img class='cloudflare_tab_icon' src='" . $this->getSkinUrl ("images/cloudflare/icons/tab/$icon.svg") . "' /><span class='cloudflare_tab_label' >$label</span>";
		}

		protected function _beforeToHtml () {
			$this
			->addTab ( "overview", array (
				"label"  	=> $this->_createTabIcon ("Overview"),
				"title"  	=> $this->__("Overview"),
				"content"   => $this->getLayout ()->createBlock ("cloudflare/dashboard_edit_tab_overview")->toHtml (),
			))
			->addTab ( "caching", array (
				"label"  	=> $this->_createTabIcon ("Caching"),
				"title"  	=> $this->__("Caching"),
				"content"   => $this->getLayout ()->createBlock ("cloudflare/dashboard_edit_tab_caching")->toHtml (),
			))
			->addTab ( "dns", array (
				"label"  	=> $this->_createTabIcon ("DNS"),
				"title"  	=> $this->__("DNS"),
				"content"   => $this->getLayout ()->createBlock ("cloudflare/dashboard_edit_tab_dns")->toHtml (),
			))
			->addTab ( "pagerules", array (
				"label"  	=> $this->_createTabIcon ("Page Rules"),
				"title"  	=> $this->__("Page Rules"),
				"content"   => $this->getLayout ()->createBlock ("cloudflare/dashboard_edit_tab_pagerules")->toHtml (),
			))
			->addTab ( "speed", array (
				"label"  	=> $this->_createTabIcon ("Speed"),
				"title"  	=> $this->__("Speed"),
				"content"   => $this->getLayout ()->createBlock ("cloudflare/dashboard_edit_tab_speed")->toHtml (),
			));
			return parent::_beforeToHtml ();
		}

	}
