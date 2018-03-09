const $ = require ("jquery")

function addMessage ( type, message ) {
	if ( $(".cloudflare_notification").length == 0 ) {
		$("body").append ( $("<div class='cloudflare_notification' >") )
	}
	icon = type == "response_success" ? "&#xF004;" : "&#xF006;";
	type = type == "response_success" ? "response_success" : "response_error";
	const notification = $("<div class='notification " + type + "' >")
		.append ( $("<span class='message' >").text ( message ) )
		.append ( $("<span class='progress' >") )
		.append ( $("<span class='cloudflare-icon close' >").html ("&#xF01A;") )
		.append ( $("<i class='cloudflare-icon status' >").html ( icon ) )
	$(".cloudflare_notification").append ( notification );
	setTimeout ( function () {
		$( notification ).addClass ("auto_remove");
	}, 200 );
	var timeout = setTimeout ( function () {
		$( notification ).remove ();
	}, 10200 );
	$( notification ).on ( "click", function () {
		$( this ).removeClass ("auto_remove");
		$( this ).addClass ("locked");
		clearTimeout ( timeout );
	});
	$( notification ).on ( "mouseover", function () {
		if ( !$( this ).hasClass ("locked") ) {
			$( this ).removeClass ("auto_remove");
			clearTimeout ( timeout );
		}
	});
	$( notification ).on ( "mouseout", function () {
		if ( !$( this ).hasClass ("locked") ) {
			$( this ).addClass ("auto_remove");
			clearTimeout ( timeout );
			timeout = setTimeout ( function () {
				$( notification ).remove ();
			}, 10000 );
		}
	});
	$( notification ).find (".close").on ( "click", function () {
		clearTimeout ( timeout );
		$( this ).parent ().remove ();
	});
}

function addMessages ( type, messages ) {
	if ( !Array.isArray ( messages ) ) messages = [ messages ];
	messages.map ( ( message ) => {
		addMessage ( type, message )
	});
}

function addSuccess ( message ) {
	addMessages ( "response_success", message );
}

function addError ( message ) {
	addMessages ( "response_error", message );
}

function clearMessages () {
	$(".cloudflare_notification").find (".notification").remove ();
}

module.exports = {
	clear: clearMessages,
	addMessage: addMessage,
	addMessages: addMessages,
	addSuccess: addSuccess,
	addError: addError
}
