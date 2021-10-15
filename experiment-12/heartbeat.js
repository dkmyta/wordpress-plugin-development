jQuery( document ).on( 'heartbeat-send', function ( event, data ) {

	// Send a random number to the server.
	data.pdev_random_number = Math.random();
} );

jQuery( document ).on( 'heartbeat-tick', function ( event, data ) {

	// If no data, bail.
	if ( ! data.pdev_random_number ) {
		return;
	}

	alert( 'The random number is ' + data.pdev_random_number );
} );
