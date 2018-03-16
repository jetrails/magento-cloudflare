const $ = require ("jquery");
const cloudflare = require ("cloudflare/common")
const notification = require ("cloudflare/core/notification")

const modal = require ("cloudflare/core/modal")

$( document ).on ( "cloudflare.caching.purge_cache.individual", function ( event, data ) {
	var files = $( data.section ).find ("#files").eq ( 0 ).val ()
		.split (/\n|,/)
		.map ( i => i.trim () )
		.filter ( i => i !== "" );
	cloudflare.setMessages ( data.section, "loading", [""] )
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "files": files },
		success: function ( response ) {
			cloudflare.setMessages ( data.section, response.state, response.messages );
			notification.addMessages ( response.state, response.messages );
		}
	});
});

$( document ).on ( "cloudflare.caching.purge_cache.everything", function ( event, data ) {
	cloudflare.setMessages ( data.section, "loading", [""] )
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key },
		success: function ( response ) {
			cloudflare.setMessages ( data.section, response.state, response.messages );
			notification.addMessages ( response.state, response.messages );
		}
	});
});
