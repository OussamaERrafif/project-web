<?php
require('inc/init.inc.php');
if(isset($_GET['page']) && $_GET['page'] == 'abonne') require('abonne.php');
if(isset($_GET['page']) && $_GET['page'] == 'livre') require('livre.php');
if(isset($_GET['page']) && $_GET['page'] == 'emprunt') require('emprunt.php');
if(isset($_GET['page']) && $_GET['page'] == 'Home') require('Home.php');

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>TP Bibliotheque</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet" type="text/css">
		<script>  $(document).ready(function() {  $(".date").datepicker({ dateFormat: "yy/mm/dd" }).val()  });</script>
	</head>
	<body>
		<header>
			<nav class="navbar navbar-inverse navbar-fixed-top navbar-expand-lg bg-body-tertiary" style="background-color: #FFC0CB;">
				  <div class="container-fluid">
					  <div id="navbar-brand" class="collapse navbar-collapse">
						  <ul class="nav nav-tabs">
							<li class="nav-item"><p class="navbar-brand" >Biblioteca</p></li>
							<li class="nav-item"><a class="nav-link active" href="?page=Home">Accueil</a></li>
							<li class="nav-item"><a class="nav-link active" href="?page=abonne">Abonné</a></li>
							<li class="nav-item"><a class="nav-link active" href="?page=livre">Livre</a></li>
							<li class="nav-item"><a class="nav-link active" href="?page=emprunt">Emprunt</a></li>
						</ul>
					</div>
				  </div>
			</nav>
		</header>
		<section>
			<div class="container">
				<?php echo $contenu; ?>
			</div>
		</section>
		<footer></footer>
	</body>
</html>