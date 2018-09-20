<?php
	require 'config/config.php';

	// DB Connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');
	
	$queryBook = "SELECT * FROM books 
					JOIN users 
					ON books.user_id = users.user_id
					JOIN schools
					ON users.school_id = schools.school_id
					where schools.school_id = ";

	$uscBooks = $mysqli->query($queryBook . 1 . ";");
	if ( $uscBooks == false ) {
		echo $mysqli->error;
		exit();
	}
	$uclaBooks = $mysqli->query($queryBook . 2 . ";");
	if ( $uclaBooks == false ) {
		echo $mysqli->error;
		exit();
	}
	$ucbBooks = $mysqli->query($queryBook . 3 . ";");
	if ( $ucbBooks == false ) {
		echo $mysqli->error;
		exit();
	}
	$ucsdBooks = $mysqli->query($queryBook . 4 . ";");
	if ( $ucsdBooks == false ) {
		echo $mysqli->error;
		exit();
	}


	$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
	<title>College Tastes</title>
	 
	<?php include 'headInfo.php'; ?>

  	<style type="text/css">

  		#content{
  			margin-top: 130px;
  		}
  		#hDiv{
  			font-family: 'Skranji', cursive;
  			font-size: 35px;
  			color: #455a64;
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
  		strong{
  			color: #00796b ;
  			font-size: 40px;
  		}
  	</style>

</head>
<body>
	<div id="mainContainer">
		
		<?php include 'header.php'; ?>


		<div id="content">
			<div>
				<div id="hDiv">Favorites of 
					<strong id="schoolName">
						<span style="font-family:Wingdings; font-size: 40px; font-weight: bold;">&#72;</span>
						<span style="font-family:Wingdings; font-size: 40px; font-weight: bold;">&#72;</span>
						<span style="font-family:Wingdings; font-size: 40px; font-weight: bold;">&#72;</span>
					</strong>
				</div>
				<!-- <div class="single-field" id="school"> -->
				  	<div class="input-field col s12" id="school">
					    <select name="school">
					      <option value="0" disabled selected>   School</option>
					      <option value="usc" id="usc">USC</option>
					      <option value="ucla" id="ucla">UCLA</option>
					      <option value="ucb" id="ucb">UCB</option>
					      <option value="ucsd" id="ucsd">UCSD</option>
					    </select>
					    <label>School</label>
					</div>
				<!-- </div> -->
			</div>
			<div class="clear"></div>

			<?php while($row = $uscBooks->fetch_assoc()): ?>
				<div class="card <?php echo "usc"; ?>">
					<div class="card-image waves-effect waves-block waves-light">
					  <img class="activator thumbnail" alt="<?php echo $row['title']; ?>" src="<?php echo $row['image']; ?>">
					</div>
					<div class="card-content">

			          <a class="btn-floating halfway-fab waves-effect wave-sblue-grey btn addBtn"><i class="material-icons">book</i></a>
					  <p><font class="title"><?php echo $row['title']; ?></font>
					  	<br> 
					  by <font class="author"><?php echo $row['author']; ?></font>
					  </p>
					</div>
					<div class="card-reveal">
					  <span class="card-title grey-text text-darken-4">
					  	<i class="material-icons right">close</i>
					  	Description
					  </span>
					  <p><font class="description"><?php echo $row['description']; ?></font></p>
					</div>
				</div>
			<?php endwhile; ?>

			<?php while($row = $uclaBooks->fetch_assoc()): ?>
				<div class="card <?php echo "ucla"; ?>">
					<div class="card-image waves-effect waves-block waves-light">
					  <img class="activator thumbnail" src="<?php echo $row['image']; ?>">
					</div>
					<div class="card-content">

			          <a class="btn-floating halfway-fab waves-effect wave-sblue-grey btn addBtn"><i class="material-icons">book</i></a>
					  <p><font class="title"><?php echo $row['title']; ?></font>
					  	<br> 
					  by <font class="author"><?php echo $row['author']; ?></font>
					  </p>
					</div>
					<div class="card-reveal">
					  <span class="card-title grey-text text-darken-4">
					  	<i class="material-icons right">close</i>
					  	Description
					  </span>
					  <p><font class="description"><?php echo $row['description']; ?></font></p>
					</div>
				</div>
			<?php endwhile; ?>

			<?php while($row = $ucbBooks->fetch_assoc()): ?>
				<div class="card <?php echo "ucb"; ?>">
					<div class="card-image waves-effect waves-block waves-light">
					  <img class="activator thumbnail" src="<?php echo $row['image']; ?>">
					</div>
					<div class="card-content">

			          <a class="btn-floating halfway-fab waves-effect wave-sblue-grey btn addBtn"><i class="material-icons">book</i></a>
					  <p><font class="title"><?php echo $row['title']; ?></font>
					  	<br> 
					  by <font class="author"><?php echo $row['author']; ?></font>
					  </p>
					</div>
					<div class="card-reveal">
					  <span class="card-title grey-text text-darken-4">
					  	<i class="material-icons right">close</i>
					  	Description
					  </span>
					  <p><font class="description"><?php echo $row['description']; ?></font></p>
					</div>
				</div>
			<?php endwhile; ?>

			<?php while($row = $ucsdBooks->fetch_assoc()): ?>
				<div class="card <?php echo "ucsd"; ?>">
					<div class="card-image waves-effect waves-block waves-light">
					  <img class="activator thumbnail" src="<?php echo $row['image']; ?>">
					</div>
					<div class="card-content">

			          <a class="btn-floating halfway-fab waves-effect wave-sblue-grey btn addBtn"><i class="material-icons">book</i></a>
					  <p><font class="title"><?php echo $row['title']; ?></font>
					  	<br> 
					  by <font class="author"><?php echo $row['author']; ?></font>
					  </p>
					</div>
					<div class="card-reveal">
					  <span class="card-title grey-text text-darken-4">
					  	<i class="material-icons right">close</i>
					  	Description
					  </span>
					  <p><font class="description"><?php echo $row['description']; ?></font></p>
					</div>
				</div>
			<?php endwhile; ?>


		</div>
	</div>	

	<!-- hidden input for storing userId -->
	<input type="hidden" id="userId" value="<?php if(isset($_SESSION['userId'])) {echo $_SESSION['userId'];} else{echo 0;} ?>">


	<script type="text/javascript">
		var options = document.querySelectorAll('option');
		var select = document.querySelector('select');
  		var instance = M.FormSelect.init(select, options);
	
		var cards = document.querySelectorAll(".card");
		select.onchange = function(){
			document.querySelector("#schoolName").innerHTML = this.value.toUpperCase();
			for(var i=0; i<cards.length; i++){
				cards[i].setAttribute("style", "display: none;");
				if(cards[i].classList.contains(this.value)){
					cards[i].setAttribute("style", "display: block;");
				}
			}
		}

		var addBtns = document.querySelectorAll(".addBtn");
		for(var i=0; i<addBtns.length; i++){
			addBtns[i].onclick = function(){

				// var card = this.parentElement.parentElement;
				// console.log(card);

				var userId = document.querySelector("#userId").value;
				if(userId == 0){
					alert("Please log in or sign up first!");
				}
				else{
					var card = this.parentElement.parentElement;
					var title = card.querySelector(".title").innerHTML;
					var author = card.querySelector(".author").innerHTML;
					var description = card.querySelector(".description").innerHTML;
					var image = card.querySelector("img").src.replace(/&/g,'+');
					
					// console.log(title);
					// console.log(author);
					// console.log(description);
					// console.log(image);

					var ajaxUrl = "addBook.php?title="+title+"&author="+author+"&description="+description+"&image="+image+"&userId="+userId;
					ajaxUrl = ajaxUrl.replace(/ /g, '+');
					ajaxGet(ajaxUrl, function(results){
						console.log(results);
						alert(results);
					});
				}
			}
		}

		function ajaxGet(endpointUrl, returnFunction){
			var xhr = new XMLHttpRequest();
			xhr.open('GET', endpointUrl, true);

			xhr.onreadystatechange = function(){
				if (xhr.readyState == XMLHttpRequest.DONE) {
					if (xhr.status == 200) {
						console.log("success");
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