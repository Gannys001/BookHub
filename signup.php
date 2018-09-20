<?php
	require 'config/config.php';

	if(isset($_POST['firstname'])){
		// DB Connection
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');

		// check if the username is taken
		$userSql = "SELECT * FROM users WHERE username = '" . $_POST['username'] . "';";
		$results = $mysqli->query($userSql);
		if ( $results == false ) {
			echo $mysqli->error;
			exit();
		}
		if($results->fetch_assoc()){
			$errorMsg = "The username has been taken!";
		}
		else{
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$username = $_POST['username'];
			$schoolId = $_POST['school'];
			$password = $_POST['password'];

			$sql = "INSERT INTO users (username, firstname, lastname, password, school_id)
					VALUES('" . $username . "', '" .
					$firstname . "', '" . 
					$lastname . "', '" . 
					$password . "', " .
					$schoolId . ");";
			
			// echo $sql;
			$results = $mysqli->query($sql);
			if ( $results == false ) {
				echo $mysqli->error;
				exit();
			}

			header('Location: login.php');
		}

		$mysqli->close();
	
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	
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
	  			width: 30%;
	  			color: red;
	  			margin-left: auto;
	  			margin-right: auto;
	  		}
	  		#school{
	  			z-index: 999;
	  		}
    </style>
</head>
<body>
	<div id="mainContainer">
		
		<?php include 'header.php'; ?>


		<div id="content">
			<div class="row row center-align">
				<h2>Sign up</h2>
			</div>

			<div class="row s12" id="inputs">
				<form class="col s12" method="POST" action="signup.php">
				  <div class="single-field" >
				    <div class="input-field col s12">
				      <input id="firstname" type="text" class="validate" name="firstname" required>
				      <label for="firstname">Firstname</label>
				    </div>
				  </div>
				  <div class="single-field" >
				    <div class="input-field col s12">
				      <input id="lastname" type="text" class="validate" name="lastname">
				      <label for="lastname" required>Lastname</label>
				    </div>
				  </div>
				  <div class="single-field" >
				    <div class="input-field col s12">
				      <input id="username" type="text" class="validate" name="username" required>
				      <label for="username" required>Username</label>
				    </div>
				  </div>



				  <div class="single-field">
				  	<div class="input-field col s12" id="school">
					    <select name="school" class="validate" required>
					      <option value="0" disabled selected>Choose your school</option>
					      <option value="1">USC</option>
					      <option value="2">UCLA</option>
					      <option value="3">UCB</option>
					      <option value="4">UCSD</option>
					    </select>
					    <label>School</label>
					</div>
				  </div>

				  <div class="single-field" >
				    <div class="input-field col s12" >
				      <input id="password" type="password" class="validate" name="password">
				      <label for="password" required>Password</label>
				    </div>
				  </div>
				  <div class="single-field">
				    <div class="input-field col s12" >
				      <input id="confirmPassword" type="password" class="validate">
				      <label for="confirmPassword" required>Confirm Password</label>
				    </div>
				  </div>


					<div class="row center-align">
				        <button class="btn waves-effect waves-light brown lighten-1" type="submit" name="action" id="signup" disabled>Sign Up
							<i class="material-icons right">send</i>
						</button>
					</div>
				</form>

				<!-- for storing errorMsg for taken username -->
				<input type="hidden" id="errorMsg" value="<?php echo isset($errorMsg)? $errorMsg : ""; ?>">
			</div>
		</div>
	</div>	

	<script type="text/javascript">
		// initialize select button 
		var options = document.querySelectorAll('option');
		var elem = document.querySelector('select');
  		var instance = M.FormSelect.init(elem, options);

  		if(document.querySelector("#errorMsg").value != ""){
  			alert(document.querySelector("#errorMsg").value);
  		}

  		var confirm = document.querySelector('#confirmPassword');
  		var password = document.querySelector('#password');

  		confirm.oninput = function(){
  			if(this.value != password.value){
  				document.querySelector("#signup").disabled = true;
  			}
  			else{
  				document.querySelector("#signup").disabled = false;
  			}
  		}

  		var signupForm = document.querySelectorAll('form');
  		
  		signupForm[1].onsubmit = function(e){
  			if(options[0].selected){
  				alert("Please choose your school!");
  				return false;
  			}
  		};
	
	</script>

</body>
</html>