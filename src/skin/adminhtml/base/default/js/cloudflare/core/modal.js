const $ = require ("jquery");

function createComponents () {
	return {
		modal: $("<div class='cloudflare_modal' >"),
		container: $("<div class='container' >"),
		close: $("<div class='close cloudflare-font' >").html ("&#xF01A;")
	}
}

function bindComponents ( components ) {
	$( components.close ).on ( "click", function () {
		$( components.modal ).removeClass ("active");
		setTimeout ( function () { $( components.modal ).remove () }, 1000 );
	});
}

function render ( components ) {
	$("body").append (
		components.modal.append (
			components.container.append ( components.close )
		)
	);
}

function Modal () {
	const components = createComponents ();
	bindComponents ( components );

	return {
		components: components,
		addTitle: ( title, subTitle = "" ) => {
			let titleElement = $("<div class='title' >")
			$( components.container ).append ( titleElement.html ( title ) )
			if ( subTitle.trim () !== "" ) {
				$( titleElement ).append ( $("<div class='sub-title' >").text ( subTitle ) )
			}
		},
		addRow: ( label, element ) => {
			let row = $("<div class='row' >")
			row.append ( $("<div class='label' >").text ( label ) )
			row.append ( $("<div class='element' >").html ( element ) )
			$( components.container ).append ( row )
		},
		addParagraph: ( text ) => {
			$( components.container ).append ( $("<p>").html ( text ) );
		},
		show: () => {
			render ( components );
			setTimeout ( function () { $( components.modal ).addClass ("active") }, 200 );
		}
	}
}

function confirm () {
	var modal = $("<div class='cloudflare_modal' >");
	var container = $("<div class='container' >");
	var close = $("<div class='close' >");
	$( close ).on ( "click", function () {
		$(".cloudflare_modal").removeClass ("active");
		setTimeout ( function () { $( modal ).remove () }, 1000 );
	});
	$("body").append ( modal.append ( container.append ( close ) ) );
	setTimeout ( function () { $( modal ).addClass ("active") }, 200 );
}

module.exports = {
	Modal: Modal,
	confirm: confirm
}
