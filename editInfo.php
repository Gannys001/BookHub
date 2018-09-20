<?php
		require 'config/config.php';

		
		if(isset($_SESSION['userId'])){
			$userId = $_SESSION['userId'];
			// DB Connection
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if ( $mysqli->connect_errno ) {
				echo $mysqli->connect_error;
				exit();
			}
			$mysqli->set_charset('utf8');

			if(isset($_POST['firstname'])){
				// check if the username is taken
				$userSql = "SELECT * FROM users WHERE username = '" . $_POST['username'] . "';";
				$results = $mysqli->query($userSql);
				if ( $results == false ) {
					echo $mysqli->error;
					exit();
				}

				$row = $results->fetch_assoc();
				if($row && $row['username'] != $_SESSION['username']){
					$errorMsg = "This username has been taken!";
				}
				else{
					$firstname = $_POST['firstname'];
					$lastname = $_POST['lastname'];
					$username = $_POST['username'];
					$schoolId = $_POST['school'];

					$editSql = "UPDATE users 
							SET firstname = '" . $firstname . "',
								lastname = '" . $lastname . "',
								username = '" . $username . "',
								school_id = " . $schoolId . "
							WHERE user_id = " . $userId . ";";
					
					$results = $mysqli->query($editSql);
					if ( $results == false ) {
						echo $mysqli->error;
						exit();
					}

					$_SESSION['username'] = $_POST['username'];
					header('Location: repo.php');
				}
			}



			$sql = "SELECT * FROM users WHERE user_id = " . $userId . ";";
			$results = $mysqli->query($sql);
			if ( $results == false ) {
				echo $mysqli->error;
				exit();
			}

			$row = $results->fetch_assoc();
			$username = $row['username'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$schoolId = $row['school_id'];

			$mysqli->close();
		}
		
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Info</title>
	
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
	  			width: 20%;
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
			<?php if(!isset($userId)): ?>
				<div class="notLogin" id="errorMsg">
					<?php echo "You have not logged in!"; ?>
				</div>
			<?php else: ?>
				<div class="row row center-align">
					<h2>Edit Profile</h2>
				</div>

				<div class="row s12" id="inputs">
					<form class="col s12" method="POST" action="editInfo.php">
					  <div class="single-field" >
					    <div class="input-field col s12">
					      <input id="firstname" type="text" class="validate" name="firstname" value="<?php echo $firstname; ?>" required >
					      <label for="firstname">Firstname</label>
					    </div>
					  </div>
					  <div class="single-field" >
					    <div class="input-field col s12">
					      <input id="lastname" type="text" class="validate" name="lastname" value="<?php echo $lastname; ?>" required >
					      <label for="lastname">Lastname</label>
					    </div>
					  </div>
					  <div class="single-field" >
					    <div class="input-field col s12">
					      <input id="username" type="text" class="validate" name="username" value="<?php echo $username; ?>" required >
					      <label for="username">Username</label>
					    </div>
					  </div>



					  <div class="single-field">
					  	<div class="input-field col s12" id="school">
						    <select name="school" >
						      <option value="0" disabled selected>Choose your school</option>
						      <option value="1" <?php echo $schoolId==1? "selected": "" ?>>USC</option>
						      <option value="2" <?php echo $schoolId==2? "selected": "" ?>>UCLA</option>
						      <option value="3" <?php echo $schoolId==3? "selected": "" ?>>UCB</option>
						      <option value="4" <?php echo $schoolId==4? "selected": "" ?>>UCSD</option>
						    </select>
						    <label>School</label>
						</div>
					  </div>

						<div class="row center-align">
					        <button class="btn waves-effect waves-light brown lighten-1" type="submit" name="action" id="signup" >Submit
								<i class="material-icons right">send</i>
							</button>
						</div>

					</form>

					<!-- for storing errorMsg for taken username -->
					<input type="hidden" id="errorMsg" value="<?php echo isset($errorMsg)? $errorMsg : ""; ?>">
				</div>
			<?php endif; ?>

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
	</script>

</body>
</html>