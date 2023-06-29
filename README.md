# wp-php-isssues


**1. Assuming there is a file named "w-content/plugins/hello-world.php" with the following content. What is this missing to be called a plugin and run properly?**
```php
~~<?php add_filter('the_content', 'hello_world');
function hello_world($content){
return $content . " Hello World ";
}~~
```

**Answer >**
Please see the attached "hello-world.php" file.
Thats how you would convert it to a plugin.
I added some comments to the code.


**2. What is a potential problem in the following snippet of code from a WordPress theme file named "footer.php"?**
```html
~~</section><!-end of body section--> <footer>All rights reserved</footer>
</body>
</htm|>~~
```

**Answer >**
The HTML Element Reference has the incorrect HTML it has a vertical bar "|" in the ```</html>``` closing tag.

I don't know what the rest of the Theme code structure looks like theres a closing ```</section>``` tag too.
So its impossible to know if thats also incorrect.  


**3. What is wrong with this script?**
```php
~~add_my_script();
function add_my_script(){
wp_enqueue_script(
'jquery-my-script',
plugin_dir_url( __FILE__ ).'js/jquery-my-script.js'
);
}~~
```

**Answer >**
If you using **“wp_enqueue_script”** function you need to pass a URI() not an absolute DIR (directory).

* Presuming this is run from the Theme **“functions.php”** file.

The path is incorrect -
```plugin_dir_url( __FILE__ ).'js/jquery-my-script.js'```

Points to (in my local development environment) -
```http://domain/wp-content/plugins/Users/kurt/Local Sites/drew/app/public/wp-content/themes/themename/js/jquery-my-script.js```

So you could use **“get_template_directory_uri()”**

**Updated snippet -**
```php
// updated snippet
function add_my_script(){
	// wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
	wp_enqueue_script(
		'jquery-my-script',
		get_template_directory_uri() .'/js/jquery-my-script.js'
	);
}
add_my_script();
```

**4. What is the $wed variable and how could you improve the code below?**
```php
~~<?php
function perform database action({
mysql_query("INSERT into table_name (col1, col2, col3) VALUES ('$value1', '$value2', '$value3");
}~~
```

**$wpdb** is essentially the Wordpress database connection class.

Use the **“prepare”** function to protect queries against SQL injection attacks. 

**Answer >**
```php
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
```
