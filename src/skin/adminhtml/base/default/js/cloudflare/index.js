const $ = require ("jquery")

const notification = require ("cloudflare/core/notification")
const cloudflare = require ("cloudflare/common")

require ("cloudflare/overview/status")
require ("cloudflare/caching/purge_cache")
require ("cloudflare/caching/development_mode")
require ("cloudflare/speed/auto_minify")
require ("cloudflare/speed/polish")
require ("cloudflare/speed/rocket_loader")
require ("cloudflare/dns/dns_records")
require ("cloudflare/dns/cloudflare_nameservers")
require ("cloudflare/firewall/access_rules")

$( window ).on ( "load", function () {
	cloudflare.loadSections ();
	cloudflare.rotateMessages ();

	$( document ).on ( "click", ".trigger", function () {
		var section = $( this ).closest ("section");
		var event = {
			"target": {
				"tab": $( section ).data ("tab-name"),
				"section": $( section ).data ("section-name"),
				"action": $( this ).data ("target")
			},
			"form": {
				"endpoint": $( this ).closest ("section").data ("endpoint") + $( this ).data ("target"),
				"key": $( this ).closest ("section").data ("form-key")
			},
			"section": section,
			"trigger": $( this )
		};
		event.target.name = event.target.tab + "." + event.target.section + "." + event.target.action;
		event.target.name = "cloudflare." + event.target.name;
 		$.event.trigger ( event.target.name, event );
		console.log ( "Triggered: " + event.target.name )
	});
});

$(document).on ( "click", "[data-tab]", function () {
	var section = $(this).closest ("section");
	if ( $(section).find ("[data-tab-content].active").length > 0 ) {
		if ( $(section).find ("[data-tab-content].active").data ("tab-content") == $(this).data ("tab") ) {
			$(section).find ("[data-tab-content]").removeClass ("active");
			$(this).removeClass ("active");
		}
		else {
			$(section).find ("[data-tab-content]").removeClass ("active");
			$(section).find ("[data-tab-content='" + $(this).data ("tab") + "']").addClass ("active");
			$(section).find ("data-tab").removeClass ("active");
			$(this).addClass ("active");
		}
	}
	else {
		$(section).find ("[data-tab-content]").removeClass ("active");
		$(section).find ("[data-tab-content='" + $(this).data ("tab") + "']").addClass ("active");
		$(section).find ("data-tab").removeClass ("active");
		$(this).addClass ("active");
	}
});
