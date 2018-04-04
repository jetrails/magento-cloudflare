const $ = require ("jquery")
const cloudflare = require ("cloudflare/common");
const common = require ("cloudflare/common");
const notification = require ("cloudflare/core/notification")
const modal = require ("cloudflare/core/modal")

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
		`${( data.response.result_info.page - 1 ) * data.response.result_info.per_page} - ${data.response.result_info.total_count} rules`
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
	data.response.result.map ( entry => {
		$(table).append ( $(`<tr>`)
			.append ( $(`<td>`).text ( entry.configuration.value ).append ( $(`<span>`).text ( entry.notes ) ) )
			.append ( $(`<td>`).html ( modal.createSelect ( "mode", [
				{ "label": "Block", "value": "block", selected: entry.mode == "block" },
				{ "label": "Challenge", "value": "challenge", selected: entry.mode == "challenge" },
				{ "label": "Whitelist", "value": "whitelist", selected: entry.mode == "whitelist" },
				{ "label": "JavaScript Challenge", "value": "js_challenge", selected: entry.mode == "js_challenge" }
			])))
			.append ( $(`<td>`).text ( entry.status ) )
		)
	})
	$(data.section).removeClass ("loading")
});

$( document ).on ( "cloudflare.firewall.access_rules.page", function ( event, data ) {
	$(data.section).addClass ("loading")
	$(data.section).data ( "page", $(data.trigger).data ("page") )
	common.loadSections (".access_rules")
});

$( document ).on ( "cloudflare.firewall.access_rules.next_page", function ( event, data ) {
	if ( $(data.section).data ("page") + 1 <= $(data.section).data ("page-count") ) {
		$(data.section).addClass ("loading")
		$(data.section).data ( "page", $(data.section).data ("page") + 1 )
		common.loadSections (".access_rules")
	}
});

$( document ).on ( "cloudflare.firewall.access_rules.previous_page", function ( event, data ) {
	if ( $(data.section).data ("page") - 1 > 0 ) {
		$(data.section).addClass ("loading")
		$(data.section).data ( "page", $(data.section).data ("page") - 1 )
		common.loadSections (".access_rules")
	}
});
