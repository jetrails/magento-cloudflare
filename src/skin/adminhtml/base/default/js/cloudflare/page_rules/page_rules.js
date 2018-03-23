const $ = require ("jquery")
const notification = require ("cloudflare/core/notification")
const modal = require ("cloudflare/core/modal")

$( document ).on ( "cloudflare.page_rules.page_rules.create", function ( event, data ) {
	var that = this
	var confirm = new modal.Modal ( 800 )
	var close = $("<div class='cloudflare-font delete' >").html ("&#xF01A;")
	var row = $("<div class='dynamic_wrapper collection' >")
		.append ( modal.createSelect ( "setting", [
			{ label: "Pick a Setting", value: "pick_a_setting" },
			{ label: "Always Online", value: "always_online" },
			{ label: "Always Use HTTPS", value: "always_use_https" },
			{ label: "Browser Cache TTL", value: "browser_cache_ttl" },
			{ label: "Browser Integrity Check", value: "browser_integrity_check" },
			{ label: "Cache Deception Armor", value: "cache_deception_armor" },
			{ label: "Cache Level", value: "cache_level" },
			{ label: "Disable Apps", value: "disable_apps" },
			{ label: "Disable Performance", value: "disable_performance" },
			{ label: "Disable Security", value: "disable_security" },
			{ label: "Edge Cache TTL", value: "edge_cache_ttl" },
			{ label: "Email Obfuscation", value: "email_obfuscation" },
			{ label: "Forward URL", value: "forward_url" },
			{ label: "Automatic HTTPS Rewrites", value: "automatic_https_rewrites" },
			{ label: "IP Geolocation Header", value: "ip_geolocation_header" },
			{ label: "Opportunistic Encryption", value: "opportunistic_encryption" },
			{ label: "Origin Cache Control", value: "origin_cache_control" },
			{ label: "Rocket Loader", value: "rocket_loader" },
			{ label: "Security Level", value: "security_level" },
			{ label: "Server Side Excludes", value: "server_side_excludes" },
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
				{ label: "Enable Browser Cache TTL", value: "" },
				{ label: "30 minutes", value: "" },
				{ label: "an hour", value: "" },
				{ label: "2 hours", value: "" },
				{ label: "3 hours", value: "" },
				{ label: "4 hours", value: "" },
				{ label: "5 hours", value: "" },
				{ label: "8 hours", value: "" },
				{ label: "12 hours", value: "" },
				{ label: "16 hours", value: "" },
				{ label: "20 hours", value: "" },
				{ label: "a day", value: "" },
				{ label: "2 days", value: "" },
				{ label: "3 days", value: "" },
				{ label: "4 days", value: "" },
				{ label: "5 days", value: "" },
				{ label: "8 days", value: "" },
				{ label: "16 days", value: "" },
				{ label: "24 days", value: "" },
				{ label: "a month", value: "" },
				{ label: "2 months", value: "" },
				{ label: "6 months", value: "" },
				{ label: "a year", value: "" }
			]))
		)
		.append (
			$(`<div data-dynamic-wrapper="browser_integrity_check" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="cache_deception_armor" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="cache_level" >`).append ( modal.createSelect ( "value", [
				{ label: "Select Cache Level", value: "" },
				{ label: "Bypass", value: "" },
				{ label: "No Query String", value: "" },
				{ label: "Ignore Query String", value: "" },
				{ label: "Standard", value: "" },
				{ label: "Cache Everything", value: "" }
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
				{ label: "Enter Edge Cache TTL", value: "" },
				{ label: "2 hours", value: "" },
				{ label: "3 hours", value: "" },
				{ label: "4 hours", value: "" },
				{ label: "5 hours", value: "" },
				{ label: "8 hours", value: "" },
				{ label: "12 hours", value: "" },
				{ label: "16 hours", value: "" },
				{ label: "20 hours", value: "" },
				{ label: "a day", value: "" },
				{ label: "2 days", value: "" },
				{ label: "3 days", value: "" },
				{ label: "4 days", value: "" },
				{ label: "5 days", value: "" },
				{ label: "6 days", value: "" },
				{ label: "7 days", value: "" },
				{ label: "14 days", value: "" },
				{ label: "a month", value: "" }
			]))
		)
		.append (
			$(`<div data-dynamic-wrapper="email_obfuscation" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="forward_url" >`)
				.html ( modal.createSelect ( "code", [
					{ label: "Select Status Code", value: "" },
					{ label: "2 hours", value: "" },
					{ label: "3 hours", value: "" }
				]))
				.append ( modal.createInput ( "text", "value", "Enter destination URL" ) )
		)
		.append (
			$(`<div data-dynamic-wrapper="automatic_https_rewrites" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="ip_geolocation_header" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="opportunistic_encryption" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="origin_cache_control" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="rocket_loader" >`).html ( modal.createSelect ( "value", [
				{ label: "Select Value", value: "" },
				{ label: "Off", value: "" },
				{ label: "Manual", value: "" },
				{ label: "Automatic", value: "" }
			]))
		)
		.append (
			$(`<div data-dynamic-wrapper="security_level" >`).html ( modal.createSelect ( "value", [
				{ label: "Select Security Level", value: "" },
				{ label: "Essentially Off", value: "" },
				{ label: "Low", value: "" },
				{ label: "Medium", value: "" },
				{ label: "High", value: "" },
				{ label: "I'm Under Attack", value: "" }
			]))
		)
		.append (
			$(`<div data-dynamic-wrapper="server_side_excludes" >`).append ( modal.createSwitch ("value") )
		)
		.append (
			$(`<div data-dynamic-wrapper="ssl" >`).html ( modal.createSelect ( "value", [
				{ label: "Select SSL Setting", value: "" },
				{ label: "Off", value: "" },
				{ label: "Flexible", value: "" },
				{ label: "Full", value: "" },
				{ label: "Strict", value: "" }
			]))
		)
		.append ( close.click ( () => { $(close).parent ().remove () } ) )
	confirm.addTitle ( "Create a Page Rule for %s", $(this).val () )
	confirm.addRow (
		`<p>
			<strong>If the URL matches:</strong>
			By using the asterisk (*) character, you can create dynamic patterns that can match many URLs, rather than just one.
			<a href="https://support.cloudflare.com/hc/en-us/articles/218411427" target="_blank" >Learn more here</a>
		</p>`,
		modal.createInput ( "text", "pattern", "Example: www.example.com/*" ),
		true
	)
	confirm.addRow ( null, row, true )
	confirm.addRow (
		`<p><strong>Then the settings are:</strong></p>`,
		$(`<a class="dashed" >`).text ("+ Add a Setting").click ( () => { $(document).find (".collection").append ( row ) } ),
		true
	)
	confirm.addButtons ()
	confirm.addCancel ( confirm.close )
	confirm.addSave ( function ( components ) {
		confirm.close ()
	})
	confirm.show ()
});
