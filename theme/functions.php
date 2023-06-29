<?php

// updated snippet
function add_my_script(){
	// wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
	wp_enqueue_script(
		'jquery-my-script',
		get_template_directory_uri() .'/js/jquery-my-script.js'
	);
}
add_my_script();

?>
