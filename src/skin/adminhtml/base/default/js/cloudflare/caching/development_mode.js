const $ = require ("jquery")
const cloudflare = require ("cloudflare/common")
const notification = require ("cloudflare/core/notification")

$( document ).on ( "cloudflare.caching.development_mode.initialize", function ( event, data ) {
	var value = data.response.payload.value == "on" ? "true" : "false";
	$( data.section ).find ("#state").eq ( 0 ).data ( "state", value );
	$( data.section ).find ("#state").eq ( 0 ).attr ( "data-state", value );
});

$( document ).on ( "cloudflare.caching.development_mode.toggle", function ( event, data ) {
	var state = $( data.section ).find ("#state").eq ( 0 ).data ("state") == "true";
	$( data.section ).find ("#state").eq ( 0 ).data ( "state", !state + "" );
	$( data.section ).find ("#state").eq ( 0 ).attr ( "data-state", !state + "" );
	cloudflare.setMessages ( data.section, "loading", [""] );
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "state": !state },
		success: function ( response ) {
			cloudflare.setMessages ( data.section, response.state, response.messages );
			notification.addMessages ( response.state, response.messages );
		}
	});
});
