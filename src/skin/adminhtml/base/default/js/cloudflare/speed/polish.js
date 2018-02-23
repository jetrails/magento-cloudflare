const $ = require ("jquery")
const cloudflare = require ("cloudflare/common");

$( document ).on ( "cloudflare.speed.polish.initialize", function ( event, data ) {
	var value = data.response.state.value;
	var webp = data.response.webp.value == "on";
	$( data.section ).find ("#webp").prop ( "checked", webp );
	$( data.section ).find (".selection").val ( value );
	if ( !data.response.state.editable || !data.response.webp.editable ) {
		var button = "<a href='https://www.cloudflare.com/plans/' target='_blank' ><input type='button' value='Upgrade to Pro' /></a>"
		$( data.section ).find (".wrapper_right > div").html ( button );
	}
});

$( document ).on ( "cloudflare.speed.polsh.change", function ( event, data ) {
	console.log ("Message (cloudflare.speed.polsh.change): Need to implement change target with 'Pro' account");
	// var newValue = $( data.section ).find ("input[name='value']:checked").val ();
	// cloudflare.setMessages ( data.section, "loading", [""] );
	// $.ajax ({
	// 	url: data.form.endpoint,
	// 	type: "POST",
	// 	data: { "form_key": data.form.key, "value": newValue },
	// 	success: function ( response ) {
	// 		cloudflare.setMessages ( data.section, response.state, response.messages );
	// 	}
	// });
});
