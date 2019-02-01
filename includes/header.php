<?php
	include("connect.php");

	$thisFile = basename($_SERVER['PHP_SELF']);

	switch($thisFile) {
		case "index.php";
			$thisPageTitle = "Electric Guitar Catalog Home";
			break;
		case "main-display.php";
			$thisPageTitle = "View Catalog";
			break;
		case "single-item-display.php";
			$thisPageTitle = "Single Guitar Display";
			break;
		case "search.php";
			$thisPageTitle = "Search Results";
			break;
		default:
			$thisPageTitle = "Electric Guitar Catalog Home";
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
	    <link rel="icon" type="image/png" href="http://sebastianlane.ca/projects/guitarcatalog/images/favicomatic/favicon-32x32.png?v=3" sizes="32x32" />
	    <link rel="icon" type="image/png" href="http://sebastianlane.ca/projects/guitarcatalog/images/favicomatic/favicon-16x16.png?v=3" sizes="16x16" />
	</head>

<body>
	<header>
		<p class="header-title">Electric Guitar Catalog</p>
		<nav>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="main-display.php">View Catalog</a></li>
				<li><a href="http://sebastianlane.ca/projects/guitarcatalog/admin/insert.php">Login</a></li>
			</ul>
		</nav>
		<!-- <br><br> -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<form name="searchform" id="searchform" method="get" action="search.php">			
						<div class="input-group search-box">
				            <!-- Lost the label for display consistency -->
				            <input type="text" name="displayvalue" id="displayvalue" class="form-control" maxlength="40">
				            <span class="input-group-btn">
				                 <button class="btn btn-primary" type="submit" name="submit"><span class="glyphicon glyphicon-search"></span></button>
				            </span>
				        </div>
					</form>
				</div>
			</div>
		</div>
	</header>

	<main>
        
	    <!--
	   		PAGE CONTENT HERE
	    -->