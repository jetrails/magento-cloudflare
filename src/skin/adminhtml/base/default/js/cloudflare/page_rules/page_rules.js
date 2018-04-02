import $ from "jquery"
import "jquery-ui/ui/widgets/sortable"

const notification = require ("cloudflare/core/notification")
const modal = require ("cloudflare/core/modal")
const common = require ("cloudflare/common")

function createRow ( previousExists = false ) {
	var close = $("<div class='cloudflare-font delete' >").html ("&#xF01A;")
	return $("<div class='dynamic_wrapper collection' >")
		.append ( modal.createSelect ( "setting", [
			{ label: "Pick a Setting", value: "pick_a_setting", disabled: true, selected: true },
			{ label: "Always Online", value: "always_online" },
			{ label: "Always Use HTTPS", value: "always_use_https", disabled: previousExists },
			{ label: "Browser Cache TTL", value: "browser_cache_ttl" },
			{ label: "Browser Integrity Check", value: "browser_check" },
			{ label: "Cache Deception Armor", value: "cache_deception_armor" },
			{ label: "Cache Level", value: "cache_level" },
			{ label: "Disable Apps", value: "disable_apps" },
			{ label: "Disable Performance", value: "disable_performance" },
			{ label: "Disable Security", value: "disable_security" },
			{ label: "Edge Cache TTL", value: "edge_cache_ttl" },
			{ label: "Email Obfuscation", value: "email_obfuscation" },
			{ label: "Forward URL", value: "forwarding_url", disabled: previousExists },
			{ label: "Automatic HTTPS Rewrites", value: "automatic_https_rewrites" },
			{ label: "IP Geolocation Header", value: "ip_geolocation" },
			{ label: "Opportunistic Encryption", value: "opportunistic_encryption" },
			{ label: "Origin Cache Control", value: "explicit_cache_control" },
			{ label: "Rocket Loader", value: "rocket_loader" },
			{ label: "Security Level", value: "security_level" },
			{ label: "Server Side Excludes", value: "server_side_exclude" },
			{ label: "SSL", value: "ssl" },
		]).addClass ("dynamic-trigger") )
		.append (
			$(`<div data-dynamic-wrapper="always_online" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="always_use_https" >`).html ("<p>Enforce HTTPS for this URL</p>")
		)
		.append (
			$(`<div data-dynamic-wrapper="browser_cache_ttl" >`).html ( modal.createSelect ( "value", [
				{ label: "Enable Browser Cache TTL", value: "", selected: true, disabled: true },
				{ label: "30 minutes", value: 1800 },
				{ label: "an hour", value: 3600 },
				{ label: "2 hours", value: 7200 },
				{ label: "3 hours", value: 10800 },
				{ label: "4 hours", value: 14400 },
				{ label: "5 hours", value: 18000 },
				{ label: "8 hours", value: 28800 },
				{ label: "12 hours", value: 43200 },
				{ label: "16 hours", value: 57600 },
				{ label: "20 hours", value: 72000 },
				{ label: "a day", value: 86400 },
				{ label: "2 days", value: 172800 },
				{ label: "3 days", value: 259200 },
				{ label: "4 days", value: 345600 },
				{ label: "5 days", value: 432000 },
				{ label: "8 days", value: 691200 },
				{ label: "16 days", value: 1382400 },
				{ label: "24 days", value: 2073600 },
				{ label: "a month", value: 2678400 },
				{ label: "2 months", value: 5356800 },
				{ label: "6 months", value: 16070400 },
				{ label: "a year", value: 31536000 }
			]))
		)
		.append (
			$(`<div data-dynamic-wrapper="browser_check" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="cache_deception_armor" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="cache_level" >`).append ( modal.createSelect ( "value", [
				{ label: "Select Cache Level", value: "" },
				{ label: "Bypass", value: "bypass" },
				{ label: "No Query String", value: "basic" },
				{ label: "Ignore Query String", value: "simplified" },
				{ label: "Standard", value: "aggressive" },
				{ label: "Cache Everything", value: "cache_everything" }
			]))
		)
		.append (
			$(`<div data-dynamic-wrapper="disable_apps" >`).html ("<p>Apps are disabled</p>")
		)
		.append (
			$(`<div data-dynamic-wrapper="disable_performance" >`).html ("<p>Performance is disabled</p>")
		)
		.append (
			$(`<div data-dynamic-wrapper="disable_security" >`).html ("<p>Security is disabled</p>")
		)
		.append (
			$(`<div data-dynamic-wrapper="edge_cache_ttl" >`).html ( modal.createSelect ( "value", [
				{ label: "Enter Edge Cache TTL", value: "", selected: true, disabled: true },
				{ label: "2 hours", value: 7200 },
				{ label: "3 hours", value: 10800 },
				{ label: "4 hours", value: 14400 },
				{ label: "5 hours", value: 18000 },
				{ label: "8 hours", value: 28800 },
				{ label: "12 hours", value: 43200 },
				{ label: "16 hours", value: 57600 },
				{ label: "20 hours", value: 72000 },
				{ label: "a day", value: 86400 },
				{ label: "2 days", value: 172800 },
				{ label: "3 days", value: 259200 },
				{ label: "4 days", value: 345600 },
				{ label: "5 days", value: 432000 },
				{ label: "6 days", value: 518400 },
				{ label: "7 days", value: 604800 },
				{ label: "14 days", value: 1209600 },
				{ label: "a month", value: 2419200 }
			]))
		)
		.append (
			$(`<div data-dynamic-wrapper="email_obfuscation" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="forwarding_url" >`)
				.html ( modal.createSelect ( "status_code", [
					{ label: "Select Status Code", value: "" },
					{ label: "301 - Permanent Redirect", value: 301 },
					{ label: "302 - Temporary Redirect", value: 302 }
				]))
				.append ( modal.createInput ( "text", "url", "Enter destination URL" ) )
		)
		.append (
			$(`<div data-dynamic-wrapper="automatic_https_rewrites" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="ip_geolocation" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="opportunistic_encryption" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="explicit_cache_control" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="rocket_loader" >`).html ( modal.createSelect ( "value", [
				{ label: "Select Value", value: "", disabled: true, selected: true },
				{ label: "Off", value: "off" },
				{ label: "Manual", value: "manual" },
				{ label: "Automatic", value: "automatic" }
			]))
		)
		.append (
			$(`<div data-dynamic-wrapper="security_level" >`).html ( modal.createSelect ( "value", [
				{ label: "Select Security Level", value: "", disabled: true, selected: true },
				{ label: "Essentially Off", value: "essentially_off" },
				{ label: "Low", value: "low" },
				{ label: "Medium", value: "medium" },
				{ label: "High", value: "high" },
				{ label: "I'm Under Attack", value: "under_attack" }
			]))
		)
		.append (
			$(`<div data-dynamic-wrapper="server_side_exclude" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="ssl" >`).html ( modal.createSelect ( "value", [
				{ label: "Select SSL Setting", value: "" },
				{ label: "Off", value: "off" },
				{ label: "Flexible", value: "flexible" },
				{ label: "Full", value: "full" },
				{ label: "Strict", value: "strict" }
			]))
		)
		.append ( close.click ( () => { $(close).parent ().remove () } ) )
}

$( document ).on ( "cloudflare.page_rules.page_rules.initialize", function ( event, data ) {
	var table = $(data.section).find ("table.rules")
	$(table).find ("tbody > tr").remove ()
	if ( data.response.payload.length > 0 ) {
		data.response.payload.map ( ( rule, index ) => {
			$(table).find ("tbody").append ( $("<tr>")
				.append ( $("<td class='handle' >").html ("&#xF000; &#xF001;") )
				.append ( $("<td>").text ( index + 1 ) )
				.append (
					$("<td class='no_white_space' >")
						.text ( rule.targets [ 0 ].constraint.value )
						.append ( $("<span>").text ( rule.actions.map ( i => { return i.id + ": " + i.value } ).join (", ") ) )
				)
				.append ( $("<td>").append (
					( () => {
						var element = modal.createSwitch ( "status", rule.status == "active" )
						$(element).find ("input")
							.addClass ("trigger")
							.data ( "target", "toggle" )
							.data ( "id", rule.id )
						return element
					}) ()
				))
				.append ( $("<td>").append ( modal.createIconButton ( "edit", "&#xF019;" ) ) )
				.append ( $("<td>").append (
					modal.createIconButton ( "delete", "&#xF01A;" ) )
						.addClass ("trigger")
						.data ( "target", "delete" )
						.data ( "id", rule.id )
				)
			)
		})
		$(table).find ("tbody").sortable ({
			handle: ".handle",
			helper: ( e, ui ) => {
			    ui.children().each(function() {
			        $(this).width($(this).width());
			    });
			    return ui;
			},
			stop: ( e, ui ) => {
				ui.item.parent ().find ("tr").each ( ( i, e ) => {
					$( e ).find ("td").eq ( 1 ).text ( i + 1 );
				})
		    }
		})
	}
	else {
		$(table).find ("tbody").append (
			$("<tr>").append (
				$("<td colspan='6' >").text ("You do not have any Page Rules yet. Click 'Create Page Rule' above to get started.")
			)
		)
	}
})

$( document ).on ( "cloudflare.page_rules.page_rules.toggle", function ( event, data ) {
	var id = data.trigger.data ("id")
	var state = $(data.trigger).is (":checked")
	$(data.section).addClass ("loading")
	$.ajax ({
		url: data.form.endpoint,
		type: "POST",
		data: { "form_key": data.form.key, "state": state, "id": id },
		success: function ( response ) {
			$(data.section).removeClass ("loading")
			notification.addMessages ( response.state, response.messages );
		}
	});
});

$( document ).on ( "cloudflare.page_rules.page_rules.delete", function ( event, data ) {
	var confirm = new modal.Modal ()
	confirm.addTitle ("Confirm")
	confirm.addElement ( $("<p>").text ("Are you sure you want to delete this page rule?") )
	confirm.addButton ({ label: "OK", callback: ( components ) => {
		confirm.close ()
		var id = data.trigger.data ("id")
		$(data.section).addClass ("loading")
		$.ajax ({
			url: data.form.endpoint,
			type: "POST",
			data: { "form_key": data.form.key, "id": id },
			success: function ( response ) {
				common.loadSections (".page_rules")
			}
		});
	}})
	confirm.addButton ({ label: "Cancel", class: "gray", callback: confirm.close })
	confirm.show ()
});

$( document ).on ( "cloudflare.page_rules.page_rules.edit", function ( event, data ) {
	console.log ( data )
});

$( document ).on ( "cloudflare.page_rules.page_rules.create", function ( event, data ) {
	var that = this
	var confirm = new modal.Modal ( 800 )
	var collections = $(`<div class="collections" >`)
	confirm.addTitle ( "Create a Page Rule for %s", $(this).val () )
	confirm.addRow (
		$(`<p>`)
			.append ( $(`<strong>`).text ("If the URL matches: ") )
			.append ( "By using the asterisk (*) character, you can create dynamic patterns that can match many URLs, rather than just one. " )
			.append ( $(`<a href="https://support.cloudflare.com/hc/en-us/articles/218411427" target="_blank" >`).text ("Learn more here") ),
		modal.createInput ( "text", "target", "Example: www.example.com/*" ),
		true
	)
	confirm.addRow (
		$(`<p>`).append ( $(`<strong>`).text ("Then the settings are:") ),
		[
			collections.append ( createRow () ),
			$(`<a class="dashed" >`).text ("+ Add a Setting").click ( () => {
				var previousExists = $(collections).find (".collection").length > 0;
				$(collections).append ( createRow ( previousExists ) )
			})
		],
		true
	)
	var saveCallback = ( components, status ) => {
		var target = $(components.container).find ("[name='target']").val ()
		var actions = $.makeArray ( $( components.container )
			.find (".collections > .collection")
			.map ( ( i, e ) => {
				var id = $(e).find ("[name='setting']").val ()
				var value = $(components.container).find ("[data-dynamic-wrapper='" + id + "']").find ("[name='value']").eq ( 0 )
				value = $(value).is (":checkbox") ? ( $(value).is (":checked") ? "on" : "off" ) : $(value).val ()
				if ( id == "forwarding_url" ) value = {
					url: $(components.container).find ("[data-dynamic-wrapper='" + id + "']").find ("[name='url']").eq ( 0 ).val (),
					status_code: $(components.container).find ("[data-dynamic-wrapper='" + id + "']").find ("[name='status_code']").eq ( 0 ).val ()
				}
				return { id, value }
			}));
		$(components.modal).addClass ("loading")
		$.ajax ({
			url: data.form.endpoint,
			type: "POST",
			data: {
				"form_key": data.form.key,
				"target": target,
				"actions": actions,
				"status": status
			},
			success: function ( response ) {
				if ( response.state == "response_success" ) {
					confirm.close ()
					$(components.modal).removeClass ("loading")
					$(data.section).addClass ("loading")
					common.loadSections (".page_rules")
				}
				else {
					$(components.modal).removeClass ("loading")
					notification.addMessages ( response.state, response.messages );
				}
			}
		});
	}
	confirm.addButton ({ label: "Cancel", class: "gray", callback: confirm.close })
	confirm.addButton ({ label: "Save as Draft", class: "gray", callback: ( components ) => { saveCallback ( components, false ) } })
	confirm.addButton ({ label: "Save and Deploy", callback: ( components ) => { saveCallback ( components, true ) } })
	confirm.show ()
});

$(document).on ( "change", ".cloudflare_modal .collection [name='setting']", function () {
	if ( $(this).val () == "forwarding_url" || $(this).val () == "always_use_https" ) {
		$(".cloudflare_modal a.dashed").hide ();
	}
	else {
		$(".cloudflare_modal a.dashed").show ();
	}
});