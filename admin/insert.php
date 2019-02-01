<?php 

	session_start();

	if (!isset($_SESSION['guitar_catalog'])) {
		header("Location:http://sebastianlane.ca/projects/guitarcatalog/admin/login.php");
	}

	include("../includes/adminheader.php");

	// for validation array
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";

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

	if(isset($_POST['submit'])) {
		// add basic validation here
		if ($title != "") {
			$title = filter_var($title, FILTER_SANITIZE_STRING);
			if ($title == " ") {
				$validation_errors[title_errors] = "Model name is required.<br/><br/>";
			} else if (strlen($title) < 2 || strlen($title) > 60) {
				$validation_errors[title_errors] = "Model name must be between 2 and 60 characters long<br>";
			}
		} else {
			$validation_errors[title_errors] = "Model name is required.<br/>";
		}

		if ($description != "") {
			$description = filter_var($description, FILTER_SANITIZE_STRING);
			if ($description == " ") {
				$validation_errors[description_errors] = "Description is required.<br/>";
			} else if (strlen($description) < 2 || strlen($description) > 600) {
				$validation_errors[description_errors] = "Description must be between 2 and 600 characters long.<br>";
			}
		} else {
			$validation_errors[description_errors] = "Description is required.<br/>";
		}

		if ($price != "") {
			if(!filter_var($price, FILTER_VALIDATE_FLOAT)) {
				$validation_errors[price_errors] = "Price can't contain letters. Please make it a number.<br/>";
			} else if (strlen($price) < 2 || strlen($price) > 20) {
				$validation_errors[price_errors] = "Price must be between 2 and 20 digts long<br/>";
			}
		} else {
		 	$validation_errors[price_errors] = "Price is required.<br/>";
		}

		if ($manufacturer != "") {
			$manufacturer = filter_var($manufacturer, FILTER_SANITIZE_STRING);
			if ($manufacturer == " ") {
				$validation_errors[manufacturer_errors] = "Manufacturer is required.<br/>";
			} else if (strlen($manufacturer) < 2 || strlen($manufacturer) > 60) {
				$validation_errors[manufacturer_errors] = "Manufacturer must be between 2 and 60 characters long.<br>";
			}
		} else {
			$validation_errors[manufacturer_errors] = "Manufacturer is required.<br/>";
		}

		// may have to have some validation about
		// making sure users separate values by commas
		if ($guitar_colours != "") {
			$guitar_colours = filter_var($guitar_colours, FILTER_SANITIZE_STRING);
			if ($guitar_colours == " ") {
				$validation_errors[guitar_colours_errors] = "Guitar colours is required.<br/>";
			} else if (strlen($guitar_colours) < 2 || strlen($guitar_colours) > 60) {
				$validation_errors[guitar_colours_errors] = "Guitar colours must be between 2 and 60 characters long.<br>";
			}
		} else {
			$validation_errors[guitar_colours_errors] = "Guitar colours is required.<br/>";
		}

		if ($body_material != "") {
			$body_material = filter_var($body_material, FILTER_SANITIZE_STRING);
			if ($body_material == " ") {
				$validation_errors[body_material_errors] = "Body material is required.<br/>";
			} else if (strlen($body_material) < 2 || strlen($body_material) > 60) {
				$validation_errors[body_material_errors] = "Body material must be between 2 and 60 characters long.<br>";
			}
		} else {
			$validation_errors[body_material_errors] = "Body material is required.<br/>";
		}

		if ($fretboard_material != "") {
			$fretboard_material = filter_var($fretboard_material, FILTER_SANITIZE_STRING);
			if ($fretboard_material == " ") {
				$validation_errors[fretboard_material_errors] = "Fretboard material is required.<br/>";
			} else if (strlen($fretboard_material) < 2 || strlen($fretboard_material) > 60) {
				$validation_errors[fretboard_material_errors] = "Fretboard material must be between 2 and 60 characters long.<br>";
			}
		} else {
			$validation_errors[fretboard_material_errors] = "Fretboard material is required.<br/>";
		}

		if($bridge_type != "Fixed Bridge" && $bridge_type != "Tune-O-Matic" && $bridge_type != "Synchronized Tremolo" &&
			$bridge_type != "Floyd Rose" && $bridge_type != "Other") {
			$validation_errors[bridge_type_errors] = "Bridge type not a valid type.<br>";
		} else if ($bridge_type == "") {
			$validation_errors[bridge_type_errors] = "Please select a bridge type.<br/>";
		}

		if($string_amount != "6" && $string_amount != "7" && $string_amount != "8") {
			$validation_errors[string_amount_errors] = "String amount not a valid number.<br>";
		} else if ($string_amount == "") {
			$validation_errors[string_amount_errors] = "String amount is required.<br/>";
		}

		if($dexterity != "Left-Hand Guitar" && $dexterity != "Right-Hand Guitar"){
			$validation_errors[dexterity_errors] = "Dexterity not a valid type.<br>";
		} else if ($dexterity == "") {
			$validation_errors[dexterity_errors] = "Please select a dexterity.<br/>";
		}

		if ($demo_video != "") {
			$demo_video = filter_var($demo_video, FILTER_SANITIZE_URL);
			if (!filter_var($demo_video, FILTER_SANITIZE_URL)) {
				$validation_errors[demo_video_errors] = "$demo_video is <strong>NOT</strong> a valid url.<br/><br/>";
			} else if (strlen($demo_video) < 2 || strlen($demo_video) > 150) {
				$validation_errors[demo_video_errors] = "Demo video must be between 2 and 150 characters long<br>";
			}
		}

		// validation for guitar_image
		$boolValidateOK = 1;
		$filetype = $_FILES['guitar_image']['type'];

		if ($_FILES['guitar_image']['name'] == "") {
			$validation_errors[guitar_image_errors] = "No image uploaded. Please upload an image.";
		} else {
			// allows upload of .jpg and .png images
			if ($filetype != "image/jpeg" && $filetype != "image/jpg" && $filetype != "image/png") {
				$validation_errors[guitar_image_errors] = "Wrong file type, must be a .jpg or .png image.<br/>";
				$boolValidateOK = 0;
			} else if ($_FILES['guitar_image']['size'] > 100000000) {
				// validate filesize
				$validation_errors[guitar_image_errors] .= "\nFile is too large.<br/>";
				$boolValidateOK = 0;
			} else {
				// validation has passed
				if ($filetype == "image/jpeg" || $filetype == "image/jpg") {
					$file_extension = '.jpg';
				} elseif ($filetype == "image/png") {
					$file_extension = '.png';
				}

				// validation check
				if($boolValidateOK == 1) {
					// success so upload the image to the specified file name and directory
					// unique id for image
					$unique_id = uniqid();
					$new_file_name = "../uploads/" . "IMG" . "_" . $unique_id . $file_extension;
					if(move_uploaded_file($_FILES['guitar_image']['tmp_name'], $new_file_name)) {

						// if upload is sucessful, then make copies of the image
						// thumbnail at 300px
						$folder = "../thumbs/";
						$new_width = 300;
						if ($file_extension == ".jpg") {
							resizeImageJPG($new_file_name, $folder, $new_width, $file_extension);
						} else {
							resizeImagePNG($new_file_name, $folder, $new_width, $file_extension);
						}
						
						// display image at 800px
						$folder = "../display/";
						$new_width = 800;
						if ($file_extension == ".jpg") {
							resizeImageJPG($new_file_name, $folder, $new_width, $file_extension);
						} else {
							resizeImagePNG($new_file_name, $folder, $new_width, $file_extension);
						}

						// assign the $guitar_image variable as a unique file name
						$guitar_image = 'IMG' . '_' . $unique_id . $file_extension;

					} else {
						$validation_errors[guitar_image_errors] .= "\nUpload FAILED<br/>";
					}
				}
			}
		}

		//Security against scammers
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
			$str_validation_message = "$title will be entered.";

			// insert data
			$result = mysqli_query($con, 
						"INSERT INTO guitar_catalog(
						 	title, guitar_image, description, price, manufacturer, guitar_colours, body_material, 
						 	fretboard_material, bridge_type, string_amount, dexterity, demo_video)
						VALUES('$title', '$guitar_image', '$description', '$price', '$manufacturer', '$guitar_colours',
							'$body_material', '$fretboard_material', '$bridge_type', '$string_amount',
							'$dexterity', '$demo_video')"
			);

		} else {
			// validation has failed
			$str_validation_message = "Please fix the highlighted errors and try to insert the guitar again.";
		}


	} // \ if isset submit

	// move_uploaded_file
	/* create a re-usable function to resize the image */
	function resizeImageJPG($file, $folder, $new_width, $file_extension) {
		list($width, $height) = getimagesize($file);
		$img_ratio = $width/$height;

		$new_height = $new_width/$img_ratio;

		$thumb = imagecreatetruecolor($new_width, $new_height);
		$source = imagecreatefromjpeg($file);

		imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		$new_file_name = $folder . basename($file); // get original filename

		imagejpeg($thumb, $new_file_name, 80);

		imagedestroy($thumb);
		imagedestroy($source);
	} 

	function resizeImagePNG($file, $folder, $new_width, $file_extension) {
		list($width, $height) = getimagesize($file);
		$img_ratio = $width/$height;

		$new_height = $new_width/$img_ratio;

		$thumb = imagecreatetruecolor($new_width, $new_height);

		$source = imagecreatefrompng($file);
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		$new_file_name = $folder . basename($file); // get original filename

		imagepng($thumb, $new_file_name, 8);
		
		imagedestroy($thumb);
		imagedestroy($source);
	} 
?>

		<div class="container">
			<div class="col-md-12">

				<h1>Insert A Guitar</h1>

				<form name="myform" id="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" enctype="multipart/form-data">
					<div class="form-group">
						<label for="title">Model Name*:</label>
						<input type="text" name="title" id="title" value="<?php echo $_POST['title']; ?>" class="form-control">
						<?php echo "<p class=\"errorMessage\">$validation_errors[title_errors]</p>"; ?>
					</div>
					<div>
						<label for="guitar_image">Guitar Image*:</label>
						<input type="file" name="guitar_image" id="guitar_image">
						<?php echo "<p class=\"errorMessage\">$validation_errors[guitar_image_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="description">Description*:</label>
						<textarea name="description" id="description" class="form-control"><?php echo $_POST['description']; ?></textarea>
						<?php echo "<p class=\"errorMessage\">$validation_errors[description_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="price">Price:*</label>
						<input type="number" name="price" id="price" value="<?php echo $_POST['price']; ?>" step="0.01" class="form-control">
						<?php echo "<p class=\"errorMessage\">$validation_errors[price_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="manufacturer">Manufacturer*:</label>
						<input type="text" name="manufacturer" id="manufacturer" value="<?php echo $_POST['manufacturer']; ?>" class="form-control">
						<?php echo "<p class=\"errorMessage\">$validation_errors[manufacturer_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="guitar_colours">Guitar Colours*:</label>
						<input type="text" name="guitar_colours" id="guitar_colours" value="<?php echo $_POST['guitar_colours']; ?>"
						placeholder="Separate colours by ','s" class="form-control">
						<?php echo "<p class=\"errorMessage\">$validation_errors[guitar_colours_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="body_material">Body Material*:</label>
						<input type="text" name="body_material" id="body_material" value="<?php echo $_POST['body_material']; ?>" class="form-control">
						<?php echo "<p class=\"errorMessage\">$validation_errors[body_material_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="fretboard_material">Fretboard Material*:</label>
						<input type="text" name="fretboard_material" id="fretboard_material" value="<?php echo $_POST['fretboard_material']; ?>" class="form-control">
						<?php echo "<p class=\"errorMessage\">$validation_errors[fretboard_material_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="demo_video">Demo Video:</label>
						<input type="text" name="demo_video" id="demo_video" value="<?php echo $_POST['demo_video']; ?>" class="form-control">
						<?php echo "<p class=\"errorMessage\">$validation_errors[demo_video_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="bridge_type">Bridge Type*:</label>
					  	<input type="radio" name="bridge_type" value="Fixed Bridge" <?php echo ($bridge_type == 'Fixed Bridge') ? "checked" : ''; ?>>Fixed Bridge<br>
					  	<input type="radio" name="bridge_type" value="Tune-O-Matic" <?php echo ($bridge_type == 'Tune-O-Matic') ? "checked" : ''; ?>>Tune-O-Matic<br>
						<input type="radio" name="bridge_type" value="Synchronized Tremolo" <?php echo ($bridge_type == 'Synchronized Tremolo') ? "checked" : ''; ?>>Synchronized Tremolo<br>
						<input type="radio" name="bridge_type" value="Floyd Rose" <?php echo ($bridge_type == 'Floyd Rose') ? "checked" : ''; ?>>Floyd Rose<br>
					<input type="radio" name="bridge_type" value="Other" <?php echo ($bridge_type == 'Other') ? "checked" : ''; ?>>Other<br>
						<?php echo "<p class=\"errorMessage\">$validation_errors[bridge_type_errors]</p>"; ?>
					</div>
					<div class="form-group clearfix">
						<label for="string_amount">String Amount*:</label>
						<input type="radio" name="string_amount" value="6" <?php echo ($string_amount == '6') ? "checked" : ''; ?>>6<br>
							<input type="radio" name="string_amount" value="7" <?php echo ($string_amount == '7') ? "checked" : ''; ?>>7<br>
							<input type="radio" name="string_amount" value="8" <?php echo ($string_amount == '8') ? "checked" : ''; ?>>8<br>
						<?php echo "<p class=\"errorMessage\">$validation_errors[string_amount_errors]</p>"; ?>
					</div>
					<div class="form-group">
						<label for="dexterity">Dexterity*:</label>
						<input type="radio" name="dexterity" value="Right-Hand Guitar" <?php echo ($dexterity == 'Right-Hand Guitar') ? "checked" : ''; ?>>Right-Hand Guitar<br>
							<input type="radio" name="dexterity" value="Left-Hand Guitar" <?php echo ($dexterity == 'Left-Hand Guitar') ? "checked" : ''; ?>>Left-Hand Guitar<br>
						<?php echo "<p class=\"errorMessage\">$validation_errors[dexterity_errors]</p>"; ?>
					</div>
					<div class="form-group clearfix">
						<input type="submit" name="submit" value="Insert Guitar" class="btn btn-primary">
					</div>
				</form>

				<?php 
					echo $str_validation_message;
				?>
			</div>
		</div>


<?php 
	include("../includes/footer.php");
?>