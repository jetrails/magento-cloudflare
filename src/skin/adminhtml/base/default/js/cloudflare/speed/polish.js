const $ = require ("jquery")
const notification = require ("cloudflare/core/notification")

$( document ).on ( "cloudflare.speed.polish.initialize", function ( event, data ) {
	var value = data.response.state.payload.value;
	var webp = data.response.webp.payload.value == "on";
	$(data.section).find ("[name='value']").val ( value );
	$(data.section).find ("[name='webp']").prop ( "checked", webp );
	if ( !data.response.state.payload.editable ) {
		var button = "<a href='https://www.cloudflare.com/plans/' target='_blank' ><input type='button' value='Upgrade to Pro' /></a>"
		$( data.section ).find (".wrapper_right > div").eq ( 0 ).html ( button );
	}
});

$( document ).on ( "cloudflare.speed.polish.change", function ( event, data ) {
	let value = $(data.section).find ("[name='value']").val ();
	let webp = $(data.section).find ("[name='webp']").prop ("checked");
	$(data.section).addClass ("loading")
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "value": value, "webp": webp },
		success: function ( response ) {
			notification.addMessages ( response.state, response.messages );
			$(data.section).removeClass ("loading")
		}
	});
});
