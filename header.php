<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 9-5-2019
 * Time: 15:40
 */

require 'includes/config.php';
?>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="./css/bootstrap.css">

	<title>Fifa Project</title>
</head>

<body>
	<header class="bg-info">
		<nav class="navbar navbar-expand-md navbar-dark">
			<div class="container">
				<a class="navbar-brand" href="index.php">Fifa Project</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarText">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="index.php">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="teams.php">Teams</a>
						</li>
						<!-- alleen als je bent ingelogd als admin -->
                        <?php
						    if (isset($_SESSION['admin']))
						        {
						            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"dashboard/dashboard_interconnector.php?navderection=2sH65u7^lj\">Dashboard</a></li>";
						        }
						?>
					</ul>
					<ul class="navbar-nav">
						<li class="nav-item">
                            <?php
							    if (isset($_SESSION['id']))
                                {
                                    echo "<a href=\"includes/logout.php\" class=\"nav-link\">Logout</a>";
                                }
							    else
                                {
                                    echo "<a href=\"login.php\" class=\"nav-link\">Login</a>";
                                }
							?>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</header>