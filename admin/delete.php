<?php
	// don't want this to show anything to the user, only for pure functionality
	include("../includes/connect.php");

	$guitar_id = $_GET['id'];

	// now, let's write our DELETE statement. It MUST have a WHERE clause
	$result = mysqli_query($con, "DELETE FROM guitar_catalog WHERE guitar_id = '$guitar_id'") or die(mysqli_error());

	// redirect the user back to the edit.php page to see that a guitar has been deleted
	header("Location:edit.php");
?>