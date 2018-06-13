<?php

	class JetRails_Cloudflare_Block_Adminhtml_Dashboard_Edit_Tabs
	extends Mage_Adminhtml_Block_Widget_Tabs {

	    public function __construct () {
	        parent::__construct ();
	        $this->setId ("cloudflare_dashboard");
	        $this->setDestElementId ("edit_form");
	        $this->setTitle ("<img class='cloudflare_logo'  src='" . $this->getSkinUrl ('images/cloudflare/cloudflare.svg') . "' />");
	    }

		protected function _createTabIcon ( $type ) {
			$label = $type;
			$key = strtolower ( str_replace ( " ", "_", $type ) );
			$icon = "&#xE902;";
			switch ( $key ) {
				case "overview": 		$icon = "&#xF00A;"; break;
				case "caching": 		$icon = "&#xF00D;"; break;
				case "dns": 			$icon = "&#xF00F;"; break;
				case "crypto": 			$icon = "&#xF011;"; break;
				case "firewall": 		$icon = "&#xF014;"; break;
				case "speed": 			$icon = "&#xF00B;"; break;
				case "page_rules": 		$icon = "&#xF00E;"; break;
				case "network": 		$icon = "&#xE905;"; break;
				case "scrape_shield": 	$icon = "&#xF013;"; break;
			}
			return "
				<div class='cloudflare_tab_icon' >$icon</div>
				<span class='cloudflare_tab_label' >$label</span>
			";
		}

		protected function _beforeToHtml () {
			$this
			->addTab ( "overview", array (
				"label"  	=> $this->_createTabIcon ("Overview"),
				"title"  	=> $this->__("Overview"),
				"content"   => $this->getLayout ()
									->createBlock ("adminhtml/widget_form")
									->setTemplate ("cloudflare/overview.phtml")
									->toHtml (),
			))
			->addTab ( "caching", array (
				"label"  	=> $this->_createTabIcon ("Caching"),
				"title"  	=> $this->__("Caching"),
				"content"   => $this->getLayout ()
									->createBlock ("adminhtml/widget_form")
									->setTemplate ("cloudflare/caching.phtml")
									->toHtml (),
			))
			->addTab ( "dns", array (
				"label"  	=> $this->_createTabIcon ("DNS"),
				"title"  	=> $this->__("DNS"),
				"content"   => $this->getLayout ()
									->createBlock ("adminhtml/widget_form")
									->setTemplate ("cloudflare/dns.phtml")
									->toHtml (),
			))
			->addTab ( "crypto", array (
				"label"  	=> $this->_createTabIcon ("Crypto"),
				"title"  	=> $this->__("Crypto"),
				"content"   => $this->getLayout ()
									->createBlock ("adminhtml/widget_form")
									->setTemplate ("cloudflare/crypto.phtml")
									->toHtml (),
			))
			->addTab ( "firewall", array (
				"label"  	=> $this->_createTabIcon ("Firewall"),
				"title"  	=> $this->__("Firewall"),
				"content"   => $this->getLayout ()
									->createBlock ("adminhtml/widget_form")
									->setTemplate ("cloudflare/firewall.phtml")
									->toHtml (),
			))
			->addTab ( "speed", array (
				"label"  	=> $this->_createTabIcon ("Speed"),
				"title"  	=> $this->__("Speed"),
				"content"   => $this->getLayout ()
									->createBlock ("adminhtml/widget_form")
									->setTemplate ("cloudflare/speed.phtml")
									->toHtml (),
			))
			->addTab ( "pagerules", array (
				"label"  	=> $this->_createTabIcon ("Page Rules"),
				"title"  	=> $this->__("Page Rules"),
				"content"   => $this->getLayout ()
									->createBlock ("adminhtml/widget_form")
									->setTemplate ("cloudflare/page_rules.phtml")
									->toHtml (),
			))
			->addTab ( "network", array (
				"label"  	=> $this->_createTabIcon ("Network"),
				"title"  	=> $this->__("Network"),
				"content"   => $this->getLayout ()
									->createBlock ("adminhtml/widget_form")
									->setTemplate ("cloudflare/network.phtml")
									->toHtml (),
			))
			->addTab ( "scrapeshield", array (
				"label"  	=> $this->_createTabIcon ("Scrape Shield"),
				"title"  	=> $this->__("Scrape Shield"),
				"content"   => $this->getLayout ()
									->createBlock ("adminhtml/widget_form")
									->setTemplate ("cloudflare/scrape_shield.phtml")
									->toHtml (),
			));
			return parent::_beforeToHtml ();
		}

	}
