const $ = require ("jquery")
const cloudflare = require ("cloudflare/common");
const notification = require ("cloudflare/core/notification")

$( document ).on ( "cloudflare.dns.dns_records.initialize", function ( event, data ) {
	const imageBase = $( data.section ).find ("table").data ("image-base");
	$( data.section ).find ("table tr:not(:first)").remove ();
	data.response.payload.map ( entry => {
		var row = $("<tr>");
		$( row ).append ( $("<td>")
			.attr ( "class", "type type_" + entry.type.toLowerCase () )
			.text ( entry.type )
		)
		$( row ).append ( $("<td>")
			.attr ( "class", "name" )
			.text ( [ "CAA", "SRV" ].indexOf ( entry.type ) > -1 ? entry.name : entry.name.replace ( /\.[^.]+\.[^.]+$/, "" ) )
		)
		$( row ).append ( $("<td>")
			.attr ( "class", "value" )
			.text ( entry.content )
		)
		$( row ).append ( $("<td>")
			.attr ( "class", "ttl" )
			.text ( entry.ttl == 1 ? "Automatic" : entry.ttl + " seconds" )
		)
		$( row ).append ( $("<td>")
			.attr ( "class", "status" )
			.html ( entry.proxiable ? entry.proxied ? "<img src='" + imageBase + "/proxied_on.png' />" : "<img src='" + imageBase + "/proxied_off.png' />" : "" )
		)
		$( row ).append ( $("<td>").attr ( "class", "delete" )
			.html ( $("<div class='trigger delete_entry cloudflare-font' >")
				.data ( "target", "delete" )
				.data ( "id", entry.id )
				.html ("&#xF01A;")
			)
		)
		$( data.section ).find ("table").append ( row );
	});
});

$( document ).on ( "cloudflare.dns.dns_records.delete", function ( event, data ) {
	cloudflare.setMessages ( data.section, "loading", [""] );
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "id": $( data.trigger ).data ("id") },
		success: function ( response ) {
			cloudflare.setMessages ( data.section, response.state, response.messages );
			notification.addMessages ( response.state, response.messages );
			if ( response.state == "response_success" ) {
				$( data.trigger ).closest ("tr").remove ();
			}
		}
	});
});


$( document ).on ( "cloudflare.dns.dns_records.search", function ( event, data ) {
	cloudflare.setMessages ( data.section, "loading", [""] );
	var query = $( data.section ).find (".search").val ();
	$( data.section ).find (".search").prop ( "disabled", true );
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "query": query },
		success: function ( response ) {
			const imageBase = $( data.section ).find ("table").data ("image-base");
			$( data.section ).find (".search").prop ( "disabled", false );
			$( data.section ).find ("table tr:not(:first)").remove ();
			response.payload.map ( entry => {
				var row = $("<tr>");
				$( row ).append ( $("<td>")
					.attr ( "class", "type type_" + entry.type.toLowerCase () )
					.text ( entry.type )
				)
				$( row ).append ( $("<td>")
					.attr ( "class", "name" )
					.text ( [ "CAA", "SRV" ].indexOf ( entry.type ) > -1 ? entry.name : entry.name.replace ( /\.[^.]+\.[^.]+$/, "" ) )
				)
				$( row ).append ( $("<td>")
					.attr ( "class", "value" )
					.text ( entry.content )
				)
				$( row ).append ( $("<td>")
					.attr ( "class", "ttl" )
					.text ( entry.ttl == 1 ? "Automatic" : entry.ttl + " seconds" )
				)
				$( row ).append ( $("<td>")
					.attr ( "class", "status" )
					.html ( entry.proxiable ? entry.proxied ? "<img src='" + imageBase + "/proxied_on.png' />" : "<img src='" + imageBase + "/proxied_off.png' />" : "" )
				)
				$( row ).append ( $("<td>").attr ( "class", "delete" )
					.html ( $("<div class='trigger delete_entry cloudflare-font' >")
						.data ( "target", "delete" )
						.data ( "id", entry.id )
						.html ("&#xF01A;")
					)
				)
				$( data.section ).find ("table").append ( row );
			});
			if ( response.payload.length == 0 ) {
				$( data.section ).find ("table").append ( $("<tr>").append ( $("<td colspan='6' >").text ("No DNS records found.") ) );
			}
			console.log ( response );
			cloudflare.setMessages ( data.section, response.state, response.messages );
			notification.addMessages ( response.state, response.messages );
		}
	});
});
