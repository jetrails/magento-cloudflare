const $ = require ("jquery")
const notification = require ("cloudflare/core/notification")

$( document ).on ( "cloudflare.crypto.ssl.initialize", function ( event, data ) {
	let value = data.response.payload.value
	$(data.section).find ("[name='value']").val ( value )
	if ( value == "off" ) {
		$(data.section).find (".status").hide ()
	}
	else {
		let status = data.response.payload.certificate_status
		status = status.charAt ( 0 ).toUpperCase () + status.slice ( 1 ) + " Certificate"
		status = status == "None Certificate" ? "No Certificate" : status
		let color = status == "Active Certificate" ? "#689610" : "#333333"
		$(data.section).find (".status svg > circle").css ( "fill", color )
		$(data.section).find (".status").show ()
		$(data.section).find (".status_message").text ( status )
	}
	$(data.section).removeClass ("loading")
});

$( document ).on ( "cloudflare.crypto.ssl.change", function ( event, data ) {
	let value = $(data.section).find ("[name='value']").val ()
	$( data.section ).addClass ("loading")
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "value": value },
		success: function ( response ) {
			console.log ( response )
			notification.addMessages ( response.state, response.messages );
			if ( value == "off" ) {
				$(data.section).find (".status").hide ()
			}
			else {
				let status = response.payload.certificate_status
				status = status.charAt ( 0 ).toUpperCase () + status.slice ( 1 ) + " Certificate"
				status = status == "None Certificate" ? "No Certificate" : status
				let color = status == "Active Certificate" ? "#689610" : "#333333"
				$(data.section).find (".status svg > circle").css ( "fill", color )
				$(data.section).find (".status").show ()
				$(data.section).find (".status_message").text ( status )
			}
			$(data.section).removeClass ("loading")
		}
	});
});
