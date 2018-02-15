const $j = jQuery.noConflict ();

function submitForm ( formName ) {
	formName = formName.split ("-");
	const page = formName [ 0 ];
	const section = formName [ 1 ];
	formName = formName.join ("-");
	$j( "section." + section ).removeClass ("response_success");
	$j( "section." + section ).removeClass ("response_error");
	$j( "section." + section ).addClass ("loading");
	$j( "section." + section ).find (".messages").text ("");


	setTimeout ( function () {
		if ( Math.random () < 0.5 ) {
			$j( "section." + section ).removeClass ("loading");
			$j( "section." + section ).addClass ("response_success");
			$j( "section." + section ).find (".messages").text ("Request was made successfully");
		}
		else {
			$j( "section." + section ).removeClass ("loading");
			$j( "section." + section ).addClass ("response_error");
			$j( "section." + section ).find (".messages").text ("An error was encountered while making the request");
		}
	}, 3000 );

}
