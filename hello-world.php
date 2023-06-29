<?php

/**
 * @package Hello World
 * @version 1.0.0
 */
/*
Plugin Name: Hello World
Plugin URI: https://github.com/kurtgrung/hello-world/
Description: Hello World plugin :)
Author: Kurt Grüng
Version: 1.0.0
Author URI: https://github.com/kurtgrung
*/

function get_hello_world() {
	$hello_world = "Hello World Plugin";
	return wptexturize( $hello_world ); // wptexturize, Replaces common plain text characters with formatted entities.
}

// hello_world function
function hello_world() {
	$helloworld = get_hello_world();
	printf(
		'<p id="helloworld"><span>%s</span><span>%s</span></p>',
		__( '"Print out from the script" - ' ),
		$helloworld
	);
}

// Executes the hello_world function, when admin_notices action is called.
// add_action( 'admin_notices', 'hello_world' );

// The add_filter hook calls the plguin automatically if installed. the_content hook replaces the content.
add_filter('the_content', 'hello_world');


// Database "prepare" function INSERT to protect queries against SQL injection attacks.
function perform_database_action() {

	global $wpdb;

	$tablename = "table_name";

	$value1 = "Col1 value = ".rand();
	$value2 = "Col2 value = ".rand();
	$value3 = "Col3 value = ".rand();

	$sql = $wpdb->prepare("INSERT INTO `$tablename` (`col1`, `col2`, `col3`) values (%s, %s, %s)", $value1, $value2, $value3);

	if($wpdb->query($sql)){
			$response = "success";
	} else {
			$response = "failed";
	}

	printf(
		'<p id="helloworld"><span>%s</span><span>%s</span></p>',
		__( '"query" - ' ),
		$response
	);
}

// filter hook to query the database
add_filter('the_content', 'perform_database_action');

?>
