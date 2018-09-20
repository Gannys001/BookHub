<?php
	require 'config/config.php';
?>
<div id="header-div">
	<div id="logo">BookHub, create your repo!!!</div> 
	<div class="nav-wrapper">
	  <form method="GET" action="searchResults.php">
	    <div class="input-field">
	      <input id="search" type="search" name="term" required>
	      <label class="label-icon" for="search"><i class="material-icons">search</i></label>
	      <i class="material-icons">close</i>
	    </div>
	  </form>
	</div>

	<div id="right-corner-btn">
		<?php if( isset($_SESSION['logged_in'])): ?>
			<a class="waves-effect waves-darken-3 btn left-top-btn" href="repo.php"><?php echo $_SESSION['username']; ?>'s Repo</a>
			<a class="waves-effect waves-light btn right-top-btn" href="bookRank.php">College Taste</a>
		<?php else: ?>
			<a class="waves-effect waves-darken-3 btn left-top-btn" href="signup.php">Sign Up</a>
			<a class="waves-effect waves-light btn right-top-btn" href="login.php">Log in</a>
		<?php endif; ?>
	</div>
</div>