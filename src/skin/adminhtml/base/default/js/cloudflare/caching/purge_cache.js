const $ = require ("jquery");
const modal = require ("cloudflare/core/modal")
const notification = require ("cloudflare/core/notification")

$( document ).on ( "cloudflare.caching.purge_cache.individual", function ( event, data ) {
	let textarea = modal.createTextarea ( "files", "http://example.com/images/example.jpg" ).css ( "font-size", "1.2em" )
	let prompt = new modal.Modal ( 800 )
	prompt.addTitle ( "Purge Individual Files", "You can purge up to 30 files at a time." )
	prompt.addElement ( $("<p>")
		.append ( $("<strong>").text ("Note: ") )
		.append ("Wildcards are not supported with single file purge at this time. You will need to specify the full path to the file.")
	)
	prompt.addElement ( $("<p>").text ("Separate tags(s) with commas, or list one per line") )
	prompt.addElement ( textarea )
	prompt.addButton ({ label: "Purge Individual Files", callback: ( components ) => {
		$(prompt.components.modal).addClass ("loading")
		$(data.section).addClass ("loading")
		let files = $(textarea).val ()
			.split (/\n|,/)
			.map ( i => i.trim () )
			.filter ( i => i !== "" );
		$.ajax ({
			url: data.form.endpoint,
			type: "POST",
			data: { "form_key": data.form.key, "files": files },
			success: function ( response ) {
				if ( response.state == "response_success" ) {
					prompt.close ()
				}
				else {
					$(prompt.components.modal).removeClass ("loading")
				}
				$(data.section).removeClass ("loading")
				notification.addMessages ( response.state, response.messages );
			}
		});
	}})
	prompt.show ()


	// var files = $( data.section ).find ("#files").eq ( 0 ).val ()
	// 	.split (/\n|,/)
	// 	.map ( i => i.trim () )
	// 	.filter ( i => i !== "" );
	// $(data.section).addClass ("loading")
	// $.ajax ({
	// 	url: data.form.endpoint,
	// 	type: "POST",
	// 	data: { "form_key": data.form.key, "files": files },
	// 	success: function ( response ) {
	//		$(data.section).removeClass ("loading")
	// 		notification.addMessages ( response.state, response.messages );
	// 	}
	// });
});

$( document ).on ( "cloudflare.caching.purge_cache.everything", function ( event, data ) {
	$(data.section).addClass ("loading")
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key },
		success: function ( response ) {
			$(data.section).removeClass ("loading")
			notification.addMessages ( response.state, response.messages )
		}
	});
});
