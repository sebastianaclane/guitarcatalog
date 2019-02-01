<?php 
	include('includes/header.php');

	$guitar_id = $_GET['id'];

	$result = mysqli_query($con, "SELECT * FROM guitar_catalog WHERE guitar_id = '$guitar_id'") or die(mysqli_error());
?>

		<div class="container-fluid">
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<?php
					while ($row = mysqli_fetch_array($result)) {
						$title = $row['title'];
						$description = $row['description'];
						$guitar_image = $row['guitar_image'];
						$price = $row['price'];
						$manufacturer = $row['manufacturer'];
						$guitar_colours = $row['guitar_colours'];
						$body_material = $row['body_material'];
						$fretboard_material = $row['fretboard_material'];
						$bridge_type = $row['bridge_type'];
						$string_amount = $row['string_amount'];
						$dexterity = $row['dexterity'];
						$demo_video = $row['demo_video'];
						
						echo "\n\t<h1 class=\"text-center\">". $title. "</h1>";
						echo "\n\t<img src=\"display/$guitar_image\" class=\"display-guitar\">";	
						echo "\n\t<p><span class=\"display-info-label\">Description</span>: ". $description. "</p>";	
						echo "\n\t<p><span class=\"display-info-label\">Price</span>: $". $price . "</p>";
						echo "\n\t<p><span class=\"display-info-label\">Manufacturer</span>: ". $manufacturer . "</p>";
						echo "\n\t<p><span class=\"display-info-label\">Guitar Colours</span>: ". $guitar_colours . "</p>";
						echo "\n\t<p><span class=\"display-info-label\">Body Material</span>: ". $body_material . "</p>";
						echo "\n\t<p><span class=\"display-info-label\">Fretboard Material</span>: ". $fretboard_material . "</p>";
						echo "\n\t<p><span class=\"display-info-label\">Bridge Type</span>: ". $bridge_type . "</p>";
						echo "\n\t<p><span class=\"display-info-label\">String Amount</span>: ". $string_amount . "</p>";
						echo "\n\t<p><span class=\"display-info-label\">Dexterity</span>: ". $dexterity . "</p>";
					}

					if ($demo_video != '') {
						$youtube_video_id = explode("v=", $demo_video);
						echo "<p><span class=\"display-info-label\">Demo Video</span>:</p><br/>";
						echo "<iframe src=\"https://www.youtube.com/embed/$youtube_video_id[1]\" frameborder=\"0\" allowfullscreen class=\"iframe-margin\"></iframe>";
					} else {
						echo "<p><span class=\"display-info-label\">Demo Video</span>: No video found</p>";
					}
				?>
			</div>	
			
			<?php include("includes/sidebar.php"); ?>
		</div>

<?php 
	include("includes/footer.php");
?>