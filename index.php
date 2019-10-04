<?php
	session_start();


	//default cast-simple page will log to testing
	if(!isset($teacher_name))
	{
		include("dbadapter.php");
    $adapter = new dbadapter();
		$adapter->construct();
		$teacher_name = "testing";
	}
	//get Teacher ID
	$tid = $adapter->getTeacherID($teacher_name);

	//if teacher changes, set new session variables
	if (!isset($_SESSION['tid']) || !isset($_SESSION['sid']) || $tid != $_SESSION['tid']) {
		$_SESSION['tid'] = $tid;
		$_SESSION['sid'] = $adapter->createSession($tid);
	}

	$current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">

  <head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Child Adaptive Search Tool">
	<meta name="author" content="Boise State university">


	<script type="text/javascript" src="js/slack-message.js"></script>
	<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="dmp/diff_match_patch.js"></script>
	<script type="text/javascript" src="typo/typo.js"></script>
	<script type="text/javascript" src="spellchecker/content.js"></script>
	<script type="text/javascript" src="spellchecker/eventPage.js"></script>
	<?php echo "<script> setEventNum(";?>
	<?php if(isset($_SESSION['eventNum'])) echo $_SESSION['eventNum'] + 1; else echo 0;?>
	<?php echo "); </script>" ?>


	<title>CAST</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


	<!-- Fontawesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

	<!-- JQuery UI -->
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<!-- JQuery Cookies -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js" integrity="sha256-uEFhyfv3UgzRTnAZ+SEgvYepKKB0FW6RqZLrqfyUNug=" crossorigin="anonymous"></script>
	
	<!-- Style sheet -->
	<link href="mystyle.css" rel="stylesheet">
	<link href="spellchecker/content.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Patrick+Hand|Patrick+Hand+SC&display=swap" rel="stylesheet">
  </head>

<body>
	<!-- START OF HEADER -->
	<div id="castHeader">
		<div class="container">
			<div class = "media-middle">
				<!-- LOGO -->
				<div class = "text-center row" id = "logo-container">
					<a href="">
					<img class="castLogo" src="./assets/castLogo.png"/>
					</a>
				</div>

				<!-- SEARCH BAR -->
				<div class="row">
					<div class="searchContainer">
						<div class="searchBar-wrapper">
							<div spellcheck="false" class="searchBar" contenteditable="false" id="search"></div>
							<div class="searchButton"><i class="fas fa-search"></i></div>
						</div>
					</div>
				</div>

				<!-- NAV BAR -->
				<div class="row" id="navBar"> 
				<nav class="navbar navbar-expand">
					<div class="collapse navbar-collapse" id="navbarNav">
						<ul class="navbar-nav">
						<li class="nav-item active">
							<div class= "linkAndIcon">
								<a class="nav-link" href="#">
								<i class="fas fa-search"></i>
								All
								</a>
							</div>
						</li>
						<li>
							<div class="linkAndIcon">
								<a class="nav-link" href="#" onclick="clickImages()"> 
								<i class="far fa-images"></i>
								Pictures 
								</a>
							</div>
						</li>
						<li class="nav-item">
							<div class = "linkAndIcon">
								<a class="nav-link" href="#">
								<i class="fas fa-video"></i>
								Videos
								</a> 
							</div>
						</li>
						<li class="nav-item">
							<div class = "linkAndIcon">
								<a class="nav-link" href="#""> 
								<i class="far fa-newspaper"></i>
								News
								</a>
							</div>
						</li>
						</ul>
					</div>
				</nav>

				<div>
					<a>
					<img id ="wave" class = "result" src= "/cast-simple/wave.png" size= "100%">
					</a>
				</div>
				
				</div>
				<!-- END OF NAV -->
			</div>
		</div>
	</div>
	<!-- END OF HEADER -->

	<!-- CONTENT -->
	<div class="container">
		<!-- SEARCH RESULTS -->
		<div class="searchResults"></div>

		<!-- HELPER MESSAGES -->
		<div class="row">
			<div class="col-lg-12">
				<div id="helper-type" class="helper-container">
					<img class="arrow" src="./assets/curved-arrow.png"/>
					<div class="helper-text-container">
						<span class="helper-text">Type here to get started</span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div id="helper-search" class="helper-container">
					<div class="helper-text-container">
						<span class="helper-text">Click or press enter to search</span>
					</div>
					<img class="arrow" src="./assets/curved-arrow-right.png"/>
				</div>
			</div>
		</div>
	</div>
	<!-- END OF CONTENT -->

	<!-- SHELF FEATURE -->
	<?php include_once('./shelf/index.php'); ?>

</body>

</html>
