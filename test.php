<?php 
	ini_set("allow_url_fopen", 1);
	$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
); 
	$json_str = file_get_contents('https://www.googleapis.com/books/v1/volumes?q=zemin&maxResults=3',  false, stream_context_create($arrContextOptions));
	// var_dump($item);
	$searchInfo = json_decode($json_str);
	$books = null;
	foreach($searchInfo as $i=>$item){
		$books = $item;
	}

?>

<html>
<head>
	<title>Search Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

  	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  	<!--Import materialize.css-->
  	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

  	<link rel="stylesheet" type="text/css" href="css/skeleton.css">
  	<link href="https://fonts.googleapis.com/css?family=Gamja+Flower|Shrikhand" rel="stylesheet">

  	<link href="https://fonts.googleapis.com/css?family=Skranji" rel="stylesheet">

</head>
<body>
	<div id="mainContainer">
		<div id="header-div">
			<div id="logo">BookHub, create your repo!!!</div> 
			<div class="nav-wrapper">
			  <form>
			    <div class="input-field">
			      <input id="search" type="search" required>
			      <label class="label-icon" for="search"><i class="material-icons">search</i></label>
			      <i class="material-icons">close</i>
			    </div>
			  </form>
			</div>

			<div id="right-corner-btn">
				<a class="waves-effect waves-darken-3 btn left-top-btn" style="display: none;">My Repository</a>
				<a class="waves-effect waves-light btn right-top-btn" style="display: none;">Log out</a>
				
				<a class="waves-effect waves-darken-3 btn left-top-btn" style="display: inline-block;">Sign Up</a>
				<a class="waves-effect waves-light btn right-top-btn" style="display: inline-block;">Login</a>
			</div>
		</div>


		<div id="content">

				<?php 
					$bookNum = 0;
					foreach ($books as $key => $book):
					$bookNum ++; 
				?>
					<div class="card" id="book<?php echo $bookNum ?>">
						<div class="card-image waves-effect waves-block waves-light">
						  <img class="activator thumbnail" src="<?php echo isset($book->volumeInfo->imageLinks->smallThumbnail) ? $book->volumeInfo->imageLinks->smallThumbnail : "no-image.png"?>">
						</div>
						<div class="card-content">

				          <a class="btn-floating halfway-fab waves-effect wave-sblue-grey btn addBtn"><i class="material-icons">add</i></a>
						  <p>
						  	<font class="title"><?php 
						  		$title = isset($book->volumeInfo->title) ? $book->volumeInfo->title : "";
						  		if(strlen($title) > 19){
						  			echo substr($title, 0, 19) . "...";
						  		}else{
						  			echo $title;
						  		}
						  	?></font>
						  	<br>
						  	by <font class="author"><?php
						  			$author = isset($book->volumeInfo->authors[0]) ? $book->volumeInfo->authors[0] : "";
						  			if(strlen($author) > 17){
							  			echo substr($author, 0, 17) . "..";
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
						  <p class="description"><?php echo isset($book->volumeInfo->description) ? $book->volumeInfo->description : "" ?></p>
						</div>
					</div>
				<?php endforeach;?>
		</div>
	</div>	

	<script type="text/javascript">
		var addBtns = document.querySelectorAll(".addBtn");
		for(var i=0; i<addBtns.length; i++){
			addBtns[i].onclick = function(){
				alert("This book has been added to your repository!");
			}
		}

		var card = document.querySelector("#book2");
		var title = card.querySelector(".title").innerHTML;
		var author = card.querySelector(".author").innerHTML;
		var description = card.querySelector(".description").innerHTML;
		var image = card.querySelector("img").src;
		console.log(title);
		console.log(author);
		console.log(description);
		console.log(image);



	</script>

</body>
</html>