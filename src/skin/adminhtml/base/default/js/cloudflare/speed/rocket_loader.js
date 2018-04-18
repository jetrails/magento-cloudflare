const $ = require ("jquery")
const notification = require ("cloudflare/core/notification")

$( document ).on ( "cloudflare.speed.rocket_loader.initialize", function ( event, data ) {
	var label = data.response.payload.value;
	$( data.section ).find ("input[name='value'][value='" + label + "']").prop ( "checked", true );
});

$( document ).on ( "cloudflare.speed.rocket_loader.change", function ( event, data ) {
	var newValue = $(data.section).find ("input[name='value']:checked").val ();
	$(data.section).addClass ("loading")
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "value": newValue },
		success: function ( response ) {
			notification.addMessages ( response.state, response.messages );
			$(data.section).removeClass ("loading")
		}
	});
});
