<?php
	require 'config/config.php';
	
	// session_destroy();

	if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']){
		$errorMsg = "You have not logged in!";
	}
	else{
		$username = $_SESSION['username'];
		$userId = $_SESSION['userId'];
		// DB Connection
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');

		$sql = "SELECT * FROM books WHERE user_id = " . $userId . ";";
		$results = $mysqli->query($sql);
		if ( $results == false ) {
			echo $mysqli->error;
			exit();
		}


		$mysqli->close();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Book Repo</title>
	
	<?php include 'headInfo.php'; ?>

  	<style type="text/css">
  		#content{
  			margin-top: 130px;
  		}
  		#hDiv{
  			font-family: 'Skranji', cursive;
  			font-size: 35px;
  			color: #00796b;
  		}
  		#editBtn{
  			background-color: #6d4c41 ;
  		}
  		#editBtn:hover{
  			background-color: #212121;
  		}
  		#logoutBtn{
  			background-color: #795548   ;
  		}
  		#logoutBtn:hover{
  			background-color: #424242   ;
  		}
  		@media(min-width: 768px){
  			#content{
  				margin-top: 160px;
  			}
  		}
  		@media(min-width: 992px){
  			#content{
  				margin-top: 130px;
  			}
  		}
  		#school{
  			z-index: 999;
  		}
  		.addBtn{
  			background-color: red;
  		}
  		strong{
  			color: #00796b ;
  		}
  	</style>

</head>
<body>
	<div id="mainContainer">
		<?php include 'header.php'; ?>

		<div id="content">

			<?php if(isset($errorMsg) && !empty($errorMsg)): ?>
				<div class="notLogin" id="errorMsg">
					<?php echo $errorMsg; ?>
				</div>
			<?php else: ?>
				<div>
					<div id="hDiv"><?php echo $username; ?>'s Book Repository</div>

					<a class="waves-effect waves-light btn" style="display: inline-block;" id="editBtn" href="editInfo.php">View/Edit Profile</a>
					<a class="waves-effect waves-light btn" style="display: inline-block;" id="logoutBtn" href="logout.php">Log out</a>
				</div>
				<div class="clear"></div>

				<?php while($row = $results->fetch_assoc()): ?>
					<div class="card">
						<div class="card-image waves-effect waves-block waves-light">
						  <img class="activator thumbnail" alt="<?php echo $row['title']; ?>" src="<?php echo $row['image']; ?>">
						</div>
						<div class="card-content">

				          <a class="btn-floating halfway-fab waves-effect wave-sblue-grey btn addBtn" id="<?php echo $row['book_id']; ?>"><i class="material-icons">cancel</i></a>
						  <p><?php echo $row['title']; ?> 
						  <br>
							by <?php echo $row['author']; ?></p>
						</div>
						<div class="card-reveal">
						  <span class="card-title grey-text text-darken-4">
						  	<i class="material-icons right">close</i>
						  	Description
						  </span>
						  <p><?php echo $row['description']; ?></p>
						</div>
					</div>
				<?php endwhile; ?>

			<?php endif; ?>
		</div>
	</div>	


	<script type="text/javascript">
		var deleteBtns = document.querySelectorAll(".addBtn");
		// console.log(deleteBtns);
		for(var i=0; i<deleteBtns.length; i++){
			deleteBtns[i].onclick = function(){
				console.log(this.id);
				if(!confirm("Are you sure you want to delete this book?")){
					return false;
				}
				var ajaxUrl = "delete.php?bookId=" + this.id;
				ajaxGet(ajaxUrl, function(results){
					// console.log(results);
					location.reload();
					alert(results);
				});

			}
		}



		function ajaxGet(endpointUrl, returnFunction){
			var xhr = new XMLHttpRequest();
			xhr.open('GET', endpointUrl, true);

			xhr.onreadystatechange = function(){
				if (xhr.readyState == XMLHttpRequest.DONE) {
					if (xhr.status == 200) {
						returnFunction(xhr.responseText);
					} else {
						alert('AJAX Error.');
						console.log(xhr.status);
					}
				}
			}
			xhr.send();
		};
	</script>

</body>
</html>