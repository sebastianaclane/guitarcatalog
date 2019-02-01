<?php 
	include('includes/header.php');

	$column = $_GET['column'];
	$displayvalue = $_GET['displayvalue'];
	$min = $_GET['min'];
	$max = $_GET['max'];

	$view_all_query = "true";
	if($column) {
		$view_all_query = "false";

		$query = "SELECT * FROM guitar_catalog WHERE $column LIKE '%$displayvalue%'";

		if($column == 'price') {
			$query = "SELECT * FROM guitar_catalog WHERE price BETWEEN $min AND $max";
		}
	} else {
		$query = "SELECT * FROM guitar_catalog";
	}

	$result = mysqli_query($con,$query) or die(mysqli_error());
?>

	<div class="container-fluid">
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<?php if ($view_all_query == "true") {
					echo "<h1>All Guitars</h1>";
				} else {
					if ($column == 'string_amount') {
						echo "<h1>$displayvalue String Guitars</h1>";
					} else if ($min == '100') {
						echo "<h1>Less Than $1000 Guitars</h1>";
					} else if ($min == '1000') {
						echo "<h1>$1000 - $1999 Guitars</h1>";
					} else if ($min == '2000') {
						echo "<h1>$2000 - $2999 Guitars</h1>";
					} else if ($min == '3000') {
						echo "<h1>$3000 - $3999 Guitars</h1>";
					} else if ($min == '4000') {
						echo "<h1>$4000+ Guitars</h1>";
					}  else if ($displayvalue == 'LTD Guitars') {
						echo "<h1>LTD Guitars</h1>";
					} else if ($column == 'dexterity') {
						echo "<h1>$displayvalue" . "s</h1>";
					} else {
						echo "<h1>$displayvalue Guitars</h1>";
					}
				}
			?>			

			<?php
				while ($row = mysqli_fetch_array($result)) {
					$title = $row['title'];
					$guitar_image = $row['guitar_image'];
					$guitar_id = $row['guitar_id'];			
					echo "<div class=\"main-display-image col-xs-12 col-sm-6 col-md-4 col-lg-4\">";	
					echo "<a href=\"single-item-display.php?id=$guitar_id\" class=\"hover-image-link\"><img src=\"thumbs/$guitar_image\" class=\"thumb-image\"><p class=\"hover-image-title\">". $title. "</p></a>";
					echo "\n</div>";
				}
			?>
		</div>
		<?php include("includes/sidebar.php"); ?>
	</div>

<?php 
	include("includes/footer.php");
?>