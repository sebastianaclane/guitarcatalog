<?php
	include("includes/header.php");
?>
		<div class="container-fluid">
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<h1 class="sr-only">Home</h1>

				<h1>About the Catalog</h1>
				<p>This is a catalog about a variety of electric guitar models designed to help you find more info about your next electric guitar. Important details you should be aware of before purchasing an electric guitar are included such as price, string amount, bridge type, and body material. There will be guitars from manufactuers like Fender, Gibson and Ibanez.</p>

				<p>This catalog mainly utilizes PHP and MySQL to interact with a database to load up the electric guitars and each of their features. You can see these features for each model when you click on their images in the <a href="main-display.php" style="text-decoration: underline;">View Catalog page</a>. I included a search bar at the top of the page and for desktop layout there are filter links (located in the sidebar) to find something specific such as only left hand guitars or only Schecter Guitars.</p>

				<h2>Featured Guitar Models</h2>
				<section id="featured-guitars">
					<div class="row">
						<?php
							// finding the specfic guitar models that I want to be featured
							$result = mysqli_query($con, "SELECT * FROM guitar_catalog WHERE title IN ('Synyster Standard', 'PRS Mark Tremonti Signature Flame 10 Top Charcoal Burst', 'Gibson SGSP70WCCH 2016 SG Special 70s Tribute')");
						?>

						<?php while ($row = mysqli_fetch_array($result)): ?>
							<?php $guitar_image = $row['guitar_image']; ?>
							<?php $guitar_id = $row['guitar_id']; ?>
							<?php $title = $row['title']; ?>

							<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 guitar-overlay">
								<a href="single-item-display.php?id=<?php echo $guitar_id; ?>" class="hover-image-link">
									<img src="thumbs/<?php echo $guitar_image; ?>" class="thumb-image">
									<p class="hover-image-title"><?php echo $title; ?></p>
								</a>
							</div>
						<?php endwhile; ?>
					</div>
				</section>

				<h2>Browse by Manufacturer</h2>
				<section id="manufacturer">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
							<a href="main-display.php?column=manufacturer&displayvalue=Fender"><img src="images/fender_logo.jpg" alt="Fender Logo" class="manufacturer-image"></a>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
							<a href="main-display.php?column=manufacturer&displayvalue=Schecter"><img src="images/schecter_logo.jpg" alt="Schecter Logo" class="manufacturer-image"></a>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
							<a href="main-display.php?column=manufacturer&displayvalue=Ibanez"><img src="images/ibanez_logo.jpg" alt="Ibanez Logo" class="manufacturer-image"></a>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
							<a href="main-display.php?column=manufacturer&displayvalue=Gibson"><img src="images/gibson_logo.jpg" alt="Gibson Logo" class="manufacturer-image"></a>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
							<a href="main-display.php?column=manufacturer&displayvalue=PRS"><img src="images/prs_logo.jpg" alt="PRS Logo" class="manufacturer-image"></a>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
							<a href="main-display.php?column=manufacturer&displayvalue=Epiphone"><img src="images/epiphone_logo.jpg" alt="Epiphone Logo" class="manufacturer-image"></a>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
							<a href="main-display.php?column=manufacturer&displayvalue=Gretsch"><img src="images/gretsch_logo.jpg" alt="Gretsch Logo" class="manufacturer-image"></a>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
							<a href="main-display.php?column=manufacturer&displayvalue=LTD%20Guitars"><img src="images/ltdguitars_logo.jpg" alt="LTD Guitars Logo" class="manufacturer-image"></a>
						</div>
					</div>
				</section>
			</div>
			<?php include("includes/sidebar.php"); ?>
		</div>

<?php 
	include("includes/footer.php");
?>