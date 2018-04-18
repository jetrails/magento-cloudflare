const $ = require ("jquery")
const cloudflare = require ("cloudflare/common");
const common = require ("cloudflare/common");
const notification = require ("cloudflare/core/notification")
const modal = require ("cloudflare/core/modal")

$( document ).on ( "cloudflare.caching.browser_cache_expiration.initialize", function ( event, data ) {
	$(data.section).find ("[name='value']").val ( data.response.result.value )
	$(data.section).removeClass ("loading")
});

$( document ).on ( "cloudflare.caching.browser_cache_expiration.update", function ( event, data ) {
	$(data.section).addClass ("loading")
	let value = $(data.section).find ("[name='value']").val ()
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "value": value },
		success: function ( response ) {
			if ( !response.success ) {
				notification.addMessages ( "response_error", response.errors );
			}
			$(data.section).removeClass ("loading")
		}
	});
});
