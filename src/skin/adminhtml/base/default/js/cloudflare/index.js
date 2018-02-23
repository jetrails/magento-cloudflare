const $ = require ("jquery")

const cloudflare = require ("cloudflare/common")

require ("cloudflare/caching/purge_cache")
require ("cloudflare/caching/development_mode")
require ("cloudflare/speed/auto_minify")
require ("cloudflare/speed/rocket_loader")


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
