<?php

	/**
	 * This controller inherits from a generic controller that implements the
	 * base functionality for interfacing with a switch section.  This section
	 * simply loads the initial value through the Cloudflare API as well as
	 * gives the ability to change the value of said section to be on or off
	 * though the 'toggle' action.
	 * @version     1.2.4
	 * @package     JetRails® Cloudflare
	 * @author      Rafael Grigorian <development@jetrails.com>
	 * @copyright   © 2018 JETRAILS, All rights reserved
	 * @license     MIT https://opensource.org/licenses/MIT
	 */
	class JetRails_Cloudflare_Cloudflare_Api_Caching_EnableQueryStringSortController
	extends JetRails_Cloudflare_Controller_Toggle {}
