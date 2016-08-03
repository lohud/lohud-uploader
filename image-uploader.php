<?php
/**
 * CJ IMAGE UPLOADER
 * -POST params-
 * @param  $firstName - first name of submitter
 * @param  $lastName - last name of submitter
 * @param  $email - email address of submitter
 * @param  $category - category of the submission
 * @param  $caption - caption of the submission
 * @param  $image - image file that is being uploaded
  * -optional-
 * @param  $ajaxEnabled - if isset, form is being submitted via ajax, so return a json response
 */

	ini_set('memory_limit', '128M');

	header('Content-Type: application/json');
	set_error_handler('customError');
	set_exception_handler('customException');
	define("DEBUG", true);
	$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

	include('credentials.php');


	$output = array("ok" => false);
	$timestamp = time();
	$firstName = substr($_POST['firstName'],0,64);
	$lastName = substr($_POST['lastName'],0,64);
	$email = substr($_POST['email'],0,64);
	$category = substr($_POST['category'],0,128);
	$caption1 = substr($_POST['caption1'],0,1024);
	$image1 = $_FILES['image1'];

	isset($_FILES['image2']);
	isset($_FILES['image3']);
	isset($_POST['caption2']);
	isset($_POST['caption3']);


	if ($image1['error'] != 0){
		output($image1['error'], false);
	} else {
		/***Get image info**/
		$cleanName1 = trim($image1['name']);
		if (strlen($cleanName1) > 10){
			$cleanName1 = substr($cleanName1, 0, 9);
		}
		// $string1 = filter_var($cleanName1, FILTER_SANITIZE_STRING);
		$imageInfo1 = pathinfo($image1['name']);
		$filename1 = $timestamp . "." . strtolower($cleanName1) . "." . strtolower($imageInfo1['extension']);
		// $filename1 = $timestamp . "." . strtolower($cleanName1) . "." . strtolower($imageInfo1['extension']);


		/***Save entry to the database***/

		//Connect to mysql DB

		// $db = mysql_connect($dbhost, $dbuser, $dbpass);


		$db1 = new PDO("mysql:host={$dbhost};dbname={$dbname};charset=utf8", $dbuser, $dbpass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

		//Insert new record
		$stmt1 = $db1->prepare("INSERT INTO {$dbtable}(first_name,last_name,email,caption,category,file_name) VALUES(:first_name,:last_name,:email,:caption,:category,:file_name)");
		$stmt1->execute(array(':first_name' => $_POST['firstName'], ':last_name' => $_POST['lastName'], ':email' => $_POST['email'], ':caption' => $_POST['caption1'], ':category' => $_POST['category'], ':file_name' => $filename1));
		// $affected_rows = $stmt1->rowCount();

		// if ($affected_rows == 1){
			//Move the uploaded file into place
			
			move_uploaded_file($image1['tmp_name'], 'images/'. $filename1);

			//Create a thumbnail
			include('smart_resize.php');
			smart_resize_image('images/'. $filename1, null, 150 , 150 , true , 'images/th_' . $filename1, false, false, 80);
			// output("Success! We received your submission.", true);
		// }
		// else{
		// 	output("Could not save information", false);
		// }

	};

	if (!empty($_FILES['image2'])) {
		$image2 = $_FILES['image2'];
		$caption2 = substr($_POST['caption2'],0,1024);
		if ($image2['error'] != 0){
		    output($image2['error'], false);
		} else {

		    /***Get image info**/
			$cleanName2 = trim($image2['name']);
			if (strlen($cleanName2) > 10){
				$cleanName2 = substr($cleanName2, 0, 9);
			}
			// $string2 = filter_var($cleanName2, FILTER_SANITIZE_STRING);
			$imageInfo2 = pathinfo($image2['name']);
			$filename2 = $timestamp . "." . strtolower($cleanName2) . "." . strtolower($imageInfo2['extension']);
			// $filename2 = $timestamp . "." . strtolower($cleanName2) . "." . strtolower($imageInfo2['extension']);


			/***Save entry to the database***/

			//Connect to mysql DB

			// $db = mysql_connect($dbhost, $dbuser, $dbpass);


			$db2 = new PDO("mysql:host={$dbhost};dbname={$dbname};charset=utf8", $dbuser, $dbpass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

			//Insert new record
			$stmt2 = $db2->prepare("INSERT INTO {$dbtable}(first_name,last_name,email,caption,category,file_name) VALUES(:first_name,:last_name,:email,:caption,:category,:file_name)");
			$stmt2->execute(array(':first_name' => $_POST['firstName'], ':last_name' => $_POST['lastName'], ':email' => $_POST['email'], ':caption' => $_POST['caption2'], ':category' => $_POST['category'], ':file_name' => $filename2));
			$affected_rows2 = $stmt2->rowCount();

			// if ($affected_rows2 == 1){
			    // Move the uploaded file into place
			    
			    move_uploaded_file($image2['tmp_name'], 'images/'. $filename2);

			    //Create a thumbnail
			    // include('smart_resize.php');
			    smart_resize_image('images/'. $filename2, null, 150 , 150 , true , 'images/th_' . $filename2, false, false, 80);
			    // output("Success! We received your submission.", true);
			// }
			// else{
			//     output("Could not save information", false);
			// }    

		};
	}

	if (!empty($_FILES['image3'])) {
		$image3 = $_FILES['image3'];
		$caption3 = substr($_POST['caption3'],0,1024);
		if ($image3['error'] != 0){
		    output($image3['error'], false);
		} else {

		    /***Get image info**/
		    $cleanName3 = trim($image3['name']);
		    if (strlen($cleanName3) > 10){
		    	$cleanName3 = substr($cleanName3, 0, 9);
		    }
		    // $string3 = filter_var($cleanName3, FILTER_SANITIZE_STRING);
		    $imageInfo3 = pathinfo($image3['name']);
		    $filename3 = $timestamp . "." . strtolower($cleanName3) . "." . strtolower($imageInfo3['extension']);
		    // $filename3 = $timestamp . "." . strtolower($cleanName3) . "." . strtolower($imageInfo3['extension']);

		    /***Save entry to the database***/

		    //Connect to mysql DB

		    // $db = mysql_connect($dbhost, $dbuser, $dbpass);


		    $db3 = new PDO("mysql:host={$dbhost};dbname={$dbname};charset=utf8", $dbuser, $dbpass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

		    //Insert new record
		    $stmt3 = $db3->prepare("INSERT INTO {$dbtable}(first_name,last_name,email,caption,category,file_name) VALUES(:first_name,:last_name,:email,:caption,:category,:file_name)");
		    $stmt3->execute(array(':first_name' => $_POST['firstName'], ':last_name' => $_POST['lastName'], ':email' => $_POST['email'], ':caption' => $_POST['caption3'], ':category' => $_POST['category'], ':file_name' => $filename3));
		    $affected_rows3 = $stmt3->rowCount();

		    // if ($affected_rows3 == 1){
		        //Move the uploaded file into place
		        
		        move_uploaded_file($image3['tmp_name'], 'images/'. $filename3);

		        //Create a thumbnail
		        // include('smart_resize.php');
		        smart_resize_image('images/'. $filename3, null, 150 , 150 , true , 'images/th_' . $filename3, false, false, 80);
		        // output("Success! We received your submission.", true);
		    // }
		    // else{
		    //     output("Could not save information", false);
		    // }

		};
	}
	

	
	

	output("Success! We received your submission.", true);


	function output($message, $isError){
		if (isset($_POST['ajaxEnabled'])){
			echo json_encode(array("ok" => $isError, "message" => $message));
		}
		else{
			echo $message;
		}
	}



	//Error and exception handling
	function customError($errno, $errmsg){
		if (DEBUG){
			die( '{"ok": false, "message" : "' . $errmsg . '"}');
			echo $errmsg;
		}else{
			die( '{"ok": false, "message" : "error #' . $errno . '"}');
			echo $errno;
		}
	}

	function customException($err){
		if (DEBUG){
			die( '{"ok": false, "message" : "'. $err .'"}');
			echo $err;
		}else{
			die( '{"ok": false, "message" : "unhandled exception"}');
			echo "unhandled exception";
		}
	}



?>