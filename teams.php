<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 9-5-2019
 * Time: 15:45
 */

require 'header.php';

$sql = "SELECT `teams`.`id` as teamId, 
							 `users`.`firstname` as ownerName, 
							 `teams`.`name` as teamName, 
							 `teams`.`points` as points, 
							 `users`.`id` as ownerId
				FROM `teams`
				INNER JOIN `users` ON `teams`.`owner` = `users`.`id`";
$query = $db->query($sql);
$teams = $query->fetchAll(2);
?>

<main>
	<div class="container">
		<div class="row my-4">
			<div class="col-12 p-0">
				<h2 class="h4 p-1 bg-light rounded m-1 border shadow-sm">Alle Teams</h2>
			</div>
			<div class="col-12 row p-0 m-0">

				<?php
				foreach ($teams as $team) 
				{
					echo "
        	<div class=\"col-xl-3 col-lg-4 col-md-6 my-1 p-0\">
          	<a href=\"team_detail.php?id={$team['teamId']}\" class=\"bg-white border d-block p-1  px-2 rounded shadow-sm text-dark mx-1\">
            	<h2 class=\"h6\">{$team['teamName']}</h2>
            	<div class=\"d-flex justify-content-between\">
              	<p class=\"m-0\">Owner: {$team['ownerName']}</p>
              	<p class=\"m-0\">points: {$team['points']}</p>
            	</div>
          	</a>
        	</div>";
				}
				?>

			</div>
		</div>
	</div>
	</div>
</main>

<?php
require 'footer.php';
?>