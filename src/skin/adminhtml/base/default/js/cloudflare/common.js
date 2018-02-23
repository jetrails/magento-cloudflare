const $ = require ("jquery")

function loadSections () {
	$("section.cloudflare.initialize").each ( function ( index, section ) {
		$.ajax ({
			url: $( section ).data ("endpoint"),
			type: "POST",
			data: { form_key: $( section ).data ("form-key") },
			success: function ( response ) {
				setMessages ( section, "", [""] );
				var event = {
					"target": {
						"tab": $( section ).data ("tab-name"),
						"section": $( section ).data ("section-name"),
						"action": "initialize"
					},
					"section": section,
					"response": response
				};
				event.target.name = event.target.tab + "." + event.target.section + "." + event.target.action;
				event.target.name = "cloudflare." + event.target.name;
				$.event.trigger ( event.target.name, event );
				console.log ( "Triggered: " + event.target.name );
			},
			error: function () {
				setMessages ( section, "response_error", ["Error : Could not load initial values"] );
			}
		});
	});
}

function rotateMessages () {
	setTimeout ( function () {
		$("section.cloudflare .messages").each ( function ( key, value ) {
			var spans = $( value ).find ("span");
			var next = $( value ).find ("span:first");
			if ( $( value ).find ("span:not(.hidden):first").next ().length > 0 ) {
				next = $( value ).find ("span:not(.hidden):first").next ();
			}
			$( spans ).addClass ("hidden");
			$( next ).removeClass ("hidden");
		});
		rotateMessages ();
	}, 3000 );
}

function setMessages ( target, state, messages ) {
	$( target )
		.removeClass ("loading")
		.removeClass ("response_error")
		.removeClass ("response_warning")
		.removeClass ("response_success")
		.addClass ( state );
	target = $ ( target ).find (".messages").eq ( 0 );
	var elements = messages.map ( ( element ) => {
		var span = document.createElement ("span");
		span.innerHTML = element;
		span.class = "hidden";
		return span;
	});
	if ( elements.length > 0 ) elements [ 0 ].class = "";
	$( target ).html ("");
	$( target ).append ( elements );
}

module.exports = {
	setMessages: setMessages,
	rotateMessages: rotateMessages,
	loadSections: loadSections
}
