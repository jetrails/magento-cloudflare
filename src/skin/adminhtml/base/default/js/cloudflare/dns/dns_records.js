const $ = require ("jquery")
const cloudflare = require ("cloudflare/common");
const notification = require ("cloudflare/core/notification")
const modal = require ("cloudflare/core/modal")

$( document ).on ( "cloudflare.dns.dns_records.initialize", function ( event, data ) {
	const imageBase = $( data.section ).find ("table").data ("image-base");
	$( data.section ).find ("table tr:not(:first)").remove ();
	data.response.payload.map ( ( entry, index ) => {
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
		setTimeout ( function () {
			row.appendTo ( $( data.section ).find ("table") );
		}, index * 100 );
	});
	if ( data.response.payload.length == 0 ) {
		$( data.section ).find ("table").append ( $("<tr>").append ( $("<td colspan='6' >").text ("No DNS records found.") ) );
	}
});

$( document ).on ( "cloudflare.dns.dns_records.delete", function ( event, data ) {
	cloudflare.setMessages ( data.section, "loading", [""] );
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "id": $( data.trigger ).data ("id") },
		success: function ( response ) {
			if ( response.state == "response_success" ) {
				$( data.section ).find (".search").trigger ("keyup");
			}
			else {
				cloudflare.setMessages ( data.section, response.state, response.messages );
				notification.addMessages ( response.state, response.messages );
			}
		}
	});
});

$( document ).on ( "cloudflare.dns.dns_records.create", function ( event, data ) {
	cloudflare.setMessages ( data.section, "loading", [""] );
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: {
			"form_key": data.form.key,
			"type": $( data.section ).find ("select.type").val (),
			"name": $( data.section ).find ("div.active > input[name='name']").val (),
			"content": $( data.section ).find ("div.active > input[name='content']").val (),
			"ttl": $( data.section ).find ("select.ttl").val (),
			"proxied": $( data.section ).find (".proxied.add").data ("value"),
			"priority": $( data.section ).find (".priority.add").val ()
		},
		success: function ( response ) {
			if ( response.state == "response_success" ) {
				$( data.section ).find (".search").trigger ("keyup");
			}
			else {
				cloudflare.setMessages ( data.section, response.state, response.messages );
				notification.addMessages ( response.state, response.messages );
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
			if ( response.state != "response_success" ) {
				cloudflare.setMessages ( data.section, response.state, response.messages );
				notification.addMessages ( response.state, response.messages );
			}
			else {
				cloudflare.setMessages ( data.section, response.state, response.messages );
				const imageBase = $( data.section ).find ("table").data ("image-base");
				$( data.section ).find (".search").prop ( "disabled", false );
				$( data.section ).find ("table tr:not(:first)").remove ();
				response.payload.map ( ( entry, index ) => {
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
					setTimeout ( function () {
						row.appendTo ( $( data.section ).find ("table") );
					}, index * 100 );
				});
				if ( response.payload.length == 0 ) {
					$( data.section ).find ("table").append ( $("<tr>").append ( $("<td colspan='6' >").text ("No DNS records found.") ) );
				}
			}
		}
	});
});

$(document).on ( "focus", ".show-form-mx", function () {
	var confirm = new modal.Modal ()
	confirm.addTitle ( "Add Record: MX content", $(this).val () )
	confirm.addRow ( "Server", $("<input type='text' placeholder='Mail server' name='server' >").val ( $(this).val () ) )
	confirm.addRow ( "Priority", $("<input type='text' placeholder='1' name='priority' >").val ( $(this).parent ().parent ().closest (".priority").val () ) )
	confirm.addButtons ()
	confirm.addCancel ( confirm.close )
	var that = this;
	confirm.addSave ( function ( components ) {
		$(that).val ( $( components.container ).find ("input[name='server']").val () )
		var priority = $( components.container ).find ("input[name='priority']").val ()
		if ( priority.trim () === "" ) priority = "1"
		$(that).closest (".priority").val ( priority )
		confirm.close ()
	})
	confirm.show ()
})
