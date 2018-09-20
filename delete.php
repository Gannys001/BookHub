<?php
	require 'config/config.php';

	$bookId = $_GET['bookId'];

	// DB Connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');

	$sql = "DELETE FROM books WHERE book_id = " . $bookId . ";";
	$results = $mysqli->query($sql);
	if ( $results == false ) {
		echo $mysqli->error;
		exit();
	}

	echo "This book is deleted!";

?>