const $ = require ("jquery")
const notification = require ("cloudflare/core/notification")

function initialize ( event, data ) {
	$(data.section).find ("[name='value']").val ( data.response.result.value )
	$(data.section).removeClass ("loading")
}

function update ( event, data ) {
	let value = $(data.section).find ("[name='value']").val ()
	$(data.section).addClass ("loading")
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "value": value },
		success: ( response ) => {
			notification.showMessages ( response )
			$(data.section).removeClass ("loading")
		}
	})
}

module.exports = { initialize, update }
