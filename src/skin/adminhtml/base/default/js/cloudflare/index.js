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
require ("cloudflare/firewall/security_level")
require ("cloudflare/page_rules/page_rules")

$( window ).on ( "load", function () {
	cloudflare.loadSections ();
	cloudflare.rotateMessages ();

	$( ".proxied" ).each ( function ( index ) {
		$(this).data ( "value", /proxied_on/.test ( $(this).attr ("src") ) )
	})

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

	$( document ).on ( "change", ".trigger-select", function () {
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

	var triggerChangeTimeout;

	$( document ).on ( "keyup", ".trigger-change", function () {
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

		clearTimeout ( triggerChangeTimeout );
		triggerChangeTimeout = setTimeout ( function () {
			$.event.trigger ( event.target.name, event );
			console.log ( "Triggered (Change): " + event.target.name )
		}, 1000 );
	});

});

$(document).on ( "click", "[data-tab]", function () {
	var section = $(this).closest ("section");
	if ( $(this).hasClass ("active") && !$(section).hasClass ("at_least_one") ) {
		$(section).find ("[data-tab-content]").removeClass ("active");
		$(section).find ("[data-tab]").removeClass ("active");
	}
	else {
		$(section).find ("[data-tab-content]").removeClass ("active");
		$(section).find ("[data-tab]").removeClass ("active");
		$(this).addClass ("active");
		$(section).find ("[data-tab-content='" + $(this).data ("tab") + "']").addClass ("active");
	}
});

$(document).on ( "change", ".dynamic-trigger", function () {
	const target = $(this).val ();
	$(this).parent ().find ("div[data-dynamic-wrapper]").removeClass ("active");
	$(this).parent ().find ("div[data-dynamic-wrapper='" + target + "']").addClass ("active");
	$(this).parent ().find ("[data-dynamic-show]").each ( function () {
		if ( $(this).data ("dynamic-show").includes ( target.toLowerCase () ) ) {
			$(this).show ();
		}
		else {
			$(this).hide ();
		}
	})
});

$(document).on ( "click", ".dynamic-trigger", function () {
	const target = $(this).data ("tab");
	if ( target ) {
		$(this).parent ().find ("div[data-dynamic-wrapper]").removeClass ("active");
		$(this).parent ().find ("div[data-dynamic-wrapper='" + target + "']").addClass ("active");
		$(this).parent ().find ("[data-dynamic-show]").each ( function () {
			if ( $(this).data ("dynamic-show").includes ( target.toLowerCase () ) ) {
				$(this).show ();
			}
			else {
				$(this).hide ();
			}
		})
	}
});

$(document).on ( "click", ".proxied", function () {
	let source = $(this).attr ("src")
	if ( /proxied_on/.test ( source ) ) {
		source = source.replace ( /proxied_on/, "proxied_off" )
		$(this).data ( "value", false )
	}
	else {
		source = source.replace ( /proxied_off/, "proxied_on" )
		$(this).data ( "value", true )
	}
	$(this).attr ( "src", source )
})
