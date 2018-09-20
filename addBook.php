<?php
	require 'config/config.php';

	$title = str_replace("'", "\'", $_GET['title']);
	$author = str_replace("'", "\'", $_GET['author']);
	$image = str_replace(" ", "&", $_GET['image']);
	$description = str_replace("'", "\'", $_GET['description']);
	$userId = $_GET['userId'];
	
	// echo $title . "-----" . $author . "-----" . $image . "-----" . $description;
	// echo $image;

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');

	$querySql = "SELECT * FROM books WHERE title = '" . $title . "' AND user_id = " . $userId . ";";

	$results = $mysqli->query($querySql);
	if ( $results == false ) {
		echo $mysqli->error;
		exit();
	}

	$row = $results->fetch_assoc();
	if(!$row){
		$addSql = "INSERT INTO books (user_id, title, author, image, description)
					VALUES(" . $userId . ", '" . 
								$title . "', '" .
								$author . "', '".
								$image . "', '" .
								$description . "');";

		// echo($addSql);
		$results = $mysqli->query($addSql);
		if ( $results == false ) {
			echo $mysqli->error;
			exit();
		}
		echo "Successfullly added to your repository";
	}
	else{
		echo "This books is already in your repository!";
	}
	// echo "teeeeeeeeeeeeeest";

	$mysqli->close();
?>