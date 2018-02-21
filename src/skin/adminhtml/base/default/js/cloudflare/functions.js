const $j = jQuery.noConflict ();

function loadSections () {
	$j("section.cloudflare.initialize").each ( function ( index, section ) {
		$j.ajax ({
			url: $j( section ).data ("endpoint"),
			type: "POST",
			data: { form_key: $j( section ).data ("form-key") },
			success: function ( response ) {
				setMessages ( section, "", [""] );
				var event = {
					"target": {
						"tab": $j( section ).data ("tab-name"),
						"section": $j( section ).data ("section-name"),
						"action": "initialize"
					},
					"section": section,
					"response": response
				};
				event.target.name = event.target.tab + "." + event.target.section + "." + event.target.action;
				event.target.name = "cloudflare." + event.target.name;
				$j.event.trigger ( event.target.name, event );
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
		$j("section.cloudflare .messages").each ( function ( key, value ) {
			var spans = $j( value ).find ("span");
			var next = $j( value ).find ("span:first");
			if ( $j( value ).find ("span:not(.hidden):first").next ().length > 0 ) {
				next = $j( value ).find ("span:not(.hidden):first").next ();
			}
			$j( spans ).addClass ("hidden");
			$j( next ).removeClass ("hidden");
		});
		rotateMessages ();
	}, 3000 );
}

function setMessages ( target, state, messages ) {
	$j( target )
		.removeClass ("loading")
		.removeClass ("response_error")
		.removeClass ("response_warning")
		.removeClass ("response_success")
		.addClass ( state );
	target = $j ( target ).find (".messages").eq ( 0 );
	var elements = messages.map ( ( element ) => {
		var span = document.createElement ("span");
		span.innerHTML = element;
		span.class = "hidden";
		return span;
	});
	if ( elements.length > 0 ) elements [ 0 ].class = "";
	$j( target ).html ("");
	$j( target ).append ( elements );
}

$j( window ).on ( "load", function () {
	loadSections ();
	rotateMessages ();

	$j ( document ).on ( "click", ".trigger", function () {
		var section = $j( this ).closest ("section");
		var event = {
			"target": {
				"tab": $j( section ).data ("tab-name"),
				"section": $j( section ).data ("section-name"),
				"action": $j( this ).data ("target")
			},
			"form": {
				"endpoint": $j( this ).closest ("section").data ("endpoint") + $j( this ).data ("target"),
				"key": $j( this ).closest ("section").data ("form-key")
			},
			"section": section,
			"trigger": $j( this )
		};
		event.target.name = event.target.tab + "." + event.target.section + "." + event.target.action;
		event.target.name = "cloudflare." + event.target.name;
 		$j.event.trigger ( event.target.name, event );
		console.log ( "Triggered: " + event.target.name )
	});

});
