const $ = require ("jquery")
const cloudflare = require ("cloudflare/common")
const notification = require ("cloudflare/core/notification")

$(document).on ( "cloudflare.speed.auto_minify.initialize", function ( event, data ) {
	var jsState = data.response.result.value.js === "on"
	var cssState = data.response.result.value.css === "on"
	var htmlState = data.response.result.value.html === "on"
	$(data.section).find ("input[value='javascript']").prop ( "checked", jsState )
	$(data.section).find ("input[value='css']").prop ( "checked", cssState )
	$(data.section).find ("input[value='html']").prop ( "checked", htmlState )
})

$(document).on ( "cloudflare.speed.auto_minify.change", function ( event, data ) {
	var jsVal = $(data.section).find ("input[value='javascript']").prop ("checked")
	var cssVal = $(data.section).find ("input[value='css']").prop ("checked")
	var htmlVal = $(data.section).find ("input[value='html']").prop ("checked")
	$(data.section).addClass ("loading")
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "js": jsVal, "css": cssVal, "html": htmlVal },
		success: function ( response ) {
			$(data.section).removeClass ("loading")
			notification.showMessages ( response )
		}
	})
})
