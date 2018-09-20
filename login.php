<?php
	require 'config/config.php';

	// DB Connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');
	
	$errorMsg = "";
	if(isset($_POST) && $_POST){
		$username = $_POST['username'];
		$password = $_POST['password'];

		$user_sql = "SELECT * FROM users WHERE username = '" .
						$username . "';";
		
		$results = $mysqli->query($user_sql);
		if ( $results == false ) {
			echo $mysqli->error;
			exit();
		}
		$row = $results->fetch_assoc();
		if(!$row){
			$errorMsg = "Invalid username!";
		} 
		else{
			if($row['password'] == $password){
				$_SESSION['logged_in'] = true;
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['userId'] = $row['user_id'];	
				header('Location: searchResults.php');
			}
			else{
				$errorMsg = "Incorrect password!";	
			}
		}
	}

	$mysqli->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		
		<?php include 'headInfo.php'; ?>

	  	 <style type="text/css">
	    	#school-select{
	    		width: 200px;
	    		/*background-color: green;*/
	    	}
	    	.input-field{
		  			/*background-color: transparent;*/
	  		}
	  		#inputs{
	  			text-align: center;
	  			/*background-color: pink;*/
	  			width: 300px;
	  			margin-left: auto;
	  			margin-right: auto;
	  		}
	  		.single-field{
	  			/*background-color: green;*/
	  			width: 100%;
	  			margin-left: auto;
	  			margin-right: auto;
	  		}
	  		h2{
	  			color: grey ;
	  			font-weight: bold;
	  			background: rgba(255,255,255,0.5);
	  			height: 65px;
	  			width: 28%;
	  			margin-left: auto;
	  			margin-right: auto;
	  			border-radius: 5px;
	  		}
	  		#content{
	  			margin-top: 230px;
	  		}
	  		.errorMsg{
	  			width: 100px;
	  			color: red;
	  			margin-left: auto;
	  			margin-right: auto;
	  		}
    	</style>
</head>
<body>
	<div id="mainContainer">
		
		<?php include 'header.php'; ?>


		<div id="content">
			<div class="row row center-align">
				<h2>Login</h2>
			</div>

			<div class="row s12" id="inputs">
				<form class="col s12" method="POST" action="login.php">
					<div class="single-field" >
						<div class="input-field col s12">
						  <input id="last_name" type="text" class="validate" name="username" required>
						  <label for="last_name">Username</label>
						</div>
						</div>
						<div class="single-field" >
						<div class="input-field col s12" >
						  <input id="password" type="password" class="validate" name="password" required>
						  <label for="password">Password</label>
						</div>
					</div>

					<div class="row center-align">
						<button class="btn waves-effect waves-light brown lighten-1" type="submit" name="action">Login
							<i class="material-icons right">send</i>
						</button>
					</div>
				</form>
			</div>

			<input type="hidden" id="error" value="<?php echo $errorMsg; ?>">
		</div>
	</div>	

	<script type="text/javascript">
		if(document.querySelector("#error").value != ""){
			alert("Username or password is Incorect");
		}
	</script>
</body>
</html>