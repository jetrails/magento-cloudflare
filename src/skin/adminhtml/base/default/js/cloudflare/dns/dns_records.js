const $ = require ("jquery")
const cloudflare = require ("cloudflare/common");
const notification = require ("cloudflare/core/notification")
const modal = require ("cloudflare/core/modal")

function secondsToAppropriate ( seconds ) {
	if ( seconds == 1 ) return "Automatic";
	if ( seconds < 60 ) return seconds + " seconds";
	if ( seconds == 60 ) return "1 minute";
	if ( seconds < 3600 ) return seconds / 60 + " minutes";
	if ( seconds == 3600 ) return "1 hour";
	if ( seconds < 216000 ) return seconds / 3600 + " hours";
	if ( seconds = 216000 ) return "1 day";
	return seconds / 216000 + " days";
}

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
			.append ( entry.type == "MX" ? `<div class="priority" >${entry.priority}</div>` : "" )
		)
		$( row ).append ( $("<td>")
			.attr ( "class", "ttl" )
			.text ( secondsToAppropriate ( entry.ttl ) )
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
				$( data.section ).find ("[name='name'],[name='content']").val ("")
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
						.append ( entry.type == "MX" ? `<div class="priority" >${entry.priority}</div>` : "" )
					)
					$( row ).append ( $("<td>")
						.attr ( "class", "ttl" )
						.text ( secondsToAppropriate ( entry.ttl ) )
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
	confirm.addRow ( "Priority", $("<input type='text' placeholder='1' name='priority' >").val ( $(document).find (".priority.add").val () ) )
	confirm.addButtons ()
	confirm.addCancel ( confirm.close )
	var that = this;
	confirm.addSave ( function ( components ) {
		$(that).val ( $( components.container ).find ("input[name='server']").val () )
		var priority = $( components.container ).find ("input[name='priority']").val ()
		if ( priority.trim () === "" ) priority = "1"
		$(document).find (".priority.add").val ( priority )
		confirm.close ()
	})
	confirm.show ()
})

$(document).on ( "focus", ".show-form-loc", function () {
	var that = this
	var confirm = new modal.Modal ()
	var latitude = modal.createRows (
		modal.createRow ( "degrees", modal.createInput ( "text", "lat-degrees", "", "0" ) ),
		modal.createRow ( "minutes", modal.createInput ( "text", "lat-minutes", "", "0" ) ),
		modal.createRow ( "seconds", modal.createInput ( "text", "lat-seconds", "", "0" ) ),
		modal.createRow ( "direction", modal.createSelect ( "lat-direction", [
			{ "value": "N", "label": "North", "selected": true },
			{ "value": "S", "label": "South" }
		]))
	)
	var longitude = modal.createRows (
		modal.createRow ( "degrees", modal.createInput ( "text", "lon-degrees", "", "0" ) ),
		modal.createRow ( "minutes", modal.createInput ( "text", "lon-minutes", "", "0" ) ),
		modal.createRow ( "seconds", modal.createInput ( "text", "lon-seconds", "", "0" ) ),
		modal.createRow ( "direction", modal.createSelect ( "lon-direction", [
			{ "value": "W", "label": "West", "selected": true },
			{ "value": "E", "label": "East" }
		]))
	)
	var percision = modal.createRows (
		modal.createRow ( "horizontal precision", modal.createInput ( "text", "pre-horizontal", false, "0" ) ),
		modal.createRow ( "vertical precision", modal.createInput ( "text", "pre-vertical", false, "0" ) )
	)
	var altitude = modal.createInput ( "text", "altitude", false, "0" )
	var size = modal.createInput ( "text", "size", false, "0" )
	var matches = $(this).val ().match (/^IN LOC ([^ ]+) ([^ ]+) ([^ ]+) ([NS]) ([^ ]+) ([^ ]+) ([^ ]+) ([WE]) ([^ ]+)m ([^ ]+)m ([^ ]+)m ([^ ]+)m$/)
	if ( matches ) {
		$(latitude).find ("[name='lat-degrees']").val ( matches [ 1 ] )
		$(latitude).find ("[name='lat-minutes']").val ( matches [ 2 ] )
		$(latitude).find ("[name='lat-seconds']").val ( matches [ 3 ] )
		$(latitude).find ("[name='lat-direction']").val ( matches [ 4 ] )
		$(longitude).find ("[name='lon-degrees']").val ( matches [ 5 ] )
		$(longitude).find ("[name='lon-minutes']").val ( matches [ 6 ] )
		$(longitude).find ("[name='lon-seconds']").val ( matches [ 7 ] )
		$(longitude).find ("[name='lon-direction']").val ( matches [ 8 ] )
		$(altitude).val ( matches [ 9 ] )
		$(size).val ( matches [ 10 ] )
		$(percision).find ("[name='pre-horizontal']").val ( matches [ 11 ] )
		$(percision).find ("[name='pre-vertical']").val ( matches [ 12 ] )
	}
	confirm.addTitle ( "Add Record: LOC content", $(this).val () )
	confirm.addRow ( "Latitude", latitude, true )
	confirm.addRow ( "Longitude", longitude, true )
	confirm.addRow ( "Altitude (in meters)", altitude, true )
	confirm.addRow ( "Size (in meters)", size, true )
	confirm.addRow ( "Percision (in meters)", percision, true )
	confirm.addButtons ()
	confirm.addCancel ( confirm.close )
	confirm.addSave ( function ( components ) {
		var latDegrees = $( components.container ).find ("[name='lat-degrees']").val ().trim ()
		var latMinutes = $( components.container ).find ("[name='lat-minutes']").val ().trim ()
		var latSeconds = $( components.container ).find ("[name='lat-seconds']").val ().trim ()
		var latDirection = $( components.container ).find ("[name='lat-direction']").val ().trim ()
		var lonDegrees = $( components.container ).find ("[name='lon-degrees']").val ().trim ()
		var lonMinutes = $( components.container ).find ("[name='lon-minutes']").val ().trim ()
		var lonSeconds = $( components.container ).find ("[name='lon-seconds']").val ().trim ()
		var lonDirection = $( components.container ).find ("[name='lon-direction']").val ().trim ()
		var altitude = $( components.container ).find ("[name='altitude']").val ().trim ()
		var size = $( components.container ).find ("[name='size']").val ().trim ()
		var preHorizontal = $( components.container ).find ("[name='pre-horizontal']").val ().trim ()
		var preVertical = $( components.container ).find ("[name='pre-vertical']").val ().trim ()
		$(that).val (`IN LOC ${latDegrees} ${latMinutes} ${latSeconds} ${latDirection} ${lonDegrees} ${lonMinutes} ${lonSeconds} ${lonDirection} ${altitude}m ${size}m ${preHorizontal}m ${preVertical}m`)
		confirm.close ()
	})
	confirm.show ()
})

$(document).on ( "focus", ".show-form-srv-name", function () {
	var that = this;
	var confirm = new modal.Modal ()
	var service = modal.createInput ( "text", "service", "_sip" )
	var protocol = $("<select name='protocol' ><option value='_udp' >UDP</option><option value='_tcp' >TCP</option><option value='_tls' selected >TLS</option><select/>")
	var name = modal.createInput ( "text", "name", "@" )
	var matches = $(this).val ().match (/^([^ ]+)\.([^ ]+)\.(.+)\.$/)
	if ( matches ) {
		$(service).val ( matches [ 1 ] )
		$(protocol).val ( matches [ 2 ] )
		$(name).val ( matches [ 3 ] )
	}
	confirm.addTitle ( "Add Record: SRV name", $(this).val () )
	confirm.addRow ( "Service name", service )
	confirm.addRow ( "Protocol", protocol )
	confirm.addRow ( "Name", name )
	confirm.addButtons ()
	confirm.addCancel ( confirm.close )
	confirm.addSave ( function ( components ) {
		var service = $( components.container ).find ("input[name='service']").val ().trim () || "_sip"
		var protocol = $( components.container ).find ("select[name='protocol']").val ().trim ()
		var name = $( components.container ).find ("input[name='name']").val ().trim () || "@"
		$(that).val (`${service}.${protocol}.${name}.`)
		confirm.close ()
	})
	confirm.show ()
})

$(document).on ( "focus", ".show-form-srv", function () {
	var that = this;
	var confirm = new modal.Modal ()
	var priority = modal.createInput ( "text", "priority", "1", "1" )
	var weight = modal.createInput ( "text", "weight", "10", "1" )
	var port = modal.createInput ( "text", "port", "8444", "1" )
	var target = modal.createInput ( "text", "target", "example.com", "@" )
	var matches = $(this).val ().match (/^SRV ([^ ]+) ([^ ]+) ([^ ]+) (.+)$/)
	if ( matches ) {
		$(priority).val ( matches [ 1 ] )
		$(weight).val ( matches [ 2 ] )
		$(port).val ( matches [ 3 ] )
		$(target).val ( matches [ 4 ] )
	}
	confirm.addTitle ( "Add Record: SRV content", $(this).val () )
	confirm.addRow ( "Priority", priority )
	confirm.addRow ( "Weight", weight )
	confirm.addRow ( "Port", port )
	confirm.addRow ( "Target", target )
	confirm.addButtons ()
	confirm.addCancel ( confirm.close )
	confirm.addSave ( function ( components ) {
		var priority = $( components.container ).find ("input[name='priority']").val ().trim () || "1"
		var weight = $( components.container ).find ("input[name='weight']").val ().trim () || "1"
		var port = $( components.container ).find ("input[name='port']").val ().trim () || "1"
		var target = $( components.container ).find ("input[name='target']").val ().trim () || "@"
		$(that).val (`SRV ${priority} ${weight} ${port} ${target}`)
		$(document).find (".priority.add").val ( priority )
		confirm.close ()
	})
	confirm.show ()
})

$(document).on ( "focus", ".show-form-spf", function () {
	var that = this
	var confirm = new modal.Modal ()
	var policy = modal.createTextarea ( "policy", "Policy parameters", $(this).val () )
	confirm.addTitle ( "Add Record: SPF content", $(this).val () )
	confirm.addRow ( "Content", policy, true )
	confirm.addButtons ()
	confirm.addCancel ( confirm.close )
	confirm.addSave ( function ( components ) {
		var policy = $( components.container ).find ("[name='policy']").val ()
		$(that).val ( policy )
		confirm.close ()
	})
	confirm.show ()
})

$(document).on ( "focus", ".show-form-txt", function () {
	var that = this
	var confirm = new modal.Modal ()
	var text = modal.createTextarea ( "text", "Text", $(this).val () )
	confirm.addTitle ( "Add Record: TXT content", $(this).val () )
	confirm.addRow ( "Content", text, true )
	confirm.addButtons ()
	confirm.addCancel ( confirm.close )
	confirm.addSave ( function ( components ) {
		var text = $( components.container ).find ("[name='text']").val ()
		console.log ( text )
		$(that).val ( text )
		confirm.close ()
	})
	confirm.show ()
})

$(document).on ( "focus", ".show-form-caa", function () {
	var that = this
	var confirm = new modal.Modal ( true )
	var tag = modal.createSelect ( "tag", [
		{ label: "Only allow specific hostnames", value: "issue", selected: true },
		{ label: "Only allow wildcards", value: "issuewild" },
		{ label: "Send violation reports to URL (http:, https:, or mailto:)", value: "iodef" }
	])
	var value = modal.createInput ( "text", "value", "Certificate authority (CA) domain name" )
	var matches = $(this).val ().match (/0 ((?:issue|issuewild|iodef)) \"(.+)\"/)
	if ( matches ) {
		$(tag).val ( matches [ 1 ] )
		$(value).val ( matches [ 2 ] )
	}
	confirm.addTitle ( "Add Record: CAA content", $(this).val () )
	confirm.addRow ( "Tag", tag )
	confirm.addRow ( "Value", value )
	confirm.addButtons ()
	confirm.addCancel ( confirm.close )
	confirm.addSave ( function ( components ) {
		var tag = $( components.container ).find ("[name='tag']").val ().trim ()
		var value = $( components.container ).find ("[name='value']").val ().trim ()
		$(that).val (`0 ${tag} "${value}"`)
		confirm.close ()
	})
	confirm.show ()
})
