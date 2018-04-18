const $ = require ("jquery")
const notification = require ("cloudflare/core/notification")

$( document ).on ( "cloudflare.crypto.tls_13.initialize", function ( event, data ) {
	$(data.section).find ("[name='value']").val ( data.response.payload.value )
	$(data.section).removeClass ("loading")
});

$( document ).on ( "cloudflare.crypto.tls_13.change", function ( event, data ) {
	let value = $(data.section).find ("[name='value']").val ()
	$( data.section ).addClass ("loading")
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "value": value },
		success: function ( response ) {
			notification.addMessages ( response.state, response.messages );
			$(data.section).removeClass ("loading")
		}
	});
});
