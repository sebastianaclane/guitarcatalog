<?php
	include("connect.php");

	$thisFile = basename($_SERVER['PHP_SELF']);

	switch($thisFile) {
		case "insert.php";
			$thisPageTitle = "Insert";
			break;
		case "login.php";
			$thisPageTitle = "Login";
			break;
		case "edit.php";
			$thisPageTitle = "Edit";
			break;
		default:
			$thisPageTitle = "Insert";
			break;
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<meta http-equiv="x-ua-compatible" content="ie=edge" />
		<title><?php echo $thisPageTitle; ?></title>
		<meta name="description" content="TODO: Description" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="author" content="Sebastian Lane" />
		<link rel="stylesheet" type="text/css" href="http://sebastianlane.ca/projects/guitarcatalog/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="http://sebastianlane.ca/projects/guitarcatalog/css/main.css">
	    <link rel="icon" type="image/png" href="http://sebastianlane.ca/projects/guitarcatalog/images/favicomatic/favicon-32x32.png?v=2" sizes="32x32" />
	    <link rel="icon" type="image/png" href="http://sebastianlane.ca/projects/guitarcatalog/images/favicomatic/favicon-16x16.png?v=2" sizes="16x16" />
	</head>

<body>
	<header>
		<p class="header-title">Admin</p>

		<nav>
			<ul>
				<li><a href="insert.php">Insert Guitars</a></li>
				<li><a href="edit.php">Edit Guitars</a></li>
				<li><a href="http://sebastianlane.ca/projects/guitarcatalog/index.php">Public</a></li>
			</ul>
		</nav>
	</header>

	<main>
    
    <!--
   		PAGE CONTENT HERE
    -->