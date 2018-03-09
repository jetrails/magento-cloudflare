const $ = require ("jquery")
const cloudflare = require ("cloudflare/common");
const notification = require ("cloudflare/core/notification")

$( document ).on ( "cloudflare.overview.status.initialize", function ( event, data ) {
	if ( data.response.payload.paused ) {
		$( data.section ).find (".section_title").text ("Resume")
		$( data.section ).find (".wrapper_left > p").text ("Cloudflare has been temporarily deactivated for your domain. Cloudflare will continue to resolve DNS for your website, but all requests will go directly to your origin which means you will not receive the performance and security benefits. All of your settings have been saved.")
		$( data.section ).find (".trigger").val ("Resume");
		$( data.section ).find (".trigger").data ( "target", "resume" );
	}
	else {
		$( data.section ).find (".section_title").text ("Pause Website")
		$( data.section ).find (".wrapper_left > p").text ("Pause will temporarily deactivate Cloudflare for your domain. Cloudflare will continue to resolve DNS for your website, but all requests will go directly to your origin which means you will not receive performance and security benefits. All of your settings will be saved.")
		$( data.section ).find (".trigger").val ("Pause");
		$( data.section ).find (".trigger").data ( "target", "pause" );
	}
});

$( document ).on ( "cloudflare.overview.status.pause", function ( event, data ) {
	cloudflare.setMessages ( data.section, "loading", [""] );
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key },
		success: function ( response ) {
			cloudflare.setMessages ( data.section, response.state, response.messages );
			notification.addMessages ( response.state, response.messages );
			if ( response.payload.paused ) {
				$( data.section ).find (".section_title").text ("Resume")
				$( data.section ).find (".wrapper_left > p").text ("Cloudflare has been temporarily deactivated for your domain. Cloudflare will continue to resolve DNS for your website, but all requests will go directly to your origin which means you will not receive the performance and security benefits. All of your settings have been saved.")
				$( data.section ).find (".trigger").val ("Resume");
				$( data.section ).find (".trigger").data ( "target", "resume" );
			}
		}
	});
});

$( document ).on ( "cloudflare.overview.status.resume", function ( event, data ) {
	cloudflare.setMessages ( data.section, "loading", [""] );
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key },
		success: function ( response ) {
			cloudflare.setMessages ( data.section, response.state, response.messages );
			notification.addMessages ( response.state, response.messages );
			if ( !response.payload.paused ) {
				$( data.section ).find (".section_title").text ("Pause Website")
				$( data.section ).find (".wrapper_left > p").text ("Pause will temporarily deactivate Cloudflare for your domain. Cloudflare will continue to resolve DNS for your website, but all requests will go directly to your origin which means you will not receive performance and security benefits. All of your settings will be saved.")
				$( data.section ).find (".trigger").val ("Pause");
				$( data.section ).find (".trigger").data ( "target", "pause" );
			}
		}
	});
});
