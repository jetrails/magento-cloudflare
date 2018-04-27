const $ = require ("jquery")
const cloudflare = require ("cloudflare/common")
const common = require ("cloudflare/common")
const notification = require ("cloudflare/core/notification")
const modal = require ("cloudflare/core/modal")

function populateResult ( table, results ) {
	results.map ( entry => {
		$(table).append ( $(`<tr>`)
			.append ( $(`<td>`)
				.text ( entry.configuration.value )
				.append ( $(`<span>`).text ( entry.notes ) )
				.css ({ width: "100%" })
			)
			.append ( $(`<td>`).text ("This website") )
			.append ( $(`<td>`).css ( "display", "flex" )
				.html ( modal.createSelect ( "mode", [
						{ "label": "Block", "value": "block", selected: entry.mode == "block" },
						{ "label": "Challenge", "value": "challenge", selected: entry.mode == "challenge" },
						{ "label": "Whitelist", "value": "whitelist", selected: entry.mode == "whitelist" },
						{ "label": "JavaScript Challenge", "value": "js_challenge", selected: entry.mode == "js_challenge" }
					])
					.css ({ minWidth: "200px" })
					.addClass ("trigger-select")
					.data ( "target", "mode" )
					.data ( "id", entry.id )
				)
				.append ( modal.createIconButton ( "trigger edit", "&#xF013;" )
					.data ( "id", entry.id )
					.data ( "note", entry.notes )
					.data ( "target", "edit" )
				)
				.append ( modal.createIconButton ( "trigger delete", "&#xF01A;" )
					.data ( "id", entry.id )
					.data ( "target", "delete" )
				)
			)
		)
	})
	if ( results.length == 0 ) {
		$(table).append ( $("<tr>").append ( $("<td colspan='6' >").text ("No access rules found.") ) );
	}
}

$( document ).on ( "cloudflare.firewall.access_rules.initialize", function ( event, data ) {
	let section = $(data.section)
	let table = $(data.section).find ("table > tbody")
	let currentPage = data.response.result_info.page
	$(section).data ( "count", data.response.result_info.count )
	$(section).data ( "count_total", data.response.result_info.total_count )
	$(section).data ( "page", data.response.result_info.page )
	$(section).data ( "page-count", data.response.result_info.total_pages )
	$(section).data ( "page-size", data.response.result_info.per_page )
	$(section).find (".pagination_container .pages").html ("")
	$(section).find (".pagination_container .showing").html (
		`${data.response.result_info.per_page * ( data.response.result_info.page - 1 )} - ${ Math.min ( data.response.result_info.per_page * data.response.result_info.page, data.response.result_info.total_count )} of ${data.response.result_info.total_count} rules`
	)
	for ( let i = 1; i <= data.response.result_info.total_pages; i++ ) {
		$(section).find (".pagination_container .pages").append (
			$(`<span class="trigger page" >`)
				.addClass ( i == currentPage ? "current" : "" )
				.data ( "target", "page" )
				.data ( "page", i )
				.text ( i )
		)
	}
	$(table).html ("")
	$(data.section).data ( "result", data.response.result )
	populateResult ( table, data.response.result )
	$(data.section).removeClass ("loading")
})

$( document ).on ( "cloudflare.firewall.access_rules.search", function ( event, data ) {
	let table = $(data.section).find ("table > tbody")
	let searchTerm = $(data.trigger).val ().toLowerCase ().trim ()
	var results = $(data.section).data ("result").filter ( entry => {
		return entry.notes.toLowerCase ().indexOf ( searchTerm ) > -1
			|| entry.configuration.value.toLowerCase ().indexOf ( searchTerm ) > -1
	})
	$(table).children ().remove ()
	populateResult ( table, results )
})

$( document ).on ( "cloudflare.firewall.access_rules.add", function ( event, data ) {
	$(data.section).addClass ("loading")
	var value = $(data.section).find ("[name='value']").val ()
	var mode = $(data.section).find ("[name='mode']").val ()
	var note = $(data.section).find ("[name='note']").val ()
	var target = ""
	switch ( true ) {
		case /[0-9]+(?:\.[0-9]+){3}\/[0-9]+/.test ( value ):
			target = "ip_range"
			break
		case /[0-9]+(?:\.[0-9]+){3}/.test ( value ):
			target = "ip"
			break
		case /AS[0-9]+/.test ( value ):
			target = "asn"
			break
		default:
			target = "country"
	}
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: {
			"form_key": data.form.key,
			"target": target,
			"value": value,
			"mode": mode,
			"note": note
		},
		success: function ( response ) {
			$(data.section).addClass ("loading")
			$(data.section).find ("[name='value']").val ("")
			$(data.section).find ("[name='mode']").val ("block")
			$(data.section).find ("[name='note']").val ("")
			common.loadSections (".access_rules")
		}
	})
	common.loadSections (".access_rules")
})

$( document ).on ( "cloudflare.firewall.access_rules.delete", function ( event, data ) {
	var confirm = new modal.Modal ()
	confirm.addTitle ("Confirm")
	confirm.addElement ( $("<p>").text (`Are you sure you want to delete this rule?`) )
	confirm.addButton ({ label: "OK", callback: ( components ) => {
		confirm.close ()
		$(data.section).addClass ("loading")
		var id = $(data.trigger).data ("id")
		$.ajax ({
			url: data.form.endpoint,
			type: "POST",
			data: { "form_key": data.form.key, "id": id },
			success: function ( response ) {
				common.loadSections (".access_rules")
			}
		})
	}})
	confirm.addButton ({ label: "Cancel", class: "gray", callback: confirm.close })
	confirm.show ()
})

$( document ).on ( "cloudflare.firewall.access_rules.mode", function ( event, data ) {
	$(data.section).addClass ("loading")
	var id = $(data.trigger).data ("id")
	var mode = $(data.trigger).val ()
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "id": id, "mode": mode },
		success: function ( response ) {
			common.loadSections (".access_rules")
		}
	})
})

$( document ).on ( "cloudflare.firewall.access_rules.edit", function ( event, data ) {
	let notes = modal.createTextarea ( "notes", "", $(data.trigger).data ("note") ).css ({
		marginTop: "22.5px",
		fontSize: "1.1em"
	})
	let edit = new modal.Modal ( 800 )
	edit.addTitle ("Edit notes")
	edit.addElement ( notes )
	edit.addButton ({ label: "Close", class: "gray", callback: edit.close })
	edit.addButton ({ label: "Save", callback: ( components ) => {
		edit.close ()
		$(data.section).addClass ("loading")
		$.ajax ({
			url: data.form.endpoint,
			type: "POST",
			data: { "form_key": data.form.key, "id": $(data.trigger).data ("id"), "note": notes.val () },
			success: function ( response ) {
				common.loadSections (".access_rules")
			}
		})
	}})
	edit.show ()
})

$( document ).on ( "cloudflare.firewall.access_rules.page", function ( event, data ) {
	$(data.section).addClass ("loading")
	$(data.section).data ( "page", $(data.trigger).data ("page") )
	common.loadSections (".access_rules")
})

$( document ).on ( "cloudflare.firewall.access_rules.next_page", function ( event, data ) {
	if ( $(data.section).data ("page") + 1 <= $(data.section).data ("page-count") ) {
		$(data.section).addClass ("loading")
		$(data.section).data ( "page", $(data.section).data ("page") + 1 )
		common.loadSections (".access_rules")
	}
})

$( document ).on ( "cloudflare.firewall.access_rules.previous_page", function ( event, data ) {
	if ( $(data.section).data ("page") - 1 > 0 ) {
		$(data.section).addClass ("loading")
		$(data.section).data ( "page", $(data.section).data ("page") - 1 )
		common.loadSections (".access_rules")
	}
})
