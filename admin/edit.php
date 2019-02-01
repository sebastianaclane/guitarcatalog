<?php 
	session_start();

	if (!isset($_SESSION['guitar_catalog'])) {
		header("Location:http://sebastianlane.ca/projects/guitarcatalog/admin/login.php");
	}

	include("../includes/adminheader.php");

	// make sure your guitar id value has an existing id
	$gtar_id = $_GET['id'];
	if (!isset($gtar_id)) {
		// do a query and find an existing ID number
		$result = mysqli_query($con, "SELECT * FROM guitar_catalog LIMIT 1");

		while ($row = mysqli_fetch_array($result)) {
			$gtar_id = $row['guitar_id'];
		}
	}

	$validation_errors = [
	    title_errors => "",
	    guitar_image_errors => "",
	    description_errors => "",
	    price_errors => "",
	    manufacturer_errors => "",
	    guitar_colours_errors => "",
	    body_material_errors => "",
	    fretboard_material_errors => "",
	    bridge_type_errors => "",
	    string_amount_errors => "",
	    dexterity_errors => "",
	    demo_video_errors => ""
	];

	// Step 3: If user has clicked the button do validation, if validation passes do an UPDATE
	if (isset($_POST['submit'])) {
		$new_title = $_POST['title'];
		$new_guitar_image = $_POST['guitar_image'];
		$new_description = $_POST['description'];
		$new_price = $_POST['price'];
		$new_manufacturer = $_POST['manufacturer'];
		$new_guitar_colours = $_POST['guitar_colours'];
		$new_body_material = $_POST['body_material'];
		$new_fretboard_material = $_POST['fretboard_material'];
		$new_bridge_type = $_POST['bridge_type'];
		$new_string_amount = $_POST['string_amount'];
		$new_dexterity = $_POST['dexterity'];
		$new_demo_video = $_POST['demo_video'];

		// add basic validation here
		if ($new_title != "") {
			$new_title = filter_var($new_title, FILTER_SANITIZE_STRING);
			if ($new_title == " ") {
				$validation_errors[title_errors] = "Model name is required.<br/><br/>";
			} else if (strlen($new_title) < 2 || strlen($new_title) > 60) {
				$validation_errors[title_errors] = "Model name must be between 2 and 60 characters long<br>";
			}
		} else {
			$validation_errors[title_errors] = "Model name is required.<br/>";
		}


		if ($new_description != "") {
			$new_description = filter_var($new_description, FILTER_SANITIZE_STRING);
			if ($new_description == " ") {
				$validation_errors[description_errors] = "Description is required.<br/>";
			} else if (strlen($new_description) < 2 || strlen($new_description) > 600) {
				$validation_errors[description_errors] = "Description must be between 2 and 600 characters long.<br>";
			}
		} else {
			$validation_errors[description_errors] = "Description is required.<br/>";
		}

		if ($new_price != "") {
			if(!filter_var($new_price, FILTER_VALIDATE_FLOAT)) {
				$validation_errors[price_errors] = "Price can't contain letters. Please make it a number.<br/>";
			} else if (strlen($new_price) < 2 || strlen($new_price) > 20) {
				$validation_errors[price_errors] = "Price must be between 2 and 20 digts long<br/>";
			}
		} else {
		 	$validation_errors[price_errors] = "Price is required.<br/>";
		}

		if ($new_manufacturer != "") {
			$new_manufacturer = filter_var($new_manufacturer, FILTER_SANITIZE_STRING);
			if ($new_manufacturer == " ") {
				$validation_errors[manufacturer_errors] = "Manufacturer is required.<br/>";
			} else if (strlen($new_manufacturer) < 2 || strlen($new_manufacturer) > 60) {
				$validation_errors[manufacturer_errors] = "Manufacturer must be between 2 and 60 characters long.<br>";
			}
		} else {
			$validation_errors[manufacturer_errors] = "Manufacturer is required.<br/>";
		}

		// may have to have some validation about
		// making sure users separate values by commas
		if ($new_guitar_colours != "") {
			$new_guitar_colours = filter_var($new_guitar_colours, FILTER_SANITIZE_STRING);
			if ($new_guitar_colours == " ") {
				$validation_errors[guitar_colours_errors] = "Guitar colours is required.<br/>";
			} else if (strlen($new_guitar_colours) < 2 || strlen($new_guitar_colours) > 60) {
				$validation_errors[guitar_colours_errors] = "Guitar colours must be between 2 and 60 characters long.<br>";
			}
		} else {
			$validation_errors[guitar_colours_errors] = "Guitar colours is required.<br/>";
		}

		if ($new_body_material != "") {
			$new_body_material = filter_var($new_body_material, FILTER_SANITIZE_STRING);
			if ($new_body_material == " ") {
				$validation_errors[body_material_errors] = "Body material is required.<br/>";
			} else if (strlen($new_body_material) < 2 || strlen($new_body_material) > 60) {
				$validation_errors[body_material_errors] = "Body material must be between 2 and 60 characters long.<br>";
			}
		} else {
			$validation_errors[body_material_errors] = "Body material is required.<br/>";
		}

		if ($new_fretboard_material != "") {
			$new_fretboard_material = filter_var($new_fretboard_material, FILTER_SANITIZE_STRING);
			if ($new_fretboard_material == " ") {
				$validation_errors[fretboard_material_errors] = "Fretboard material is required.<br/>";
			} else if (strlen($new_fretboard_material) < 2 || strlen($new_fretboard_material) > 60) {
				$validation_errors[fretboard_material_errors] = "Fretboard material must be between 2 and 60 characters long.<br>";
			}
		} else {
			$validation_errors[fretboard_material_errors] = "Fretboard material is required.<br/>";
		}

		if($new_bridge_type != "Fixed Bridge" && $new_bridge_type != "Tune-O-Matic" && $new_bridge_type != "Synchronized Tremolo" &&
			$new_bridge_type != "Floyd Rose" && $new_bridge_type != "Other") {
			$validation_errors[bridge_type_errors] = "Bridge type not a valid type.<br>";
		} else if ($new_bridge_type == "") {
			$validation_errors[bridge_type_errors] = "Please select a bridge type.<br/>";
		}

		if($new_string_amount != "6" && $new_string_amount != "7" && $new_string_amount != "8") {
			$validation_errors[string_amount_errors] = "String amount not a valid number.<br>";
		} else if ($new_string_amount == "") {
			$validation_errors[string_amount_errors] = "String amount is required.<br/>";
		}

		if($new_dexterity != "Left-Hand Guitar" && $new_dexterity != "Right-Hand Guitar"){
			$validation_errors[dexterity_errors] = "Dexterity not a valid type.<br>";
		} else if ($new_dexterity == "") {
			$validation_errors[dexterity_errors] = "Please select a dexterity.<br/>";
		}

		if ($new_demo_video != "") {
			$new_demo_video = filter_var($new_demo_video, FILTER_SANITIZE_URL);
			if (!filter_var($new_demo_video, FILTER_SANITIZE_URL)) {
				$validation_errors[demo_video_errors] = "$new_demo_video is <strong>NOT</strong> a valid url.<br/><br/>";
			} else if (strlen($new_demo_video) < 2 || strlen($new_demo_video) > 150) {
				$validation_errors[demo_video_errors] = "Demo video must be between 2 and 150 characters long<br>";
			}
		}

		//Security against scammers (copy pasted code)
		$badStrings = array("Content-Type:",
							"MIME-Version:",
							"Content-Transfer-Encoding:",
							"bcc:",
							"cc:"); //If any of these strings are in our inputs...

		foreach($_POST as $k => $v){
			foreach($badStrings as $v2){
				if(strpos($v, $v2) !== false){
					header("Location:http://www.lingscars.com"); //...send the user straight to hell 
					exit();
				}
			}
		}

		$validation_status = true;
		// check each error attribue in $validation_errors array
		// if one of the values is not equal to "" then validation has failed
		foreach ($validation_errors as $val) {
			if ($val != "") {
				$validation_status = false;
			}
		}

		// valdation has passed
		if ($validation_status == true) {
			$str_validation_message = "$new_title has been updated.";
			// Now, we do an UPDATE with a WHERE clause.
			$result = mysqli_query($con, "UPDATE guitar_catalog SET
				title = '$new_title',
				description = '$new_description',
				price = '$new_price',
				manufacturer = '$new_manufacturer',
				guitar_colours = '$new_guitar_colours',
				body_material = '$new_body_material',
				fretboard_material = '$new_fretboard_material',
				bridge_type = '$new_bridge_type',
				string_amount = '$new_string_amount',
				dexterity = '$new_dexterity',
				demo_video = '$new_demo_video'
				WHERE guitar_id = '$gtar_id'") or die(mysqli_error());

		} else {
			$str_validation_message = "Please fix the highlighted errors and try submitting the changes again.";
		}
	} // \ if isset submit

	// Step 1: Get all existing records and create a dynamic nav system
	// read from a DB
	$result = mysqli_query($con, "SELECT * FROM guitar_catalog");

	$edit_select = "<select class=\"editSelect\">";
	
	while ($row = mysqli_fetch_array($result)) {
		$title_selectfield = $row['title'];
		$guitar_id_selectfield = $row['guitar_id'];

		if ($guitar_id_selectfield == $gtar_id) {
			$edit_select .= "\n\t<option value=\"edit.php?id=$guitar_id_selectfield\" selected>$title_selectfield</option>";
		}
		else {
			$edit_select .= "\n\t<option value=\"edit.php?id=$guitar_id_selectfield\">$title_selectfield</option>";
		}
	}
	$edit_select .= "</select>";

	// Step 2: Retrieve the existing information for the selected guitar; then, prepopulate the form with that info
	$result = mysqli_query($con, "SELECT * FROM guitar_catalog WHERE guitar_id = '$gtar_id'") or die(mysqli_error());

	while ($row = mysqli_fetch_array($result)) {
		$title_form = $row['title'];
		$description_form = $row['description'];
		$price_form = $row['price'];
		$manufacturer_form = $row['manufacturer'];
		$guitar_colours_form = $row['guitar_colours'];
		$body_material_form = $row['body_material'];
		$fretboard_material_form = $row['fretboard_material'];
		$bridge_type_form = $row['bridge_type'];
		$string_amount_form = $row['string_amount'];
		$dexterity_form = $row['dexterity'];
		$demo_video_form = $row['demo_video'];
	}
	
?>

		<div class="container">
			<div class="col-md-12">
				<h1>Edit Guitars</h1>
				
				<?php
					echo $edit_select;

					$result = mysqli_query($con, "SELECT * FROM guitar_catalog WHERE guitar_id = '$gtar_id'") or die(mysqli_error());

						while ($row = mysqli_fetch_array($result)) {
							$guitar_id = $row['title'];
						 	$guitar_image = $row['guitar_image'];
							
							echo "\n\t<img src=\"../display/$guitar_image\" class=\"edit-page-image\"><br/>";		
						}
				?>
			
				<form name="myform" id="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" enctype="multipart/form-data">
					<div class="form-group">
						<label for="title">Model Name*:</label>
						<input type="text" name="title" id="title" value="<?php echo $title_form; ?>" class="form-control">
						<?php echo "<p class=\"errorMessage\">$validation_errors[title_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="description">Description*:</label>
						<textarea name="description" id="description" class="form-control"><?php echo $description_form; ?></textarea>
						<?php echo "<p class=\"errorMessage\">$validation_errors[description_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="price">Price:*</label>
						<input type="number" name="price" id="price" value="<?php echo $price_form; ?>" step="0.01" class="form-control">
						<?php echo "<p class=\"errorMessage\">$validation_errors[price_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="manufacturer">Manufacturer*:</label>
						<input type="text" name="manufacturer" id="manufacturer" value="<?php echo $manufacturer_form; ?>" class="form-control">
						<?php echo "<p class=\"errorMessage\">$validation_errors[manufacturer_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="guitar_colours">Guitar Colours*:</label>
						<input type="text" name="guitar_colours" id="guitar_colours" value="<?php echo $guitar_colours_form; ?>"
						placeholder="Separate colours by ','s" class="form-control">
						<?php echo "<p class=\"errorMessage\">$validation_errors[guitar_colours_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="body_material">Body Material*:</label>
						<input type="text" name="body_material" id="body_material" value="<?php echo $body_material_form; ?>" class="form-control">
						<?php echo "<p class=\"errorMessage\">$validation_errors[body_material_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="fretboard_material">Fretboard Material*:</label>
						<input type="text" name="fretboard_material" id="fretboard_material" value="<?php echo $fretboard_material_form; ?>" class="form-control">
						<?php echo "<p class=\"errorMessage\">$validation_errors[fretboard_material_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="demo_video">Demo Video:</label>
						<input type="text" name="demo_video" id="demo_video" value="<?php echo $demo_video_form; ?>" class="form-control">
						<?php echo "<p class=\"errorMessage\">$validation_errors[demo_video_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="bridge_type">Bridge Type*:</label>
					  	<input type="radio" name="bridge_type" value="Fixed Bridge" <?php echo ($bridge_type_form == 'Fixed Bridge') ? "checked" : ''; ?>>Fixed Bridge<br>
					  	<input type="radio" name="bridge_type" value="Tune-O-Matic" <?php echo ($bridge_type_form == 'Tune-O-Matic') ? "checked" : ''; ?>>Tune-O-Matic<br>
		  				<input type="radio" name="bridge_type" value="Synchronized Tremolo" <?php echo ($bridge_type_form == 'Synchronized Tremolo') ? "checked" : ''; ?>>Synchronized Tremolo<br>
		  				<input type="radio" name="bridge_type" value="Floyd Rose" <?php echo ($bridge_type_form == 'Floyd Rose') ? "checked" : ''; ?>>Floyd Rose<br>
		  				<input type="radio" name="bridge_type" value="Other" <?php echo ($bridge_type_form == 'Other') ? "checked" : ''; ?>>Other<br>
						<?php echo "<p class=\"errorMessage\">$validation_errors[bridge_type_errors]</p>"; ?>
					</div>
					<div class="form-group clearfix">
						<label for="string_amount">String Amount*:</label>
						<input type="radio" name="string_amount" value="6" <?php echo ($string_amount_form == '6') ? "checked" : ''; ?>>6<br>
		  				<input type="radio" name="string_amount" value="7" <?php echo ($string_amount_form == '7') ? "checked" : ''; ?>>7<br>
		  				<input type="radio" name="string_amount" value="8" <?php echo ($string_amount_form == '8') ? "checked" : ''; ?>>8<br>
						<?php echo "<p class=\"errorMessage\">$validation_errors[string_amount_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="dexterity">Dexterity*:</label>
						<input type="radio" name="dexterity" value="Right-Hand Guitar" <?php echo ($dexterity_form == 'Right-Hand Guitar') ? "checked" : ''; ?>>Right-Handed Guitar<br>
		  				<input type="radio" name="dexterity" value="Left-Hand Guitar" <?php echo ($dexterity_form == 'Left-Hand Guitar') ? "checked" : ''; ?>>Left-Handed Guitar<br>
						<?php echo "<p class=\"errorMessage\">$validation_errors[dexterity_errors]</p>"; ?>
					</div>
					<div class="form-group clearfix">
						<input type="submit" name="submit" value="Edit Guitar" class="btn btn-primary edit-guitar-button">
						<a href="delete.php?id=<?php echo $gtar_id; ?>" onclick="confirmDelete()" class="delete btn btn-danger">Delete Guitar</a>
					</div>
				</form>
	
				<?php 
					echo "<p>$str_validation_message</p>";
				?>

			</div>
		</div>

	<script src="jquery-3.1.1.min.js"></script>

	<script type="text/javascript">
		$('.editSelect').change(function (evt) {
			window.location.href = evt.target.value;
		})

	</script>
	

	<script type="text/javascript">
		function confirmDelete() {
			if (confirm("Are you sure you want to delete this guitar?")) {
				document.querySelector('.delete').href = "delete.php?id=<?php echo $gtar_id; ?>";
			} else {
				document.querySelector('.delete').href = "javascript:void(0);";
			}
		}
	</script>

<?php 
	include("../includes/footer.php");
?>