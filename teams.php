<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 9-5-2019
 * Time: 15:45
 */

require 'header.php';
// session_destroy();
if (isset($_SESSION['id'])) 
{
	$sql = "SELECT `teams`.`id` as teamId, `users`.`firstname` as ownerName, `teams`.`name` as teamName, `teams`.`goals` as goals, `teams`.`wins` as wins, `teams`.`loses` as loses, `users`.`id` as ownerId
	FROM `teams`
	INNER JOIN `users` ON `teams`.`owner` = `users`.`id`
	WHERE `teams`.`owner` = :ownerID";
	$prepare = $db->prepare($sql);
	$prepare->execute([
		'ownerID' => $_SESSION['id']
	]);
	$yourTeams = $prepare->fetchAll(2);
}


$sql = "SELECT `teams`.`id` as teamId, `users`.`firstname` as ownerName, `teams`.`name` as teamName, `teams`.`goals` as goals, `teams`.`wins` as wins, `teams`.`loses` as loses, `users`.`id` as ownerId
				FROM `teams`
				INNER JOIN `users` ON `teams`.`owner` = `users`.`id`";
$query = $db->query($sql);
$allTeams = $query->fetchAll(2);
// echo '<pre>';
// var_dump($yourTeams);
// var_dump($allTeams);
// die;
?>

<main>
	<div class="container">
		<div class="row my-4">


			<!-- your teams -->
			<div class="col-md-6 col-lg-4 d-flex flex-column flex-fill">
				<h2>Your Teams</h2>
				<?php
				if (!isset($_SESSION['id'])) {
					echo '<p>Om een team aan te kunnen maken moet je <a href="login.php">ingelogd</a> zijn, heb je nog geen account? <a href="login.php?action=register">Registreer</a> dan direct!</p>';
				} else {
					foreach ($yourTeams as $yourteam) {
						echo "<div class=\"my-1\">
											<a href=\"team_detail.php?id={$yourteam['teamId']}\" class=\"bg-white border d-block p-1 rounded shadow-sm text-dark mx-1\">
												<h2 class=\"h6\">{$yourteam['teamName']}</h2>
												<div class=\"d-flex justify-content-between\">
													<p class=\"m-0\">Goals: {$yourteam['goals']}</p>
													<p class=\"m-0\">Wins: {$yourteam['wins']}</p>
													<p class=\"m-0\">Loses: {$yourteam['loses']}</p>
												</div>
												<div class=\"d-flex justify-content-between\">
													<p class=\"m-0\">Owner: {$yourteam['ownerName']}</p>
													<p class=\"m-0\">Spelers: 3</p>
												</div>
											</a>
										</div>";
					}
				}
				?>
			</div>



			<!-- all teams -->
			<div class="m-0 col-md-6 col-lg-8 row mb-auto">
				<div class="col-sm-12">
					<h2>All Teams</h2>
				</div>
				<?php

				foreach ($allTeams as $allteam) {
					echo "<div class=\"col-lg-6 my-1 p-0\">
									<a href=\"team_detail.php?id={$allteam['teamId']}\" class=\"bg-white border d-block p-1 rounded shadow-sm text-dark mx-1\">
										<h2 class=\"h6\">{$allteam['teamName']}</h2>
										<div class=\"d-flex justify-content-between\">
											<p class=\"m-0\">Goals: {$allteam['goals']}</p>
											<p class=\"m-0\">Wins: {$allteam['wins']}</p>
											<p class=\"m-0\">Loses: {$allteam['loses']}</p>
										</div>
										<div class=\"d-flex justify-content-between\">
											<p class=\"m-0\">Owner: {$allteam['ownerName']}</p>
											<p class=\"m-0\">Spelers: 3</p>
										</div>
									</a>
								</div>";
				}
				?>
			</div>
		</div>
	</div>
</main>

<?php
require 'footer.php';
?>