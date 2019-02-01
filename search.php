<?php 
	include('includes/header.php');

	if (isset($_GET['submit'])) {
		// code for protecting against SQL injection for the search bar
		//Security against scammers (copy pasted code)
		$badStrings = array("Content-Type:",
							"content-type",
							"MIME-Version:",
							"mime-version:",
							"Content-Transfer-Encoding:",
							"content-transfer-encoding:",
							"bcc:",
							"cc:"); //If any of these strings are in our inputs..
			
		foreach($_GET as $k => $v){
			foreach($badStrings as $v2){
				if(strpos($v, $v2) !== false){
					header("Location:http://www.lingscars.com"); //...send the user straight to hell 
					exit();
				}
			}
		}

		$displayvalue = $_GET['displayvalue'];
		// grab the 1st 50 characters in case a hacker tries to put in more than is allowed
		$trimmed_search_value = substr($displayvalue, 0, 40);

		$error_message = "";

		if($trimmed_search_value != "") {
			$query = "SELECT * FROM guitar_catalog WHERE
					  title LIKE '%$trimmed_search_value%' OR
					  description LIKE '%$trimmed_search_value%' OR
					  price LIKE '%$trimmed_search_value%' OR
					  manufacturer LIKE '%$trimmed_search_value%' OR
					  guitar_colours LIKE '%$trimmed_search_value%' OR
					  body_material LIKE '%$trimmed_search_value%' OR
					  fretboard_material LIKE '%$trimmed_search_value%' OR
					  bridge_type LIKE '%$trimmed_search_value%' OR
					  string_amount LIKE '%$trimmed_search_value%' OR
					  dexterity LIKE '%$trimmed_search_value%'";

			$result = mysqli_query($con, $query) or die(mysqli_error());
		} else {
			$error_message = "No results found";
		}

	}
?>

	<div class="container-fluid">
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<?php
				if ($error_message != "") {
					echo "<h1>$error_message</h1>";
				} else if ($query != "") {
					echo "<h1>Search Results for $trimmed_search_value</h1>";
				}
			?>			

			<?php
				if ($trimmed_search_value != "") {
					while ($row = mysqli_fetch_array($result)) {
						$title = $row['title'];
						$guitar_image = $row['guitar_image'];
						$guitar_id = $row['guitar_id'];

						echo "<div class=\"main-display-image col-xs-12 col-sm-6 col-md-4 col-lg-4\">";	
						echo "<a href=\"single-item-display.php?id=$guitar_id\" class=\"hover-image-link\"><img src=\"thumbs/$guitar_image\" class=\"thumb-image\"><p class=\"hover-image-title\">". $title. "</p></a>";
						echo "\n</div>";
					}
				}
			?>
		</div>
		<?php include("includes/sidebar.php"); ?>
	</div>

<?php 
	include("includes/footer.php");
?>