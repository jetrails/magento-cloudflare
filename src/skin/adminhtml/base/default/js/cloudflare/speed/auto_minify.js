const $ = require ("jquery");

$( document ).on ( "cloudflare.speed.auto_minify.initialize", function ( event, data ) {
	// var label = data.response.payload.value;
	// $( data.section ).find ("input[name='value'][value='" + label + "']").prop ( "checked", true );
});

$( document ).on ( "cloudflare.speed.auto_minify.change", function ( event, data ) {
	// var newValue = $( data.section ).find ("input[name='value']:checked").val ();
	// setMessages ( data.section, "loading", [""] );
	// $.ajax ({
	// 	url: data.form.endpoint,
	// 	type: "POST",
	// 	data: { "form_key": data.form.key, "value": newValue },
	// 	success: function ( response ) {
	// 		setMessages ( data.section, response.state, response.messages );
	// 	}
	// });
});
