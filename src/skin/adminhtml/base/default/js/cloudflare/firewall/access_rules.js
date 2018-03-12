const $ = require ("jquery")
const cloudflare = require ("cloudflare/common");
const notification = require ("cloudflare/core/notification")

$( document ).on ( "cloudflare.firewall.access_rules.initialize", function ( event, data ) {
	console.log ( data.response )
});
