<?php

	/**
	 * This controller inherits from a generic controller that implements the
	 * base functionality for interfacing with a selection section. This section
	 * simply loads the initial value through the Cloudflare API as well as
	 * gives the ability to change the value of said section to whatever value
	 * is being passed though the 'update' action.
	 * @version     1.0.0
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Cloudflare_Api_Firewall_SecurityLevelController
	extends JetRails_Cloudflare_Controller_Update {}