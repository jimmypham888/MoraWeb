<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style( 'mora-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ) );

	wp_enqueue_script( 'mora-script',
		get_stylesheet_directory_uri() . '/assets/js/script.js',
			array( 'jquery' ),
			null,
			true );

	$whitelist = array(
		'127.0.0.1',
		'::1'
	);
	
	if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
		// Enqueue BS Script for Dev.
		$url = sprintf( 'http://%s:3000/browser-sync/browser-sync-client.js', $_SERVER['SERVER_NAME'] );
		$ch  = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$header = curl_exec( $ch );
		curl_close( $ch );
		if ( $header && strpos( $header[0], '400' ) === false ) {
			wp_enqueue_script( '__bs_script__', $url, array(), null, true );
		}
	}
}