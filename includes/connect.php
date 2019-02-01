<?php		
	// connect to the DB
	$con = mysqli_connect("localhost", "username", "password", "db_name");

	// test for successful DB connection
	if(mysqli_connect_errno()){
		echo "Failed to connect to MySQL: ". mysqli_connect_error();
	}

	// Stops SQL Injection in POST vars
	// also creates a variable for each database column field
	foreach ($_POST as $key => $value) {
	 	$_POST[$key] = mysqli_real_escape_string($con,$value);
		 // variable variables
		 $$key = strip_tags(trim($value));
	} 

	//This stops SQL Injection in GET vars 
	foreach ($_GET as $key => $value) { 
	  	$_GET[$key] = mysqli_real_escape_string($con, $value); 
	}
?>