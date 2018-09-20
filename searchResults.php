<?php 
	require 'config/config.php';

	// session_destroy();
	// initialize searching 
	ini_set("allow_url_fopen", 1);
	$arrContextOptions=array(
	    "ssl"=>array(
	        "verify_peer"=>false,
	        "verify_peer_name"=>false,
	    ),
	);

	$term = "php";
	if(isset($_GET) && $_GET){
		$term = str_replace(" ", "+", $_GET['term']);
	}
	
	$query_str = file_get_contents('https://www.googleapis.com/books/v1/volumes?q='.$term.'&maxResults=36',  false, stream_context_create($arrContextOptions));
	$searchInfo = json_decode($query_str);
	$books = null;
	foreach($searchInfo as $i=>$item){
		$books = $item;
	}

?>

<html>
<head>
	<title>Search Results</title>
   
	<?php include 'headInfo.php'; ?>
</head>
<body>
	<div id="mainContainer">
		
		<?php include 'header.php'; ?>

		<!-- hidden input for storing userId -->
		<input type="hidden" id="userId" value="<?php if(isset($_SESSION['userId'])) {echo $_SESSION['userId'];} else{echo 0;} ?>">

		<div id="content">

			<?php 
				$bookNum = 0;
				foreach ($books as $key => $book):
				$bookNum ++; 
			?>
				<div class="card" id="book<?php echo $bookNum ?>">
					<div class="card-image waves-effect waves-block waves-light">
					  <img class="activator thumbnail" alt="<?php isset($book->volumeInfo->title); ?>" src="<?php echo isset($book->volumeInfo->imageLinks->smallThumbnail) ? $book->volumeInfo->imageLinks->smallThumbnail : "imgs/no-image.png"?>">
					</div>
					<div class="card-content">

			          <a class="btn-floating halfway-fab waves-effect wave-sblue-grey btn addBtn" id="<?php echo $bookNum ?>"><i class="material-icons" >book</i></a>
					  <p>
					  	<font class="title"><?php 
					  		$title = isset($book->volumeInfo->title) ? $book->volumeInfo->title : "No title";
					  		if(strlen($title) > 18){
					  			echo substr($title, 0, 18) . "..";
					  		}else{
					  			echo $title;
					  		}
					  	?></font>
					  	<br>
					  	by <font class="author"><?php
					  			$author = isset($book->volumeInfo->authors[0]) ? $book->volumeInfo->authors[0] : "";
					  			if(strlen($author) > 15){
						  			echo substr($author, 0, 15) . "..";
						  		}else{
						  			echo $author;
						  		}
					  		?></font>
					  </p>
					</div>
					<div class="card-reveal">
					  <span class="card-title grey-text text-darken-4">
					  	<i class="material-icons right">close</i>
					  	Description
					  </span>
					  <p class="description"><?php echo isset($book->volumeInfo->description) ? $book->volumeInfo->description : "No description" ?></p>
					</div>
				</div>
			<?php endforeach;?>
		</div>
	</div>	

	<script type="text/javascript">
		var addBtns = document.querySelectorAll(".addBtn");
		for(var i=0; i<addBtns.length; i++){
			addBtns[i].onclick = function(){

				var userId = document.querySelector("#userId").value;
				if(userId == 0){
					alert("Please log in or sign up first!");
				}
				else{
					var card = document.querySelector("#book" + this.id);
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