const $ = require ("jquery")
const cloudflare = require ("cloudflare/common");

$( document ).on ( "cloudflare.speed.rocket_loader.initialize", function ( event, data ) {
	var label = data.response.payload.value;
	$( data.section ).find ("input[name='value'][value='" + label + "']").prop ( "checked", true );
});

$( document ).on ( "cloudflare.speed.rocket_loader.change", function ( event, data ) {
	var newValue = $( data.section ).find ("input[name='value']:checked").val ();
	cloudflare.setMessages ( data.section, "loading", [""] );
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "value": newValue },
		success: function ( response ) {
			cloudflare.setMessages ( data.section, response.state, response.messages );
		}
	});
});
